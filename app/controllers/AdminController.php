<?php

/**
 * AdminController Class
 * 
 * Ang class na ito ang humahawak ng lahat ng admin-related functions sa system.
 * Ito ang controller na responsible sa pag-manage ng admin dashboard at iba pang admin features.
 * 
 * Features:
 * - Admin authentication at authorization
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
        if(!isset($_SESSION['user_id']) OR $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . URL_ROOT . '/user/login');
            exit;
        }

        // Ini-initialize ang Admin model para sa database operations
        $this->adminModel = $this->model('Admin');
    }

    //Default view
    public function index() {

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
}