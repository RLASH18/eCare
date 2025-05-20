<?php

class AdminController extends Controller {

    // private $adminModel;

    // public function __construct() {

    //     $this->adminModel = $this->model('Admin');
    // }

    public function index() {

        $this->view('admin/admin');
    }

}