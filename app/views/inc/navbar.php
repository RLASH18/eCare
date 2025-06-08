<?php
    $currentPath = $_SERVER['REQUEST_URI'];
    
//     $trimmedUrl = trim($_SERVER['REQUEST_URI'], '/');

// // Split the path into segments
// $segments = explode('/', $trimmedUrl);

// // Grab the last segment
// $lastPart = end($segments);

// echo $lastPart;
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove any trailing slashes to avoid an empty last segment
$trimmedPath = rtrim($path, '/');

// Get the last part of the path (e.g., "my-page.php")
$lastSegment = basename($trimmedPath);

// Remove all dash characters from the last segment
$cleanSegment = str_replace('-', ' ', $lastSegment);

$url_clean = ucwords($cleanSegment);


    $icon = '';

    if($currentPath == "/eCare/admin/dashboard") {
        $icon = 'dashboard';
    }elseif($currentPath == "/eCare/admin/user-management") {
        $icon = "groups";
    }elseif($currentPath == "/eCare/admin/medical-records") {
        $icon = "health_and_safety";
    }elseif($currentPath == "/eCare/admin/prescriptions") {
        $icon = "medication";
    }elseif($currentPath == "/eCare/admin/billings") {
        $icon = "receipt_long";
    }elseif($currentPath == "/eCare/admin/inventory") {
        $icon = "inventory";
    }

?>

<header>
    <div class="header-container">
        <div class="flex text-2xl header-icon-container font-bold gap-1">
            <span class="material-symbols-sharp"><?= $icon?></span>
            <?=$url_clean?>
        </div>
        <div class="header-school-section flex justify-end gap-2">
            <div class="school-name-container font-bold flex flex-col">
                <h2>eCare Hospital Solutions</h2>
                <p>ecare@email.com</p>
            </div>
            <div class="school-icon">
                <img src="<?= URL_ROOT ?>/assets/img/aics.png" style="width: 50px; margin-right: 5px; padding: 4px" alt="">
            </div>
        </div>
    </div>
</header>