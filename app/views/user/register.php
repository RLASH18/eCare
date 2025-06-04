<?php include APP_ROOT . '/views/inc/header.php' ?>

<div class="flex min-h-screen items-center justify-center">
    <div class="form-container w-lg p-6">
        <h1 class="text-center font-bold m-4 text-xl">Register</h1>
        <form action="<?= URL_ROOT ?>/user/register" method="POST">
            <div class="fields">
                <div class="input-fields">
                    <input type="text" name="full_name" placeholder="Full name" required>
                    <?php if (!empty($data['full_name_err'])): ?>
                        <p><?= $data['full_name_err'] ?></p>
                    <?php endif ?>
                </div>
                <div class="input-fields">
                    <input type="text" name="username" placeholder="Username" required>
                    <?php if (!empty($data['username_err'])): ?>
                        <p><?= $data['username_err'] ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="fields">
                <div class="input-fields">
                    <input type="password" name="password"  required>
                    <?php if (!empty($data['password_err'])): ?>
                        <p><?= $data['password_err'] ?></p>
                    <?php endif ?>
                </div>

                <div class="input-fields">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <?php if (!empty($data['confirm_password_err'])): ?>
                        <p><?= $data['confirm_password_err'] ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="email-phone-container">
                <input type="email" name="email" placeholder="Email" required>
                <?php if (!empty($data['email_err'])): ?>
                    <p><?= $data['email_err'] ?></p>
                <?php endif ?>
            </div>

            <div class="email-phone-container">
                <input type="text" name="phone" placeholder="Phone" required>
                <?php if (!empty($data['phone_err'])): ?>
                    <p><?= $data['phone_err'] ?></p>
                <?php endif ?>
            </div>

            <div class="role-container">
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

            <h2 class="line-design"><span>Or</span></h2>

            <div class="signIn-button-container">
                <a class="signIn-button w-48 text-center" href="<?= URL_ROOT ?>/user/login">Sign In</a>
            </div>
        </form>
        <div class="sign-in-message-container w-60 text-xs">
            <div class="sign-in-message">Already have an account? Login your account here.</div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/footer.php' ?>