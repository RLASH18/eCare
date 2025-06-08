<?php
/**
 * Bootstrap File - Entry Point ng Application
 * 
 * Ito ang pangunahing entry point ng application kung saan:
 * 1. Ina-load ang mga kinakailangang configuration files
 * 2. Ina-load ang mga core classes ng application
 * 3. Ina-initialize ang application
 */

// I-load ang configuration file na may database credentials at iba pang settings
require_once '../config.php';

// I-load ang mga core classes ng application
require_once '../app/core/App.php';        // Main router at bootstrap class
require_once '../app/core/Controller.php'; // Base controller class
require_once '../app/core/Database.php';   // Database connection handler
require_once '../app/helper/FlashMessage.php'; //Message class

// Gumawa ng instance ng App class para simulan ang application
$app = new App;