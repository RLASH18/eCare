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
            'title' => 'Doctor - Dashboard',
            'totalPatients' => $this->doctorModel->getTotalPatients(),
            'totalAppointments' => $this->doctorModel->getTotalAppointments()
        ]);
    }

    public function appointments() {

        $this->view('doctor/appointments', $data = [
            'title' => 'Doctor - Appointments',
            'appointments' => $this->doctorModel->getAllAppointments()
        ]);
    }

    public function updateStatus() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['appointment_id'];
            $status = $_POST['status'];

            if(!in_array($status, ['approved_by_admin', 'approved_by_doctor', 'rejected'])) {
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

    public function medicalRecords() {
        $this->view('doctor/medical-records', $data = [
            'title' => 'Doctor - Medical-Records',
            'records' => $this->doctorModel->getAllMedicalRecords(),
        ]);
    }

    public function addRecord() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'patient_id' => trim($_POST['patient_id']),
                'diagnosis' => trim($_POST['diagnosis']),
                'treatment' => trim($_POST['treatment']),
                'patient_id_err' => '',
                'diagnosis_err' => '',
                'treatment_err' => ''
            ];

            if(empty($data['patient_id'])) {
                $data['patient_id_err'] = 'Please select your patient';
            }

            if(empty($data['diagnosis'])) {
                $data['diagnosis_err'] = 'Please enter your diagnosis';
            }

            if(empty($data['treatment'])) {
                $data['treatment_err'] = 'Please enter the treatment';
            }

            if(empty($data['patient_id_err']) AND empty($data['diagnosis_err']) AND empty($data['treatment_err'])) {

                if($this->doctorModel->addRecord($data)) {
                    FlashMessage::set('success', 'Medical Record has been added successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/doctor/medical-records');
                exit;
            }
        }

        else {
            
            $this->view('doctor/medical-records/add', $data = [
                'title' => 'Patient - Add-Record',
                'patients' => $this->doctorModel->getAllPatients(),
                'patient_id_err' => '',
                'diagnosis_err' => '',
                'treatment_err' => ''
            ]);
        }
    }

    public function editRecord($id = null) {
        if($id === null) {
            header('Location: ' . URL_ROOT . '/doctor/medical-records');
            exit;
        }

        $record = $this->doctorModel->getMedicalRecordById($id);

        if(!$record) {
            FlashMessage::set('error', 'Medical Record not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/doctor/medical-records');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'patient_id' => trim($_POST['patient_id']),
                'diagnosis' => trim($_POST['diagnosis']),
                'treatment' => trim($_POST['treatment']),
                'patient_id_err' => '',
                'diagnosis_err' => '',
                'treatment_err' => ''
            ];

            if(empty($data['patient_id'])) {
                $data['patient_id_err'] = 'Please select your patient';
            }

            if(empty($data['diagnosis'])) {
                $data['diagnosis_err'] = 'Please enter your diagnosis';
            }

            if(empty($data['treatment'])) {
                $data['treatment_err'] = 'Please enter the treatment';
            }

            if(empty($data['patient_id_err']) AND empty($data['diagnosis_err']) AND empty($data['treatment_err'])) {

                if($this->doctorModel->editRecord($data)) {
                    FlashMessage::set('success', 'Medical Record has been updated successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/doctor/medical-records');
                exit;
            }
        }

        else {

            $this->view('doctor/medical-records/edit', $data = [
                'title' => 'Patient - Edit-Record',
                'id' => $record['id'],
                'patient_id' => $record['patient_id'],
                'patients' => $this->doctorModel->getAllPatients(),
                'diagnosis' => $record['diagnosis'],
                'treatment' => $record['treatment'],
                'patient_id_err' => '',
                'diagnosis_err' => '',
                'treatment_err' => ''
            ]);
        }
    }


    public function deleteRecord($id = null) {

        if($id === null) {
            header('Location: ' . URL_ROOT . '/doctor/medical-records');
            exit;
        }

        $record = $this->doctorModel->getMedicalRecordById($id);

        if(!$record) {
            FlashMessage::set('error', 'record not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/doctor/medical-records');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($this->doctorModel->deleteRecord($id)) {
                FlashMessage::set('success', 'record has been deleted successfully.', 'alert alert-success');
            }

            else {
                FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
            }

            header('Location: ' . URL_ROOT . '/doctor/medical-records');
            exit;
        }

        else {

            $this->view('doctor/medical-records/delete', $data = [
                'title' => 'Patient - Edit-Record',
                'id' => $record['id'],
                'patient_id' => $record['patient_id'],
                'patient_name' => $record['patient_name'],
                'diagnosis' => $record['diagnosis'],
                'treatment' => $record['treatment'],
                'patient_id_err' => '',
                'diagnosis_err' => '',
                'treatment_err' => ''
            ]);
        }
    }
}