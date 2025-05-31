<?php $title = 'eCare Register' ?>
<?php include APP_ROOT . '/views/inc/header.php' ?>

<div class="flex min-h-screen items-center justify-center">
    <div class="form-container w-lg p-6">
        <h1 class="text-center font-bold m-4 text-xl">Register</h1>
        <form action="<?= URL_ROOT ?>/user/register" method="POST">
            <div class="fields">
                <div class="input-fields">
                    <label for="full_name">full name</label>
                    <input type="text" name="full_name" required>
                    <?php if (!empty($data['full_name_err'])): ?>
                        <p><?= $data['full_name_err'] ?></p>
                    <?php endif ?>
                </div>
                <div class="input-fields">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                    <?php if (!empty($data['username_err'])): ?>
                        <p><?= $data['username_err'] ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="fields">
                <div class="input-fields">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                    <?php if (!empty($data['password_err'])): ?>
                        <p><?= $data['password_err'] ?></p>
                    <?php endif ?>
                </div>

                <div class="input-fields">
                    <label for="confirm_password">Confirm password</label>
                    <input type="password" name="confirm_password" required>
                    <?php if (!empty($data['confirm_password_err'])): ?>
                        <p><?= $data['confirm_password_err'] ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="email-phone-container">
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <?php if (!empty($data['email_err'])): ?>
                    <p><?= $data['email_err'] ?></p>
                <?php endif ?>
            </div>

            <div class="email-phone-container">
                <label for="phone">Phone number</label>
                <input type="text" name="phone" required>
                <?php if (!empty($data['phone_err'])): ?>
                    <p><?= $data['phone_err'] ?></p>
                <?php endif ?>
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

<?php include APP_ROOT . '/views/inc/footer.php' ?>