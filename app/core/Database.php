<?php

class Database {

    private $host = DB_HOST;
    private $dbName = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->pass);
            echo "connected successfully";
        }

        catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

}
