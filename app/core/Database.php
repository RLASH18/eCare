<?php
/**
 * Database Class - Database Connection Handler
 * 
 * Ang class na ito ang humahawak ng database connection sa application.
 * Gumagamit ito ng PDO (PHP Data Objects) para sa secure at efficient na database operations.
 * Ito ay nagbibigay ng centralized na database connection para sa buong application.
 */
class Database {

    /**
     * Database connection parameters
     * Ang mga values ay kinukuha mula sa config.php file
     */
    private $host = DB_HOST;    // Database server hostname
    private $dbName = DB_NAME;  // Database name
    private $user = DB_USER;    // Database username
    private $pass = DB_PASS;    // Database password

    /**
     * Database connection object
     * Ito ang PDO instance na gagamitin para sa database operations
     */
    protected $conn;

    /**
     * Statement property - Temporary storage ng prepared SQL statement
     * 
     * Ang property na ito ay:
     * 1. Nag-iimbak ng prepared SQL statement
     * 2. Ginagamit para sa execution at fetching ng data
     * 3. Accessible sa lahat ng query methods
     */
    protected $stmt;

    /**
     * Constructor - Ina-initialize ang database connection
     * 
     * Ang constructor ay:
     * 1. Gumagawa ng bagong PDO connection gamit ang database credentials
     * 2. Nagha-handle ng connection errors
     * 3. Nagpapakita ng success message kung successful ang connection
     */
    public function __construct() {
        try {
            // Gumawa ng bagong PDO connection
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->pass);
        }

        catch (PDOException $e) {
            // Kung may error, ipakita ang error message at i-stop ang execution
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Query Method - Naghahanda ng SQL query
     * 
     * Ang method na ito ay:
     * 1. Naghahanda ng SQL statement gamit ang PDO prepare
     * 2. Iniimbak ang prepared statement sa $stmt property
     */
    public function query($sql) {
        $this->stmt = $this->conn->prepare($sql);
    }

    /**
     * Execute Method - Isinasagawa ang prepared query
     * 
     * Ang method na ito ay:
     * 1. Isinasagawa ang prepared SQL statement
     * 2. Nagbabalik ng true kung successful, false kung may error
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Result Method - Kumukuha ng isang row ng data
     * 
     * Ang method na ito ay:
     * 1. Isinasagawa ang query
     * 2. Nagbabalik ng isang row ng data bilang associative array
     */
    public function result() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * ResultSet Method - Kumukuha ng lahat ng rows ng data
     * 
     * Ang method na ito ay:
     * 1. Isinasagawa ang query
     * 2. Nagbabalik ng lahat ng rows bilang array ng associative arrays
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * RowCount Method - Binibilang ang number ng affected rows
     * 
     * Ang method na ito ay:
     * 1. Nagbabalik ng bilang ng rows na naapektuhan ng query
     * 2. Useful para sa INSERT, UPDATE, at DELETE operations
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Bind Method – Nag-uugnay ng isang halaga sa isang parameter sa prepared statement.
     * 
     * Ang method na ito ay:
     * 1. Nagbi-bind ng value sa prepared statement parameter
     * 2. Ginagamit para sa secure na parameter handling
     */
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

}
