<?php

/**
 * Database Configuration
 * Dito mo ilalagay ang settings para sa database connection
 * 
 */
define('DB_HOST', 'localhost');  // Database host (usually localhost)
define('DB_NAME', 'ecare');      // Pangalan ng database mo
define('DB_USER', 'root');       // Username ng database
define('DB_PASS', '');           // Password ng database


/**
 * URL Root
 * 
 * Ito ang base URL ng website mo
 * Ginagamit para sa:
 *  - Redirects
 *  - Loading ng assets (CSS, JS, images)
 * 
 * Example: http://localhost/eCare
 */
define('URL_ROOT', 'http://localhost/eCare');


/**
 * Application Root Path
 * 
 * Ito ang absolute filesystem path ng application
 * Ginagamit para sa:
 *  - Including files
 *  - Loading views
 *  - File operations
 * 
 * Example: C:/xampp/htdocs/eCare/app
 * 
 */
define('APP_ROOT', dirname(__FILE__) . '/app');