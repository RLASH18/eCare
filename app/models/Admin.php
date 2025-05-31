<?php

class Admin {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    //-----------dashboard infos-----------
    public function getTotalUsers() {
        $this->db->query("SELECT COUNT(*) AS total_users FROM users");
        return $this->db->result()['total_users'];
    }

    public function getTotalDoctors() {
        $this->db->query("SELECT COUNT(*) AS total_doctors FROM users WHERE role = 'doctor'");
        return $this->db->result()['total_doctors'];
    }

    public function getTotalPatients() {
        $this->db->query("SELECT COUNT(*) AS total_patients FROM users WHERE role = 'patient'");
        return $this->db->result()['total_patients'];
    }

    public function getTotalRevenue() {
        $this->db->query("SELECT SUM(amount) AS total_revenue FROM billing WHERE status = 'paid'");
        return $this->db->result()['total_revenue'] ?? 0;
    }

    public function getRecentRegistrations($limit = 5) {
        $this->db->query("SELECT username, full_name, role, created_at FROM users ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
    //-----------end dashboard-----------


    //-----------user-management-----------
    public function getAllUsers() {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");

        $this->db->bind(':id', $id);
        return $this->db->result();
    }

    public function findUserByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        
        return $this->db->result();
    }

    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);

        return $this->db->result();
    }

    public function addUser($data) {
        $this->db->query("INSERT INTO users (username, password, full_name, email, phone, role) 
                        VALUES (:username, :password, :full_name, :email, :phone, :role)");
        
        // I-bind ang lahat ng data para sa security
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role', $data['role']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    public function updateUser($data) {
        //base query without password
        $sql = ("UPDATE users SET username = :username, full_name = :full_name, email = :email, phone = :phone, role = :role");

        //add password to update if nag exist
        if(isset($data['password'])) {
            $sql .= ", password = :password";
        }

        //add where clause 
        $sql .= " WHERE id = :id";

        $this->db->query($sql);

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role', $data['role']);

        //bind password if ng exist
        if(isset($data['password'])) {
            $this->db->bind('password', $data['password']);

        }

        return $this->db->execute();

    }

    public function deleteUser($id) {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    //-----------end user-management-----------
    

    public function getTotalAppointments() {
        $this->db->query("SELECT * FROM appointments");
        return $this->db->resultSet();
    }




}