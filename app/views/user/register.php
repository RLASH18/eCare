<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
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
</body>

</html>