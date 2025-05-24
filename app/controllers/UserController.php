<?php

// Ang file na ito ay naglalaman ng UserController class na siyang nagha-handle ng lahat ng user-related functions
class UserController extends Controller {
    // Private variable para sa user model na gagamitin sa buong controller
    private $userModel;

    // Constructor method na tumatakbo kapag ginawa ang instance ng UserController
    public function __construct() {
        // Tinatawag ang parent constructor para ma-setup ang session
        parent::__construct(); // Tinitiyak na naka-start ang session

        // Ini-initialize ang user model para magamit sa buong controller
        $this->userModel = $this->model('User');
    }

    // Index method - ito ang default landing page kapag pumunta sa /user
    public function index() {
        // Tinitignan kung may naka-login na user sa session
        if(isset($_SESSION['user_id'])) {
            // Kung meron, i-redirect base sa role ng user
            $this->redirectBasedOnRole($_SESSION['user_role']);
            exit;
        }

        // Kung walang naka-login, ipakita ang login page
        $this->view('user/login');
    }

    // Login method - ito ang pangunahing login function na tumatanggap ng credentials
    public function login() {
        // Tinitignan kung may naka-login na user sa session
        if(isset($_SESSION['user_id'])) {
            // Kung meron, i-redirect base sa role ng user
            $this->redirectBasedOnRole($_SESSION['user_role']);
            exit;
        }

        // Tinitignan kung POST request ba (login attempt)
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kinukuha at nililinis ang email/username at password mula sa form
            $login = trim($_POST['user_input']);
            $password = $_POST['password'];

            // Tinitignan kung may empty fields sa form
            if(empty($login) OR empty($password)) {
                // Kung may empty, ipakita ang error message sa login page
                FlashMessage::set('error', 'Please input your Username/Email or Password.', 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/user/login');
                exit;
            }

            // Hanapin ang user sa database gamit ang email/username
            $user = $this->userModel->findUserByEmailOrUsername($login);

            // Tinitignan kung tama ang password gamit ang password_verify
            if($user AND password_verify($password, $user['password'])) {
                // Kung tama, i-set ang session variables para sa logged in user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // I-redirect ang user base sa role nito
                $this->redirectBasedOnRole($user['role']);
                exit;
            }
            
            else {
                // Kung mali ang credentials, ipakita ang error message
                FlashMessage::set('error', 'Invalid Username/Email or Password.', 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/user/login');
                exit;
            }
        }

        else {
            // Kung hindi POST request, ipakita lang ang login form
            $this->view('user/login');
        }
    }

    // Register method - para sa pagrehistro ng bagong user sa system
    public function register() {
        // Tinitignan kung may naka-login na user sa session
        if(isset($_SESSION['user_id'])) {
            // Kung meron, i-redirect base sa role ng user
            $this->redirectBasedOnRole($_SESSION['user_role']);
            exit;
        }

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
                'role' => 'patient', // Default role ay patient para sa bagong users
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => ''
            ];

            // Validation para sa username field
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter your username.';
            } elseif($this->userModel->findUserByEmailOrUsername($data['username'])) {
                $data['username_err'] = 'Username is already taken.';
            }

            // Validation para sa password field
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

            // Validation para sa full name field
            if(empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter your full name.';
            }

            // Validation para sa email field
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Invalid Email Format';
            } elseif($this->userModel->findUserByEmailOrUsername($data['email'])) {
                $data['email_err'] = 'Email is already taken.';
            }

            // Validation para sa phone number field
            if(empty($data['phone'])) {
                $data['phone_err'] = 'Please enter your phone number.';
            } elseif(!preg_match('/^[0-9]{11}$/', $data['phone'])) {
                $data['phone_err'] = 'Phone number must be 11 digits.';
            }

            if(empty($data['role'])) {
                $data['role_err'] = 'Please select your role.';
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

                // I-save ang user data sa database gamit ang register methods
                if($this->userModel->register($data)) {
                    // Kung successful ang registration, mag-set ng flash message
                    FlashMessage::set('success', 'Registration successful! You can login now', 'alert alert-success');
                    header('Location: ' . URL_ROOT . '/user/login');
                    exit;
                }

                else {
                    // Kung may error sa pag-save ng data sa database
                    FlashMessage::set('error', 'Something went wrong. Please try again.', 'alert alert-danger');
                    $this->view('user/register', $data);
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
        // I-clear ang lahat ng session data para sa security
        $_SESSION = array();

        // I-destroy ang session completely
        session_unset();
        session_destroy();

        // I-redirect sa login page pagkatapos mag-logout
        header('Location: ' . URL_ROOT . '/user/login');
        exit;
    }

    // Private method para sa pag-redirect base sa role ng user
    private function redirectBasedOnRole($role) {
        // Switch statement para sa iba't ibang roles ng user
        switch ($role) {
            case 'admin':
                // Kung admin ang role, pumunta sa admin dashboard
                header('Location: ' . URL_ROOT . '/admin');
                break;
            case 'doctor':
                // Kung doctor ang role, pumunta sa doctor dashboard
                header('Location: ' . URL_ROOT . '/doctor');
                break;
            case 'patient':
                // Kung patient ang role, pumunta sa patient dashboard
                header('Location: ' . URL_ROOT . '/patient');
                break;
            default:
                // Kung hindi kilala ang role, bumalik sa login page
                header('Location: ' . URL_ROOT . '/user/login');
                break;
        }
    }
}