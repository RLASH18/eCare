<?php

class Patient {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    //--------------------------Dashboard Query------------------------------
    public function getTotalAppointments() {
        $this->db->query("SELECT COUNT(*) AS total_appointments FROM appointments");
        return $this->db->result()['total_appointments'];
    }

    public function getTotalBills() {
        $this->db->query("SELECT COUNT(*) AS total_bills FROM billing");
        return $this->db->result()['total_bills'];
    }
    //-----------------------------------------------------------------------

    
    //--------------------------Appointment Query----------------------------
    /** Kukunin ang lahat ng appointments ng patient
     * 
     *  JOIN explanation:
     *  - 'a' ay alias para sa appointments table
     *  - 'u' ay alias para sa users table
     *  - JOIN ginagamit para kunin ang doctor name mula sa users table
     *  - ON a.doctor_id = u.id - ito ang condition kung saan nagkakamatch ang doctor_id sa appointments at id sa users
     * 
     */
    public function getAllAppointments() {
        $this->db->query("SELECT a.*, u.full_name AS doctor_name FROM appointments a JOIN users u 
                        ON a.doctor_id = u.id WHERE a.patient_id = :patient_id ORDER BY a.scheduled_date DESC");
        
        $this->db->bind(':patient_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }


    public function getAllDoctors() {
        $this->db->query("SELECT id, full_name FROM users WHERE role = 'doctor'");
        return $this->db->resultSet();
    }

    /** Kukunin ang specific appointment base sa ID
     * 
     *  JOIN explanation:
     *  - 'a' ay alias para sa appointments table
     *  - 'u' ay alias para sa users table
     *  - JOIN ginagamit para kunin ang doctor name mula sa users table
     *  - ON a.doctor_id = u.id - ito ang condition kung saan nagkakamatch ang doctor_id sa appointments at id sa users
     * 
     */
    public function getAppointmentById($id) {
        $this->db->query("SELECT a.*, u.full_name AS doctor_name FROM appointments a JOIN users u 
                        ON a.doctor_id = u.id WHERE a.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->result();
    }

    public function addAppointment($data) {
        $this->db->query("INSERT INTO appointments (patient_id, doctor_id, scheduled_date, reason) VALUES 
                        (:patient_id, :doctor_id, :scheduled_date, :reason)");
        
        $this->db->bind(':patient_id', $_SESSION['user_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':scheduled_date', $data['scheduled_date']);
        $this->db->bind(':reason', $data['reason']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    public function editAppointment($data) {
        $this->db->query("UPDATE appointments SET doctor_id = :doctor_id, scheduled_date = :scheduled_date, reason = :reason
                        WHERE id = :id AND patient_id = :patient_id AND status = 'pending'");
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':scheduled_date', $data['scheduled_date']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':patient_id', $_SESSION['user_id']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    public function deleteAppointment($id) {
        $this->db->query("DELETE FROM appointments WHERE id = :id AND patient_id = :patient_id AND status = 'pending'");
        $this->db->bind(':id', $id);
        $this->db->bind(':patient_id', $_SESSION['user_id']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }
    //-----------------------------------------------------------------------


    //--------------------------Medical Record Query-------------------------
    /** Kukunin ang lahat ng medical records ng patient
     * 
     *  JOIN explanation:
     *  - 'm' ay alias para sa medical_records table
     *  - 'u' ay alias para sa users table
     *  - JOIN ginagamit para kunin ang doctor name mula sa users table
     *  - ON m.doctor_id = u.id - ito ang condition kung saan nagkakamatch ang doctor_id sa medical_records at id sa users
     * 
     */
    public function getAllMedicalRecords() {
        $this->db->query("SELECT m.*, u.full_name AS doctor_name FROM medical_records m JOIN users u ON m.doctor_id = u.id
                        WHERE m.patient_id = :patient_id ORDER BY m.created_at DESC");
        
        $this->db->bind(':patient_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }
    //-----------------------------------------------------------------------


    //--------------------------Prescription Query---------------------------
    /** Kukunin ang lahat ng prescriptions ng patient
     * 
     *  JOIN explanation:
     *  - 'p' ay alias para sa prescriptions table
     *  - 'm' ay alias para sa medical_records table
     *  - 'u' ay alias para sa users table
     *  - Multiple JOIN ginagamit para kunin ang:
     * 
     *  1. Medical record information (p.record_id = m.id)
     *  2. Doctor name mula sa users table (m.doctor_id = u.id)
     * 
     *  - Ang mga JOIN ay ginagamit para ma-link ang prescriptions sa medical records at sa doctor information
     * 
     */ 
    public function getAllPrescriptions() {
        $this->db->query("SELECT p.*, u.full_name AS doctor_name FROM prescriptions p JOIN medical_records m ON p.record_id = m.id
                        JOIN users u ON m.doctor_id = u.id
                        WHERE m.patient_id = :patient_id");
        
        $this->db->bind(':patient_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }
    //-----------------------------------------------------------------------

}