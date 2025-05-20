<?php

class UserController extends Controller {


    public function index() {
        $this->view('user/login');
    }

    public function register() {
        $this->view('user/register');
    }

    public function logout() {
        $this->view('user/logout');
    }
}