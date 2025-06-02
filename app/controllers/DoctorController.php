<?php

class DoctorController extends Controller {

    private $doctorModel;

    public function __construct() {

        parent::__construct();
        
        if(!isset($_SESSION['user_id']) OR $_SESSION['user_role'] !== 'doctor') {
            header('Location: ' . URL_ROOT . '/user/login');
            exit;
        }

        $this->doctorModel = $this->model('Doctor');
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {

        $this->view('doctor/dashboard', $data = [
            'totalPatients' => $this->doctorModel->getTotalPatients(),
            'totalAppointments' => $this->doctorModel->getTotalAppointments()
        ]);
    }

    public function appointments() {

        $data = [
            'appointments' => $this->doctorModel->getAllAppointments()
        ];

        $this->view('doctor/appointments', $data);
    }

    public function updateStatus() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['appointment_id'];
            $status = $_POST['status'];

            if(!in_array($status, ['approved', 'cancelled'])) {
                FlashMessage::set('error', 'Invalid status value.'. 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/doctor/appointments');
                exit;
            }

            if($this->doctorModel->updateAppointmentStatus($appointmentId, $status)) {
                FlashMessage::set('success', 'Appointment status has been updated successfully.', 'alert alert-success');

            }

            else {
                FlashMessage::set('error', 'Failed to update appointment status.', 'alert alert-error');

            }

            header('Location: ' . URL_ROOT . '/doctor/appointments');
                exit;
        }

        else {
            $this->view('doctor/appointments');
        }
    }
}