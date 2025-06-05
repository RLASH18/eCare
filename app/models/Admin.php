<?php

class Admin {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    //--------------------------Dashboard Query------------------------------
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
    //-----------------------------------------------------------------------


    //--------------------------User-Management Query------------------------
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
        //Base query without password
        $sql = ("UPDATE users SET username = :username, full_name = :full_name, email = :email, phone = :phone, role = :role");

        /** Kung may password na binigay sa data array
         *  - I-update din ang password field sa database
         *  - Kung walang password, hindi na i-update ang password field
         *  - Ginagamit ito para hindi ma-overwrite ang existing password kung hindi naman kailangan palitan
         */
        if(isset($data['password'])) {
            $sql .= ", password = :password";
        }

        /** Idagdag ang WHERE clause sa query
         *  - Para ma-identify kung aling user ang i-update
         *  - Ginagamit ang id para sa specific user
         */
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
    //-----------------------------------------------------------------------
    

    //--------------------------Appointment Query----------------------------
    /** Kukunin ang lahat ng appointments sa system
     *  
     *  JOIN explanation:
     *  - 'a' ay alias para sa appointments table
     *  - 'p' ay alias para sa users table (patient)
     *  - 'd' ay alias para sa users table (doctor)
     *  - Multiple JOIN ginagamit para kunin ang:
     *  
     *  1. Patient name mula sa users table (a.patient_id = p.id)
     *  2. Doctor name mula sa users table (a.doctor_id = d.id)
     * 
     *  - Ang mga JOIN ay ginagamit para ma-link ang appointments sa patient at doctor information
     * 
     */
    public function getAllAppointments() {
        $this->db->query("SELECT a.*, p.full_name AS patient_name, d.full_name AS doctor_name 
                        FROM appointments a JOIN users p ON a.patient_id = p.id JOIN users d ON a.doctor_id = d.id 
                        ORDER BY a.scheduled_date DESC");

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
     *  - 'p' ay alias para sa users table (patient)
     *  - 'd' ay alias para sa users table (doctor)
     *  - Multiple JOIN ginagamit para kunin ang:
     *  
     *  1. Patient name mula sa users table (a.patient_id = p.id)
     *  2. Doctor name mula sa users table (a.doctor_id = d.id)
     * 
     */ 
    public function getAppointmentById($id) {
        $this->db->query("SELECT a.*, p.full_name AS patient_name, d.full_name AS doctor_name FROM appointments a 
                        JOIN users p ON a.patient_id = p.id JOIN users d ON a.doctor_id = d.id WHERE a.id = :id");

        $this->db->bind(':id', $id);
        return $this->db->result();
    }

    public function editAppointment($data) {
        $this->db->query("UPDATE appointments SET doctor_id = :doctor_id, scheduled_date = :scheduled_date
                        WHERE id = :id AND status = 'pending'");

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':scheduled_date', $data['scheduled_date']);

        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }

    }

    public function updateAppointmentStatus($appointmentId, $status) {
        $this->db->query("UPDATE appointments SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $appointmentId);
        
        if($this->db->execute()) {
            return true;
        }

        else {
            return false;
        }
    }
    //-----------------------------------------------------------------------


    //--------------------------Medical-Record Query-------------------------

    /** Kukunin ang lahat ng medical records sa system
     * 
     *  JOIN explanation:
     *  - 'm' ay alias para sa medical_records table
     *  - 'p' ay alias para sa users table (patient)
     *  - 'd' ay alias para sa users table (doctor)
     *  - Multiple JOIN ginagamit para kunin ang:
     *  
     *  1. Patient name mula sa users table (m.patient_id = p.id)
     *  2. Doctor name mula sa users table (m.doctor_id = d.id)
     *  - Ang mga JOIN ay ginagamit para ma-link ang medical records sa patient at doctor information
     */
    public function getAllMedicalRecords() {
        $this->db->query("SELECT m.*, p.full_name AS patient_name, d.full_name AS doctor_name
                        FROM medical_records m JOIN users p ON m.patient_id = p.id JOIN users d ON m.doctor_id = d.id
                        ORDER BY m.created_at DESC");

        return $this->db->resultSet();
    }
    //-----------------------------------------------------------------------


    //--------------------------Prescription Query---------------------------
    /** Kukunin ang lahat ng prescriptions sa system
     * 
     *  JOIN explanation:
     *  - 'pr' ay alias para sa prescriptions table
     *  - 'pat' ay alias para sa users table (patient)
     *  - 'doc' ay alias para sa users table (doctor)
     *  - 'm' ay alias para sa medical_records table
     *  - Multiple JOIN ginagamit para kunin ang:
     *  
     *  1. Medical record information (pr.record_id = m.id)
     *  2. Patient name mula sa users table (m.patient_id = pat.id)
     *  3. Doctor name mula sa users table (m.doctor_id = doc.id)
     * 
     *  - Ang mga JOIN ay ginagamit para ma-link ang prescriptions sa medical records, patient, at doctor information
     * 
     */
    public function getAllPrescriptions() {
        $this->db->query("SELECT pr.*, pat.full_name AS patient_name, doc.full_name AS doctor_name, m.diagnosis FROM prescriptions pr
                        JOIN medical_records m ON pr.record_id = m.id 
                        JOIN users pat ON m.patient_id = pat.id
                        JOIN users doc ON m.doctor_id = doc.id");

        return $this->db->resultSet();
    }

}