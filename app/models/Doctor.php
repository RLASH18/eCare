<?php

class Doctor {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }


    //-----------------------------------------------------------------------
    public function getTotalPatients() {
        $this->db->query("SELECT COUNT(*) AS total_patients FROM users WHERE role = 'patient'");
        return $this->db->result()['total_patients'];
    }

    public function getTotalAppointments() {
        $this->db->query("SELECT COUNT(*) as total_appointment FROM appointments");
        return $this->db->result()['total_appointment'];
    }
    //-----------------------------------------------------------------------



    //-----------------------------------------------------------------------
    public function getAllAppointments() {
        $this->db->query("SELECT a.*, u.full_name AS patient_name FROM appointments a JOIN users u 
                        ON a.patient_id = u.id WHERE a.doctor_id = :doctor_id ORDER BY a.scheduled_date DESC");
        $this->db->bind(':doctor_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    public function updateAppointmentStatus($appointmentId, $status) {
        $this->db->query("UPDATE appointments SET status = :status WHERE id = :id AND doctor_id = :doctor_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $appointmentId);
        $this->db->bind(':doctor_id', $_SESSION['user_id']);
        
        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }
}