<?php

class Doctor {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getTotalPatients() {
        $this->db->query("SELECT COUNT(*) AS total_patients FROM users WHERE role = 'patient'");
        return $this->db->result()['total_patients'];
    }

    public function getTotalAppointments() {
        $this->db->query("SELECT COUNT(*) as total_appointment FROM appointments");
        return $this->db->result()['total_appointment'];
    }

}