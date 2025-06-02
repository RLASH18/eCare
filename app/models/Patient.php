<?php

class Patient {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getTotalAppointments() {
        $this->db->query("SELECT COUNT(*) AS total_appointments FROM appointments");
        return $this->db->result()['total_appointments'];
    }

    public function getTotalBills() {
        $this->db->query("SELECT COUNT(*) AS total_bills FROM billing");
        return $this->db->result()['total_bills'];
    }
}