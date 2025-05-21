<?php

/**
 * Base Controller Class
 * 
 * Ito ang pangunahing controller class na ginagamit ng lahat ng controllers sa application.
 * Ang class na ito ay nagbibigay ng basic functionality para sa:
 * 1. Pag-load ng models (database operations)
 * 2. Pag-load ng views (user interface)
 * 
 * Example usage:
 * class HomeController extends Controller {
 *     public function index() {
 *         $userModel = $this->model('User');
 *         $this->view('home/index', ['data' => $data]);
 *     }
 * }
 */
class Controller {

    /**
     * Constructor ng Base Controller
     * 
     * Ang constructor na ito ay:
     * 1. Tinitiyak na naka-start ang session para sa lahat ng controllers
     * 2. Ginagamit ng lahat ng controllers na naka-extend sa Controller class
     * 3. Importanteng i-call ito sa child controllers gamit ang parent::__construct()
     * 
     * Bakit kailangan ito?
     * - Para ma-handle ang user sessions sa buong application
     * - Para ma-maintain ang user login state
     * - Para ma-access ang session variables sa lahat ng controllers
     * 
     * Paano ito gumagana:
     * 1. Tinitignan kung may active na session
     * 2. Kung wala, mag-start ng bagong session
     * 3. Kung meron na, gamitin ang existing session
     * 
     * Security Features:
     * - Automatic session handling
     * - Consistent session management sa lahat ng controllers
     * - Prevention ng session-related errors
     */

    public function __construct() {
        // Tinitignan kung may active na session, kung wala, mag-start ng bago
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Model Loader
     * 
     * Ang method na ito ang gumagawa ng instance ng model class.
     * Ginagamit ito para ma-access ang database operations.
     * 
     * @param string $model - Ang pangalan ng model na gusto mong i-load (e.g., 'User', 'Appointment')
     * @return object - Ang instance ng model class
     * 
     * Example:
     * $userModel = $this->model('User');
     * $users = $userModel->getAllUsers();
     */
    public function model($model) {
        // I-load ang model file mula sa model directory
        require_once '../app/models/' . $model . '.php';
        // I-return ang bagong instance ng model
        return new $model();
    }

    /**
     * View Loader
     * 
     * Ang method na ito ang responsable sa pag-load ng view files.
     * Ginagamit ito para ipakita ang user interface ng application.
     * 
     * @param string $view - Ang path ng view file na gusto mong i-load (e.g., 'home/index', 'users/profile')
     * @param array $data - Ang data na ipapasa sa view (optional)
     * 
     * Example:
     * $this->view('home/index', ['title' => 'Home Page']);
     */
    public function view($view, $data = []) {
        // I-check kung existing ang view file
        if(file_exists('../app/views/' . $view . '.php')) {
            // I-load ang view file
            require_once '../app/views/' . $view . '.php';
        }
        // Kung hindi existing ang view file, ipakita ang error message
        else {
            die('Views does not exist');
        }
    }
}
