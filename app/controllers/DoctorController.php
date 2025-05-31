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

        $data = [
            'totalPatients' => $this->doctorModel->getTotalPatients(),
            'totalAppointments' => $this->doctorModel->getTotalAppointments()

        ];

        $this->view('doctor/dashboard', $data);
    }
}