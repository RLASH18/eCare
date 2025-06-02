<?php

class Patient {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    //-----------------------------------------------------------------------
    public function getTotalAppointments() {
        $this->db->query("SELECT COUNT(*) AS total_appointments FROM appointments");
        return $this->db->result()['total_appointments'];
    }

    public function getTotalBills() {
        $this->db->query("SELECT COUNT(*) AS total_bills FROM billing");
        return $this->db->result()['total_bills'];
    }
    //-----------------------------------------------------------------------

    
    //-----------------------------------------------------------------------
    //a means appointment and u is users
    public function getAllAppointments() {
        $this->db->query("SELECT a.*, u.full_name AS doctor_name, 
                        CASE 
                            WHEN a.status = 'pending' THEN 'Waiting for approval'
                            WHEN a.status = 'approved' THEN 'Approved by doctor'
                            WHEN a.status = 'cancelled' THEN 'Cancelled'
                            ELSE a.status
                        END as status
                        FROM appointments a JOIN users u 
                        ON a.doctor_id = u.id WHERE a.patient_id = :patient_id ORDER BY a.scheduled_date DESC");
        $this->db->bind(':patient_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    public function getAllDoctors() {
        $this->db->query("SELECT id, full_name FROM users WHERE role = 'doctor'");
        return $this->db->resultSet();
    }

    public function getAppointmentById($id) {
        $this->db->query("SELECT a.*, u.full_name AS doctor_name FROM appointments a JOIN users u 
                        ON a.doctor_id = u.id WHERE a.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->result();
    }

    public function addAppointment($data) {

        // //check if patient is already has an appointment in this time
        // $this->db->query("SELECT COUNT(*) AS count FROM appointments WHERE patient_id = :patient_id 
        //                 AND scheduled_data = :scheduled_date");
        // $this->db->bind(':patient_id', $_SESSION['user_id']);
        // $this->db->bind(':scheduled_date', $data['scheduled_date']);

        // if($this->db->result()['count'] > 0) {
        //     return false; //patient already has an appointment at this time
        // }

        // //check doctor availability
        // $this->db->query("SELECT COUNT(*) AS count FROM appointments WHERE doctor_id = :doctor_id 
        //                 AND scheduled_data = :scheduled_date");
        // $this->db->bind(':doctor_id', $data['doctor_id']);
        // $this->db->bind(':scheduled_date', $data['scheduled_date']);

        // if($this->db->result()['count'] > 0) {
        //     return false; //doctor is already booked at this time
        // }

        //add appointment with patient id
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
}