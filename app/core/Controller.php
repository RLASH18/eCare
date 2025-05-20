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

    public function view($view, $data = []) {
        if(file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        }

        else {
            die('Views does not exist');
        }
    }
}
