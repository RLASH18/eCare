<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container container flex h-screen items-center justify-center">
        <div class="form-container w-96">
        <div class="form-header">
            <h1 class="login-text font-bold">Login</h1>
        </div>
        <form action="">
        <div class="username-container input-container">
            <img src="assets/img/user.png" width="19px" alt="">
            <input type="text" class="w-full bg-gray-300" placeholder="Username">
        </div>
        <div class="email-container input-container">
            <img src="assets/img/email.png" width="19px"alt="">
            <input type="email" class="w-full bg-gray-300"placeholder="Email">
        </div>
        <div class="password-container input-container">
            <img src="assets/img/lock.png" width="19px" alt="">
            <input type="password" class="w-full bg-gray-300"placeholder="Password">
        </div>
        <div class="remember-forgot-container">
            <div class="radio-remember"><input type="radio"><span class="remember-message">Remember Me</span></div>
            <a href="#">Forgot Password?</a>
        </div>
        <div class="login-button-container">
        <button class="login-button w-48">Log in</button>
        </div>
        <h2 class="line-design"><span>Or</span></h2>
        <div class="signUp-button-container"><button class="signUp-button w-48">Sign Up</button></div>
        </form>
        <div class="sign-up-message-container w-60 text-xs">
            <div class="sign-up-message">Don't have an account? Create your account, it takes less than a minute</div>
        </div>
        </div>
    </div>
</body>
</html>