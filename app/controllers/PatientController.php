<?php

class PatientController extends Controller {

    private $patientModel;

    public function __construct() {
        parent::__construct();

        if(!isset($_SESSION['user_id']) OR $_SESSION['user_role'] !== 'patient') {
            header('Location: ' . URL_ROOT . '/user/login');
            exit;
        }

        $this->patientModel = $this->model('Patient');
        
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {

        $data = [
            'totalAppointments' => $this->patientModel->getTotalAppointments(),
            'totalBilling' => $this->patientModel->getTotalBills()
        ];

        $this->view('patient/dashboard', $data);
    }

    public function appointments() {
        $this->view('patient/appointments');
    }

    public function addAppointment() {

    }

    public function editAppointment() {

    }

    public function deleteAppointment() {
        
    }
}