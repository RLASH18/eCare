<?php

// Ang UserController class ay nagha-handle ng lahat ng user-related functions
class UserController extends Controller {
    // Variable para sa user model
    private $userModel;

    public function __construct() {
        // Tinitignan kung may active na session, kung wala, mag-start ng bago
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Ini-initialize ang user model
        $this->userModel = $this->model('User');
    }

    // Index method - ito ang pangunahing login function
    public function index() {
        // Tinitignan kung may naka-login na user
        if(isset($_SESSION['user_id'])) {
            // Kung meron, i-redirect base sa role
            $this->redirectBasedOnRole($_SESSION['user_role']);
        }

        // Tinitignan kung POST request ba (login attempt)
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kinukuha at nililinis ang email/username at password
            $login = trim($_POST['email']);
            $password = $_POST['password'];

            // Tinitignan kung may empty fields
            if(empty($login) OR empty($password)) {
                // Kung may empty, ipakita ang error message
                $this->view('user/login', ['error' => 'Please input your Email or Password']);
                return;
            }

            // Hanapin ang user sa database gamit ang email/username
            $user = $this->userModel->findUserByEmailOrUsername($login);

            // Tinitignan kung tama ang password
            if($user AND password_verify($password, $user->password)) {
                // Kung tama, i-set ang session variables
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = $user->role;

                // I-redirect ang user base sa role
                $this->redirectBasedOnRole($user->role);
            }
            else {
                // Kung mali ang credentials, ipakita ang error
                $this->view('user/login', ['error' => 'Invalid Username or Password']);
            }
        }
        else {
            // Kung hindi POST request, ipakita lang ang login form
            $this->view('user/login');
        }
    }

    // Register method - para sa pagrehistro ng bagong user
    public function register() {
        // Tinitignan kung may naka-login na user
        if(isset($_SESSION['user_id'])) {
            // Kung meron, i-redirect base sa role
            $this->redirectBasedOnRole($_SESSION['user_role']);
        }

        // Tinitignan kung POST request ba (registration attempt)
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kinukuha at nililinis ang lahat ng input data
            $data = [
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['password'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'role' => 'patient', // Default role ay patient
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => ''
            ];

            // Validation para sa username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter your username.';
            }

            // Validation para sa password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter your password.';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters.';
            }

            // Validation para sa password confirmation
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm your password.';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password do not match!';
                }
            }

            // Validation para sa full name
            if(empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter your full name.';
            }

            // Validation para sa email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            } elseif($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken.';
            }

            // Validation para sa phone number
            if(empty($data['phone'])) {
                $data['phone_err'] = 'Please enter your phone number.';
            }

            // Tinitignan kung walang errors sa lahat ng fields
            if(empty($data['username_err']) AND
                empty($data['password_err']) AND
                empty($data['confirm_password_err']) AND
                empty($data['full_name_err']) AND
                empty($data['email_err']) AND
                empty($data['phone_err'])) {

                // I-encrypt ang password bago i-save
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // I-save ang user sa database
                if($this->userModel->register($data)) {
                    // Kung successful, mag-set ng flash message at i-redirect sa login
                    $_SESSION['flash_message'] = 'Registration successful! You can login now';
                    header('Location: ' . URL_ROOT . '/user/login');
                    exit;
                }

                else {
                    // Kung may error sa pag-save
                    die('Something went wrong. Please try again');
                }
            }
        }
        
        else {
            // Kung hindi POST request, ipakita lang ang registration form
            $this->view('user/register');
        }
    }

    // Logout method - para sa paglabas ng user sa system
    public function logout() {
        // I-clear ang lahat ng session data
        $_SESSION = array();

        // I-destroy ang session
        session_destroy();

        // I-redirect sa login page
        header('Location: ' . URL_ROOT . '/user/login');
        exit;
    }

    // Private method para sa pag-redirect base sa role ng user
    private function redirectBasedOnRole($role) {
        // Switch statement para sa iba't ibang roles
        switch ($role) {
            case 'admin':
                // Kung admin, pumunta sa admin dashboard
                header('Location: ' . URL_ROOT . '/admin/dashboard');
                break;
            case 'doctor':
                // Kung doctor, pumunta sa doctor dashboard
                header('Location: ' . URL_ROOT . '/doctor/dashboard');
                break;
            case 'patient':
                // Kung patient, pumunta sa patient dashboard
                header('Location: ' . URL_ROOT . '/patient/dashboard');
                break;
            default:
                // Kung hindi kilala ang role, bumalik sa login
                header('Location: ' . URL_ROOT . '/user/login');
                break;
        }
    }
}