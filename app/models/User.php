<?php

// Ang User class ay nagha-handle ng lahat ng database operations para sa users
class User {
    // Variable para sa database connection
    private $db;

    public function __construct() {
        // Ini-initialize ang database connection
        $this->db = new Database();
    }

    // Method para hanapin ang user gamit ang email o username
    public function findUserByEmailOrUsername($login) {
        // SQL query para hanapin ang user sa database
        // Hinahanap kung may match sa email O username
        $this->db->query("SELECT * FROM users WHERE email = :login OR username = :login");
        // I-bind ang login parameter para sa security
        $this->db->bind(':login', $login);

        // Kunin ang resulta ng query
        $row = $this->db->result();

        // Kung may nahanap na user
        if($row) {
            return $row;
        }

        // Kung walang nahanap, return false
        return false;
    }

    // Method para mag-register ng bagong user
    public function register($data) {
        // SQL query para mag-insert ng bagong user sa database
        // Lahat ng fields ay required: username, password, full_name, email, phone, role
        $this->db->query("INSERT INTO users (username, password, full_name, email, phone, role) 
                        VALUES (:username, :password, :full_name, :email, :phone, :role)");
        
        // I-bind ang lahat ng data para sa security
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role', $data['role']);

        // I-execute ang query at tignan kung successful
        if ($this->db->execute()) {
            return true;
        }
        
        else {
            return false;
        }
    }
}