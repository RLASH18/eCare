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
                'role' => $user['role']
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

    public function billings() {
        $this->view('admin/billings', $data = [
            'title' => 'Admin - Billings',
            'billings' => $this->adminModel->getAllBillings(),
        ]);
    }

    public function addBilling() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'patient_id' => trim($_POST['patient_id']),
                'amount' => trim($_POST['amount']),
                'status' => $_POST['status'],
                'description' => trim($_POST['description']),
                'patient_id_err' => '',
                'amount_err' => '',
                'status_err' => '',
                'description_err' => ''
            ];

            if(empty($data['patient_id'])) {
                $data['patient_id_err'] = 'Please choose a patient';
            }

            if(empty($data['amount'])) {
                $data['amount_err'] = 'Please enter the schedule';
            }

            if(empty($data['status'])) {
                $data['status_err'] = 'Please enter the status';
            }

            if(empty($data['description'])) {
                $data['description_err'] = 'Please enter a description';
            }

            if(empty($data['patient_id_err']) AND empty($data['amount_err']) AND empty($data['status_err']) AND empty($data['description_err'])) {

                if($this->adminModel->addBilling($data)) {
                    FlashMessage::set('success', 'Billing has been added successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/admin/billings');
                exit;
            }

            else {
                $this->view('admin/billings/add', $data);
            }
        }

        else {
            $this->view('admin/billings/add', $data = [
                'title' => 'Admin - Add-Billing',
                'patients' => $this->adminModel->getAllPatients(),
                'patient_id_err' => '',
                'amount_err' => '',
                'status_err' => '',
                'description_err' => ''
            ]);
        }

    }

    public function editBilling($id = null) {
        
        if($id === null) {
            header('Location: ' . URL_ROOT . '/admin/billings');
            exit;
        }

        $billings = $this->adminModel->getBillingById($id);

        if(!$billings) {
            FlashMessage::set('error', 'Billings not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/billings');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'id' => $id,
                'patient_id' => trim($_POST['patient_id']),
                'amount' => trim($_POST['amount']),
                'status' => trim($_POST['status']),
                'description' => trim($_POST['description']),
                'patient_id_err' => '',
                'amount_err' => '',
                'status_err' => '',
                'description_err' => ''
            ];

            if(empty($data['patient_id'])) {
                $data['patient_id_err'] = 'Please choose a patient';
            }

            if(empty($data['amount'])) {
                $data['amount_err'] = 'Please enter the amount';
            }

            if(empty($data['status'])) {
                $data['status_err'] = 'Please enter the status';
            }

            if(empty($data['description'])) {
                $data['description_err'] = 'Please enter a description';
            }

            if(empty($data['patient_id_err']) AND empty($data['amount_err']) AND empty($data['status_err']) AND empty($data['description_err'])) {

                if($this->adminModel->editBilling($data)) {
                    FlashMessage::set('success', 'Billing has been updated successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');

                }

                header('Location: ' . URL_ROOT . '/admin/billings');
                exit;
            }

            else {
                $this->view('admin/billings/edit', $data);
            }
        }

        else {

            $this->view('admin/billings/edit', $data = [
                'title' => 'Admin - Edit-Billing',
                'id' => $billings['id'],
                'patient_id' => $billings['patient_id'],
                'patients' => $this->adminModel->getAllPatients(),
                'amount' => $billings['amount'],
                'status' => $billings['status'],
                'description' => $billings['description'],
                'patient_id_err' => '',
                'amount_err' => '',
                'status_err' => '',
                'description_err' => ''
            ]);
        }
    }

    public function deleteBilling($id = null) {

        if($id === null) {
            header('Location: ' . URL_ROOT . '/admin/billings');
            exit;
        }

        $billings = $this->adminModel->getBillingById($id);

        if(!$billings) {
            FlashMessage::set('error', 'Billings not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/billings');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if($this->adminModel->deleteBilling($id)) {
                FlashMessage::set('success', 'Billing has been deleted successfully.', 'alert alert-success');
            }

            else {
                FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
            }

            header('Location: ' . URL_ROOT . '/admin/billings');
            exit;
        }

        else {

            $this->view('admin/billings/delete', $data = [
                'title' => 'Admin - Delete-Billing',
                'id' => $billings['id'],
                'patient_id' => $billings['patient_id'],
                'patient_name' => $billings['patient_name'],
                'amount' => $billings['amount'],
                'status' => $billings['status'],
                'description' => $billings['description']
            ]);
        }
    }

    public function inventory() {

        $this->view('admin/inventory', $data = [
            'title' => 'Admin - Inventory',
            'items' => $this->adminModel->getAllInventoryItems()
        ]);
    }

    public function addInventory() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'item_name' => trim($_POST['item_name']),
                'quantity' => trim($_POST['quantity']),
                'description' => trim($_POST['description']),
                'item_name_err' => '',
                'quantity_err' => '',
                'description_err' => ''
            ];

            if(empty($data['item_name'])) {
                $data['item_name_err'] = 'Please enter the item name';
            }

            if(empty($data['quantity'])) {
                $data['quantity_err'] = 'Please enter the quantity';
            }

            if(empty($data['description'])) {
                $data['description_err'] = 'Please enter the description';
            }

            if(empty($data['item_name_err']) AND empty($data['quantity_err']) AND empty($data['description_err'])) {

                if($this->adminModel->addInventory($data)) {
                    FlashMessage::set('success', 'Inventory item has been added successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/admin/inventory');
                exit;
            }

            else {
                $this->view('admin/inventory/add', $data);
            }
        }

        $this->view('admin/inventory/add', $data = [
            'title' => 'Admin - Add-Inventory',
            'item_name_err' => '',
            'quantity_err' => '',
            'description_err' => ''
        ]);
    }

    public function editInventory($id = null) {

        if($id === null) {
            header('Location: ' . URL_ROOT . '/admin/inventory');
            exit;
        }

        $items = $this->adminModel->getInventoryById($id);

        if(!$items) {
            FlashMessage::set('error', 'Inventory item not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/inventory');
            exit;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'id' => $id,
                'item_name' => trim($_POST['item_name']),
                'quantity' => trim($_POST['quantity']),
                'description' => trim($_POST['description']),
                'item_name_err' => '',
                'quantity_err' => '',
                'description_err' => ''
            ];

            if(empty($data['item_name'])) {
                $data['item_name_err'] = 'Please enter the item name';
            }

            if(empty($data['quantity'])) {
                $data['quantity_err'] = 'Please enter the quantity';
            }

            if(empty($data['description'])) {
                $data['description_err'] = 'Please enter the description';
            }

            if(empty($data['item_name_err']) AND empty($data['quantity_err']) AND empty($data['description_err'])) {

                if($this->adminModel->editInventory($data)) {
                    FlashMessage::set('success', 'Inventory item has been Updated successfully.', 'alert alert success');
                }

                else {
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }

                header('Location: ' . URL_ROOT . '/admin/inventory');
                exit;
            }

            else {
                $this->view('admin/inventory/edit', $data);
            }
        }

        else {
            $this->view('admin/inventory/edit', $data = [
                'title' => 'Admin - Edit-Inventory',
                'id' => $items['id'],
                'item_name' => $items['item_name'],
                'quantity' => $items['quantity'],
                'description' => $items['description'],
                'item_name_err' => '',
                'quantity_err' => '',
                'description_err' => ''

            ]);
        }

    }

    public function deleteInventory($id = null) {

        if($id === null) {
            header('Location: ' . URL_ROOT . '/admin/inventory');
            exit;
        }

        $items = $this->adminModel->getInventoryById($id);

        if(!$items) {
            FlashMessage::set('error', 'Inventory item not found.', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/admin/inventory');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if($this->adminModel->deleteInventory($id)) {
                FlashMessage::set('success', 'Inventory item has been delete successfully.', 'alert alert-success');
            }

            else {
                FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
            }

            header('Location: ' . URL_ROOT . '/admin/inventory');
            exit;
        }

        else {
            
            $this->view('admin/inventory/delete', $data = [
                'title' => 'Admin - Delete-Inventory',
                'id' => $items['id'],
                'item_name' => $items['item_name'],
                'quantity' => $items['quantity'],
                'description' => $items['description']
            ]);
        }
    }
}
