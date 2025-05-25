<?php $title = 'Admin - Add-Users' ?>
<?php include APP_ROOT . '/views/inc/dashboard-header.php' ?>

<form action="<?= URL_ROOT ?>/admin/add-user" method="POST">

    <div>
        <label for="username">Username</label>
        <input type="text" name="username" required>
        <?php if (!empty($data['username_err'])): ?>
            <p><?= $data['username_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <?php if (!empty($data['password_err'])): ?>
            <p><?= $data['password_err'] ?></p>
        <?php endif ?>

    </div>

    <div>
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" required>

        <?php if (!empty($data['confirm_password_err'])): ?>
            <p><?= $data['confirm_password_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="full_name">full name</label>
        <input type="text" name="full_name" required>

        <?php if (!empty($data['full_name_err'])): ?>
            <p><?= $data['full_name_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <?php if (!empty($data['email_err'])): ?>
            <p><?= $data['email_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="phone">Phone number</label>
        <input type="text" name="phone" required>

        <?php if (!empty($data['phone_err'])): ?>
            <p><?= $data['phone_err'] ?></p>
        <?php endif ?>
    </div>

    <div>
        <label for="role">Role</label>
        <select name="role" id="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select>

        <?php if (!empty($data['role_err'])): ?>
            <p><?= $data['role_err'] ?></p>
        <?php endif ?>
    </div>

    <button type="submit">Register</button>
</form>

<?php include APP_ROOT . '/views/inc/dashboard-footer.php' ?>