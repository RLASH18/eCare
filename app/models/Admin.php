<?php

class Admin {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

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

}