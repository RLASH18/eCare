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
class AdminController extends Controller
{

    // Variable para sa user model
    private $adminModel;

    public function __construct()
    {
        parent::__construct(); // Tinitiyak na naka-start ang session

        // Tinitignan kung may naka-login na user at kung admin ba siya
        // Kung hindi admin o walang naka-login, i-redirect sa login page
        if (!isset($_SESSION['user_id']) or $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . URL_ROOT . '/user/login');
            exit;
        }

        // Ini-initialize ang Admin model para sa database operations
        $this->adminModel = $this->model('Admin');
    }

    //Default view
    public function index()
    {

        $this->dashboard();
    }

    public function dashboard()
    {

        // Get dashboard statistics
        $data = [
            'totalUsers' => $this->adminModel->getTotalUsers(),
            'totalDoctors' => $this->adminModel->getTotalDoctors(),
            'totalPatients' => $this->adminModel->getTotalPatients(),
            'totalRevenue' => $this->adminModel->getTotalRevenue(),
            'recentRegistrations' => $this->adminModel->getRecentRegistrations()
        ];

        $this->view('admin/dashboard', $data);
    }

    public function userManagement()
    {
        //shows data
        $data = [
            'users' => $this->adminModel->getAllUsers()
        ];

        $this->view('admin/user-management', $data);
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
                    header('Location: ' . URL_ROOT . '/admin/user-management');
                    exit;
                }

                else {
                    // Kung may error sa pag-save ng data sa database
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                    $this->view('admin/user-control/add', $data);
                }
            } 

            else {
                //kung may error, pakita yung form again with error
                $this->view('admin/user-control/add', $data);
            }
        }
        
        else {
            //pakita yung empty form
            $this->view('admin/user-control/add', [
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
    

    public function appointments()
    {
        $this->view('admin/appointments');
    }

    public function medicalRecords()
    {
        $this->view('admin/medical-records');
    }

    public function prescriptions()
    {
        $this->view('admin/prescriptions');
    }

    public function billing()
    {
        $this->view('admin/billing');
    }

    public function inventory()
    {
        $this->view('admin/inventory');
    }
}
