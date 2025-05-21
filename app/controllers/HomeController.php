<?php

class HomeController extends Controller{

    public function index() {
        // $this->view('home/home');
        $this->view('user/login');
    }
}