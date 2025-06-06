<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="<?= URL_ROOT ?>/assets/css/style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0&icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?= $data['title'] ?></title>
</head>

<body class="admin">

    <header>
        <div class="header-container">
            <div>Option</div>
            <div class="header-school-section">
                <h2>School</h2>
                <p>website</p>
            </div>
        </div>
    </header>

    <?php include APP_ROOT . '/views/inc/flash-message.php' ?>

    <!-- Dito na siguro mag include ng sidebar and navbar -->
    <?php include APP_ROOT . '/views/inc/sidebar.php' ?>
    

    <?php include APP_ROOT . '/views/inc/footer.php'?>