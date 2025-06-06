<?php include APP_ROOT . '/views/inc/header.php' ?>

<div class="flex items-center min-h-screen justify-center">
    <div class="form-container p-6">
        <div class="form-header">
            <h1 class="login-text font-bold">Login to eCare</h1>
        </div>

        <form action="<?= URL_ROOT ?>/user/login" method="POST">

            <div class="username-container input-container">
                <img src="<?= URL_ROOT ?>/assets/img/user.png" width="19px" alt="">
                <input type="text" name="user_input" class="w-full bg-gray-300" placeholder="Username or Email" required>
            </div>

            <div class="password-container input-container">
                <img src="<?= URL_ROOT ?>/assets/img/lock.png" width="19px" alt="">
                <input type="password" name="password" class="w-full bg-gray-300" placeholder="Password" required>
            </div>

            <div class="remember-forgot-container">
                <div class="radio-remember"><input type="checkbox"><span class="remember-message">Remember Me</span></div>
                <a href="#">Forgot Password?</a>
            </div>

            <div class="login-button-container">
                <button type="submit" class="login-button w-48">Log in</button>
            </div>

            <h2 class="line-design"><span>Or</span></h2>

            <div class="signUp-button-container">
                <a class="signUp-button w-48 text-center" href="<?= URL_ROOT ?>/user/register">Sign Up</a>
            </div>

        </form>
        
        <div class="sign-up-message-container w-60 text-xs">
            <div class="sign-up-message">Don't have an account? Create your account, it takes less than a minute</div>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/inc/footer.php' ?>
