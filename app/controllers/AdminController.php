<?php

/**
 * AdminController Class
 * 
 * Ang class na ito ang humahawak ng lahat ng admin-related functions sa system.
 * Ito ang controller na responsible sa pag-manage ng admin dashboard at iba pang admin features.
 * 
 * Features:
 * - Admin dashboard display
 * - Admin-specific operations
 */
class AdminController extends Controller {

    // Variable para sa user model
    private $adminModel;

    public function __construct() {
        parent::__construct(); // Tinitiyak na naka-start ang session

        // Tinitignan kung may naka-login na user at kung admin ba siya
        // Kung hindi admin o walang naka-login, i-redirect sa login page
        if (!isset($_SESSION['user_id']) OR $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . URL_ROOT . '/user/login');
            exit;
        }

        // Ini-initialize ang Admin model para sa database operations
        $this->adminModel = $this->model('Admin');

        //for user management dashboard
        $user = $this->adminModel->getUserById($_SESSION['user_id']);

        if(!$user OR $user['role'] !== 'admin') {
            session_unset();
            session_destroy();
            FlashMessage::set('error', 'Your session has expired. Please login again.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/user/login');
            exit;
        }
    }

    //Default view
    public function index() {

        $this->dashboard();
    }

    public function dashboard() {

        // Get dashboard statistics
        $this->view('admin/dashboard', $data = [
            'title' => 'Admin Dashboard',
            'totalUsers' => $this->adminModel->getTotalUsers(),
            'totalDoctors' => $this->adminModel->getTotalDoctors(),
            'totalPatients' => $this->adminModel->getTotalPatients(),
            'totalRevenue' => $this->adminModel->getTotalRevenue(),
            'recentRegistrations' => $this->adminModel->getRecentRegistrations()
        ]);
    }

    public function userManagement() {
        
        //shows data
        $this->view('admin/user-management', $data = [
            'title' => 'Admin - User-Management',
            'users' => $this->adminModel->getAllUsers()
        ]);
    }

    public function addUser() {
        // Tinitignan kung POST request ba (registration attempt)
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kinukuha at nililinis ang lahat ng input data mula sa registration form
            $data = [
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'role' => trim($_POST['role']),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
                'form_data' => $_POST
            ];

            // Validation para sa username field
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter the username.';
            } elseif($this->adminModel->findUserByUsername($data['username'])) {
                $data['username_err'] = 'Username is already taken.';
            }

            // Validation para sa password field
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter the password.';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters.';
            }

            // Validation para sa password confirmation
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm the password.';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password do not match!';
                }
            }

            // Validation para sa full name field
            if(empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter the full name.';
            }

            // Validation para sa email field
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter the email';
            } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Invalid Email Format';
            } elseif($this->adminModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken.';
            }
            
            // Validation para sa phone number field
            if(empty($data['phone'])) {
                $data['phone_err'] = 'Please enter the phone number.';
            } elseif(!preg_match('/^[0-9]{11}$/', $data['phone'])) {
                $data['phone_err'] = 'Phone number must be 11 digits.';
            }

            if(empty($data['role'])) {
                $data['role_err'] = 'Please select the role.';
            } elseif(!in_array($data['role'], ['admin', 'doctor', 'patient'])) {
                $data['role_err'] = 'Invalid role selected.';
            }

            // Tinitignan kung walang errors sa lahat ng fields
            if(empty($data['username_err']) AND
                empty($data['password_err']) AND
                empty($data['confirm_password_err']) AND
                empty($data['full_name_err']) AND
                empty($data['email_err']) AND
                empty($data['phone_err']) AND 
                empty($data['role_err'])) {

                // I-encrypt ang password gamit ang password_hash bago i-save sa database
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // I-save ang user data sa database gamit ang register method
                if($this->adminModel->addUser($data)) {
                    // Kung successful ang registration, mag-set ng flash message
                    FlashMessage::set('success', 'User added successfully.', 'alert alert-success');
                }

                else {
                    // Kung may error sa pag-save ng data sa database
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/admin/user-management');
                exit;
            }
            
            else {
                $this->view('admin/user-management/add', $data);
            }
        }
        
        else {
            //pakita yung empty form
            $this->view('admin/user-management/add', $data = [
                'title' => 'Admin - Add-User',
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'full_name' => '',
                'email' => '',
                'phone' => '',
                'role' => '',
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
            ]);
        }
    }

    public function editUser($id = null) {

        //check kung id is provided
        if($id === null) {
            FlashMessage::set('error', 'No user selected for editing.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/user-management');
            exit;
        }

        $user = $this->adminModel->getUserById($id);

        if(!$user) {
            FlashMessage::set('error', 'User not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/user-management');
            exit;
        }

        // Tinitignan kung POST request ba (registration attempt)
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kinukuha at nililinis ang lahat ng input data mula sa registration form
            $data = [
                'id' => $id,
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'role' => trim($_POST['role']),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
                'form_data' => $_POST
            ];

            // Validation para sa username field
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter the username.';
            } elseif($data['username'] !== $user['username'] AND $this->adminModel->findUserByUsername($data['username'])) {
                $data['username_err'] = 'Username is already taken.';
            }

            if(!empty($data['password'])) {
                if(strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters.';
                }
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match.';
                }
            }

            if(empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter the full name.';
            }

            // Validation para sa email field
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter the email';
            } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Invalid Email Format';
            } elseif($data['email'] !== $user['email'] AND $this->adminModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken.';
            }

            // Validation para sa phone number field
            if(empty($data['phone'])) {
                $data['phone_err'] = 'Please enter the phone number.';
            } elseif(!preg_match('/^[0-9]{11}$/', $data['phone'])) {
                $data['phone_err'] = 'Phone number must be 11 digits.';
            }

            if(empty($data['role'])) {
                $data['role_err'] = 'Please select the role.';
            } elseif(!in_array($data['role'], ['admin', 'doctor', 'patient'])) {
                $data['role_err'] = 'Invalid role selected.';
            }

            // Tinitignan kung walang errors sa lahat ng fields
            if(empty($data['username_err']) AND
                empty($data['password_err']) AND
                empty($data['confirm_password_err']) AND
                empty($data['full_name_err']) AND
                empty($data['email_err']) AND
                empty($data['phone_err']) AND 
                empty($data['role_err'])) {

                //hash the password if nag change
                if(!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    unset($data['password']);
                }

                if($this->adminModel->updateUser($data)) {
                    FlashMessage::set('success', 'User has been updated successfully.', 'alert alert-success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/admin/user-management');
                exit;
            }

            else {
                $this->view('admin/user-management/edit', $data);
            }
        }

        else {
            //pakita yung empty form
            $this->view('admin/user-management/edit', $data = [
                'title' => 'Admin - Edit-User',
                'id' => $user['id'],
                'username' => $user['username'],
                'password' => '',
                'confirm_password' => '',
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => $user['role'],
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
            ]);
        }
    }

    public function deleteUser($id = null) {
        
        if($id === null) {
            FlashMessage::set('error', 'No user selected for deletion.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/user-management');
            exit;
        }

        if($id == $_SESSION['user_id']) {
            FlashMessage::set('error', 'You cannot delete your own account while logged in.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/user-management');
            exit;
        }

        $user = $this->adminModel->getUserById($id); 

        if(!$user) {
            FlashMessage::set('error', 'User not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/user-management');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if($this->adminModel->deleteUser($id)) {
                FlashMessage::set('success', 'User has been deleted successfully.', 'alert alert-success');

            }

            else {
                FlashMessage::set('error', 'Failed to delete user. Please try again.', 'alert alert-danger');
            }

            header('Location: ' . URL_ROOT . '/admin/user-management');
            exit;
        }

        else {
            $this->view('admin/user-management/delete', $data = [
                'title' => 'Admin - Delete-User',
                'id' => $user['id'],
                'username' => $user['username'],
                'password' => '',
                'confirm_password' => '',
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => $user['role'],
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
            ]);

        }
    }


    public function appointments() {

        $this->view('admin/appointments', $data = [
            'title' => 'Admin - Appointments',
            'appointments' => $this->adminModel->getAllAppointments()
        ]);
    }

    public function editAppointment($id = null) {
        if($id === null) {
            header('Location: ' . URL_ROOT . '/admin/appointments');
            exit;
        }

        $appointment = $this->adminModel->getAppointmentById($id);

        if(!$appointment) {
            FlashMessage::set('error', 'Appointment not found', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/appointments');
            exit;
        }

        if($appointment['status'] !== 'pending') {
            FlashMessage::set('error', 'Only pending appointments can be edited.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/appointments');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'patient_name' => $appointment['patient_name'],
                'doctor_id' => trim($_POST['doctor_id']),
                'scheduled_date' => trim($_POST['scheduled_date']),
                'doctor_id_err' => '',
                'scheduled_date_err' => '',
            ];

            if(empty($data['doctor_id'])) {
                $data['doctor_id_err'] = 'Please choose the doctor';
            }

            if(empty($data['scheduled_date'])) {
                $data['scheduled_date_err'] = 'Please select the schedule';
            }

            if(empty($data['doctor_id_err']) AND empty($data['scheduled_date_err'])) {

                if($this->adminModel->editAppointment($data)) {
                    FlashMessage::set('success', 'Appointment has been updated successfully.', 'alert alert success');

                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');

                }

                header('Location: ' . URL_ROOT . '/admin/appointments');
                exit;
            }
            
            else {
                $this->view('admin/appointments/edit', $data);
            }

        }

        else {
            
            $this->view('admin/appointments/edit', $data = [
                'title' => 'Admin - Edit-Appointment',
                'id' => $appointment['id'],
                'patient_name' => $appointment['patient_name'],
                'doctors' => $this->adminModel->getAllDoctors(),
                'doctor_id' => $appointment['doctor_id'],
                'scheduled_date' => $appointment['scheduled_date'],
                'reason' => $appointment['reason'],
                'doctor_id_err' => '',
                'scheduled_date_err' => '', 
                'reason_err' => ''
            ]);
        }
    }

    public function updateStatus() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['appointment_id'];
            $status = $_POST['status'];

            if(!in_array($status, ['approved_by_admin', 'approved_by_doctor', 'rejected'])) {
                FlashMessage::set('error', 'Invalid status value.'. 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/admin/appointments');
                exit;
            }

            if($this->adminModel->updateAppointmentStatus($appointmentId, $status)) {
                FlashMessage::set('success', 'Appointment status has been updated successfully.', 'alert alert-success');

            }

            else {
                FlashMessage::set('error', 'Failed to update appointment status.', 'alert alert-error');

            }

            header('Location: ' . URL_ROOT . '/admin/appointments');
            exit;
        }

        else {
            $this->view('admin/appointments');
        }
    }

    public function medicalRecords() {
        
        $this->view('admin/medical-records', $data = [
            'title' => 'Admin - Medical-Records',
            'records' => $this->adminModel->getAllMedicalRecords()
        ]);
    }

    public function prescriptions() {
        $this->view('admin/prescriptions', $data = [
            'title' => 'Admin - Prescriptions', 
            'prescriptions' => $this->adminModel->getAllPrescriptions()
        ]);
    }

    public function billing() {
        $this->view('admin/billing');
    }

    public function inventory() {
        $this->view('admin/inventory');
    }
}
