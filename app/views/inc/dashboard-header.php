<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0&icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= URL_ROOT ?>/assets/css/style.css">
    <title><?= $data['title'] ?></title>
</head>

<body class="admin">

    <!-- flash message -->
    <header>
        <div class="header-container">
            <div class="flex text-2xl header-icon-container font-bold gap-1"><span class="material-symbols-sharp">
                dashboard
            </span>Dashboard</div>
            <div class="header-school-section flex justify-end gap-2">
                <div class="school-name-container font-bold flex flex-col">
                    <h2>eCare Hospital Solutions</h2>
                <p>ecare@email.com</p>
                </div>
                <div class="school-icon">
                    <img src="./assets/img/aics.png" style="width: 50px; margin-right: 5px; padding: 4px" alt="">
                </div>
            </div>
        </div>
    </header>

    <?php include APP_ROOT . '/views/inc/flash-message.php' ?>

    <!-- sidebar -->
    <?php include APP_ROOT . '/views/inc/sidebar.php' ?>

    <!-- navbar -->
    <?php include APP_ROOT . '/views/inc/navbar.php' ?>