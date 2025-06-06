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

        $this->view('patient/dashboard', $data = [
            'title' => 'Patient - Dashboard',
            'totalAppointments' => $this->patientModel->getTotalAppointments(),
            'totalBilling' => $this->patientModel->getTotalBills()
        ]);

    }

    public function appointments() {

        $this->view('patient/appointments', $data = [
            'title' => 'Patient - Appointments',
            'appointments' => $this->patientModel->getAllAppointments()
        ]);

    }

    public function addAppointment() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'doctor_id' => trim($_POST['doctor_id']),
                'scheduled_date' => trim($_POST['scheduled_date']),
                'reason' => trim($_POST['reason']),
                'doctor_id_err' => '',
                'scheduled_date_err' => '',
                'reason_err' => ''
            ];

            if(empty($data['doctor_id'])) {
                $data['doctor_id_err'] = 'Please choose your doctor';
            }

            if(empty($data['scheduled_date'])) {
                $data['scheduled_date_err'] = 'Please select your schedule';
            }

            if(empty($data['reason'])) {
                $data['reason_err'] = 'Please enter your reason';
            }

            if(empty($data['doctor_id_err']) AND empty($data['scheduled_date_err']) AND empty($data['reason_err'])) {

                if($this->patientModel->addAppointment($data)) {
                    FlashMessage::set('success', 'Appointment has been added successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/patient/appointments');
                exit;
            }

            else {
                $this->view('patient/appointments/add', $data);
            }
        }

        else {

            $this->view('patient/appointments/add', $data = [
                'title' => 'Patient - Add-Appointment',
                'doctors' => $this->patientModel->getAllDoctors(),
                'doctor_id_err' => '',
                'scheduled_date_err' => '',
                'reason_err' => ''
            ]);
        }
    }

    public function editAppointment($id = null) {

        if($id === null) {
            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        $appointment = $this->patientModel->getAppointmentById($id);

        if(!$appointment OR $appointment['patient_id'] !== $_SESSION['user_id']) {
            FlashMessage::set('error', 'Appointment not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        if($appointment['status'] !== 'pending') {
            FlashMessage::set('error', 'Only pending appointments can be edited.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'id' => $id,
                'doctor_id' => trim($_POST['doctor_id']),
                'scheduled_date' => trim($_POST['scheduled_date']),
                'reason' => trim($_POST['reason']),
                'doctor_id_err' => '',
                'scheduled_date_err' => '',
                'reason_err' => ''
            ];

            if(empty($data['doctor_id'])) {
                $data['doctor_id_err'] = 'Please choose your doctor';
            }

            if(empty($data['scheduled_date'])) {
                $data['scheduled_date_err'] = 'Please select your schedule';
            }

            if(empty($data['reason'])) {
                $data['reason_err'] = 'Please enter your reason';
            }

            if(empty($data['doctor_id_err']) AND empty($data['scheduled_date_err']) AND empty($data['reason_err'])) {

                if($this->patientModel->editAppointment($data)) {
                    FlashMessage::set('success', 'Appointment has been updated successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');

                }

                header('Location: ' . URL_ROOT . '/patient/appointments');
                exit;
            }

            else {
                $this->view('patient/appointments/edit', $data);
            }

        }

        else {

            $this->view('patient/appointments/edit', $data = [
                'title' => 'Patient - Edit-Appointment',
                'id' => $appointment['id'],
                'doctor_id' => $appointment['doctor_id'],
                'doctors' => $this->patientModel->getAllDoctors(),
                'scheduled_date' => $appointment['scheduled_date'],
                'reason' => $appointment['reason'],
                'doctor_id_err' => '',
                'scheduled_date_err' => '',
                'reason_err' => ''
            ]);
        }
    }

    public function deleteAppointment($id = null) {

        if($id === null) {
            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        $appointment = $this->patientModel->getAppointmentById($id);

        if(!$appointment OR $appointment['patient_id'] !== $_SESSION['user_id']) {
            FlashMessage::set('error', 'Appointment not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        if($appointment['status'] !== 'pending') {
            FlashMessage::set('error', 'Only pending appointments can be deleted.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if($this->patientModel->deleteAppointment($id)) {
                FlashMessage::set('success', 'Appointment has been deleted successfully.', 'alert alert-success');
            }

            else {
                FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
            }

            header('Location: ' . URL_ROOT . '/patient/appointments');
            exit;
        }

        else {

            $this->view('patient/appointments/delete', $data = [
                'title' => 'Patient - Delete-Appointment',
                'id' => $appointment['id'],
                'doctor_id' => $appointment['doctor_id'],
                'doctor_name' => $appointment['doctor_name'],
                'scheduled_date' => $appointment['scheduled_date'],
                'reason' => $appointment['reason']
            ]);
        }
    }

    public function medicalRecords() {
        $this->view('patient/medical-records', $data = [
            'title' => 'Patient - Medical-Records',
            'records' => $this->patientModel->getAllMedicalRecords()
        ]);
    }

    public function prescriptions() {
        $this->view('patient/prescriptions', $data = [
            'title' => 'Patient - Prescriptions',
            'prescriptions' => $this->patientModel->getAllPrescriptions() 
        ]);
    }

    public function billings() {
        $this->view('patient/billings', $data = [
            'title' => 'Patient - Billings',
            'billings' => $this->patientModel->getAllBillings()
        ]);
    }
}