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
    //-----------------------------------------------------------------------


    //-----------------------------------------------------------------------
    public function getAllMedicalRecords() {
        $this->db->query("SELECT m.*, u.full_name AS patient_name FROM medical_records m JOIN users u ON m.patient_id = u.id 
                        WHERE m.doctor_id = :doctor_id ORDER BY m.created_at DESC");
        
        $this->db->bind(':doctor_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    public function getMedicalRecordById($id) {
        $this->db->query("SELECT m.*, u.full_name AS patient_name FROM medical_records m JOIN users u 
                        ON m.patient_id = u.id WHERE m.id = :id");
        
        $this->db->bind(':id', $id);
        return $this->db->result();
    }

    public function getAllPatients() {
        $this->db->query("SELECT id, full_name FROM users WHERE role = 'patient'");
        return $this->db->resultSet();
    }

    public function addRecord($data) {
        $this->db->query("INSERT INTO medical_records (doctor_id, patient_id, diagnosis, treatment) 
                        VALUES (:doctor_id, :patient_id, :diagnosis, :treatment)");
        
        $this->db->bind(':doctor_id', $_SESSION['user_id']);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':treatment', $data['treatment']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    public function editRecord($data) {
        $this->db->query("UPDATE medical_records SET patient_id = :patient_id, diagnosis = :diagnosis, treatment = :treatment 
                        WHERE id = :id AND doctor_id = :doctor_id");

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':treatment', $data['treatment']);
        $this->db->bind(':doctor_id', $_SESSION['user_id']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    public function deleteRecord($id) {
        $this->db->query("DELETE FROM medical_records WHERE id = :id AND doctor_id = :doctor_id");

        $this->db->bind(':id', $id);
        $this->db->bind(':doctor_id', $_SESSION['user_id']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

}