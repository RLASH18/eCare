<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="<?php echo URL_ROOT ?>/assets/css/style.css">
    <title>Register</title>
</head>

<body>
<<<<<<< HEAD
    <?php include APP_ROOT . '/views/inc/flash-message.php'?>

    <form action="<?= URL_ROOT; ?>/user/register" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" required>
        <label for="full_name">full name</label>
        <input type="text" name="full_name" required>
        <label for="email">Email</label>
        <input type="email" name="email" required>
        <label for="phone">Phone number</label>
        <input type="text" name="phone" required>
        <label for="role">Role</label>
        <select name="role" id="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select>
        <button type="submit">Register</button>
    </form>
=======
    <div class="flex min-h-screen items-center justify-center">
        <div class="form-container w-lg p-6">
            <h1 class="text-center font-bold m-4 text-xl">Register</h1>
            <form action="<?= URL_ROOT; ?>/user/register" method="POST">
                <div class="fields">
                    <div class="input-fields">
                        <label for="full_name">full name</label>
                        <input type="text" name="full_name" required>
                    </div>
                    <div class="input-fields">
                        <label for="username">Username</label>
                        <input type="text" name="username" required>
                    </div>
                </div>

                <div class="fields">
                <div class="input-fields">
                <label for="password">Password</label>
                <input type="password" name="password" required>
                </div>

                <div class="input-fields">
                <label for="confirm_password">Confirm password</label>
                <input type="password" name="confirm_password" required>
                </div>
                </div>

                <div class="email-phone-container">
                <label for="email">Email</label>
                <input type="email" name="email" required>
                </div>

                <div class="email-phone-container">
                <label for="phone">Phone number</label>
                <input type="number" name="phone" required>
                </div>

                <div class="role-container">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                </select>
                </div>

                <div class="register-button-container">
                <button class="w-48" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>

>>>>>>> c562c53eb51eb5d10e9963cc77046505e9426b58
</body>

</html>