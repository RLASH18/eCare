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
            echo "connected successfully";  // Ipakita ang success message
        }

        catch (PDOException $e) {
            // Kung may error, ipakita ang error message at i-stop ang execution
            die("Connection failed: " . $e->getMessage());
        }
    }

}
