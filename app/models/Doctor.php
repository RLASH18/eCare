<?php

class Doctor {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    //--------------------------Dashboard Query------------------------------
    public function getTotalPatients() {
        $this->db->query("SELECT COUNT(*) AS total_patients FROM users WHERE role = 'patient'");
        return $this->db->result()['total_patients'];
    }

    public function getTotalAppointments() {
        $this->db->query("SELECT COUNT(*) as total_appointment FROM appointments");
        return $this->db->result()['total_appointment'];
    }
    //-----------------------------------------------------------------------


    

    //---------------------------Appointment Query---------------------------
    /** Kukunin ang lahat ng appointments ng doctor
     * 
     *  JOIN explanation:
     *  - 'a' ay alias para sa appointments table
     *  - 'u' ay alias para sa users table
     *  - JOIN ginagamit para kunin ang patient name mula sa users table
     *  - ON a.patient_id = u.id - ito ang condition kung saan nagkakamatch ang patient_id sa appointments at id sa users
     * 
     */
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


    //--------------------------Medical-Record Query-------------------------
    /** Kukunin ang lahat ng medical records ng doctor
     *  
     *  JOIN explanation:
     *  - 'm' ay alias para sa medical_records table
     *  - 'u' ay alias para sa users table
     *  - JOIN ginagamit para kunin ang patient name mula sa users table
     *  - ON m.patient_id = u.id - ito ang condition kung saan nagkakamatch ang patient_id sa medical_records at id sa users
     * 
     */ 
    public function getAllMedicalRecords() {
        $this->db->query("SELECT m.*, u.full_name AS patient_name FROM medical_records m JOIN users u ON m.patient_id = u.id 
                        WHERE m.doctor_id = :doctor_id ORDER BY m.created_at DESC");
        
        $this->db->bind(':doctor_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }


    /** Kukunin ang specific medical record base sa ID
     * 
     *  JOIN explanation:
     *  - 'm' ay alias para sa medical_records table
     *  - 'u' ay alias para sa users table
     *  - JOIN ginagamit para kunin ang patient name mula sa users table
     *  - ON m.patient_id = u.id - ito ang condition kung saan nagkakamatch ang patient_id sa medical_records at id sa users
     * 
     */
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
    //-----------------------------------------------------------------------


    //--------------------------Prescription Query---------------------------
    /** Kukunin ang lahat ng prescriptions ng doctor
     * 
     *  JOIN explanation:
     *  - 'p' ay alias para sa prescriptions table
     *  - 'm' ay alias para sa medical_records table
     *  - 'u' ay alias para sa users table
     *  - Multiple JOIN ginagamit para kunin ang:
     *  
     *  1. Diagnosis mula sa medical_records (p.record_id = m.id)
     *  2. Patient name mula sa users table (m.patient_id = u.id)
     *  
     *  - Ang mga JOIN ay ginagamit para ma-link ang prescriptions sa medical records at sa patient information
     * 
     */
    public function getAllPrescriptions() {
        $this->db->query("SELECT p.*, m.diagnosis, u.full_name AS patient_name FROM prescriptions p JOIN medical_records m ON p.record_id = m.id
                        JOIN users u ON m.patient_id = u.id WHERE m.doctor_id = :doctor_id ORDER BY p.id DESC");
        
        $this->db->bind(':doctor_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }


    /** Kukunin ang specific prescription base sa ID
     *  
     *  JOIN explanation:
     *  - 'p' ay alias para sa prescriptions table
     *  - 'm' ay alias para sa medical_records table
     *  - 'u' ay alias para sa users table
     *  
     *  1. Diagnosis mula sa medical_records (p.record_id = m.id)
     *  2. Patient name mula sa users table (m.patient_id = u.id)
     * 
     */ 
    public function getPrescriptionById($id) {
        $this->db->query("SELECT p.*, m.diagnosis, u.full_name AS patient_name FROM prescriptions p JOIN medical_records m ON p.record_id = m.id
                        JOIN users u ON m.patient_id = u.id WHERE p.id = :id");

        $this->db->bind(':id', $id);
        return $this->db->result();
    }


    public function addPrescriptions($data) {
        $this->db->query("INSERT INTO prescriptions (record_id, medicine_name, dosage) VALUES (:record_id, :medicine_name, :dosage)");
        
        $this->db->bind(':record_id', $data['record_id']);
        $this->db->bind(':medicine_name', $data['medicine_name']);
        $this->db->bind(':dosage', $data['dosage']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    /** I-update ang existing prescription
     * 
     *  JOIN explanation:
     *  - 'p' ay alias para sa prescriptions table
     *  - 'm' ay alias para sa medical_records table
     *  - JOIN ginagamit para ma-verify na ang doctor ay may access sa prescription
     *  - Ang update ay ginagawa lamang kung ang doctor ay may-ari ng medical record
     * 
     */
    public function editPrescriptions($data) {
        $this->db->query("UPDATE prescriptions p JOIN medical_records m ON p.record_id = m.id SET p.record_id = :record_id, 
                        p.medicine_name = :medicine_name, p.dosage = :dosage 
                        WHERE p.id = :id AND m.doctor_id = :doctor_id");
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':record_id', $data['record_id']);
        $this->db->bind(':medicine_name', $data['medicine_name']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':doctor_id', $_SESSION['user_id']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }

    /** Tanggalin ang prescription
     * 
     *  JOIN explanation:
     *  - 'p' ay alias para sa prescriptions table
     *  - 'm' ay alias para sa medical_records table
     *  - JOIN ginagamit para ma-verify na ang doctor ay may access sa prescription
     *  - Ang delete ay ginagawa lamang kung ang doctor ay may-ari ng medical record
     * 
     */
    public function deletePrescriptions($id) {
        $this->db->query("DELETE p FROM prescriptions p INNER JOIN medical_records m ON p.record_id = m.id WHERE p.id = :id AND m.doctor_id = :doctor_id");

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