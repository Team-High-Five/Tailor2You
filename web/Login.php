<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="logo.png" alt="Tailor2You Logo">
        </div>
        <div class="login-box_main">
            <div class="login-box">
                <h2>LOG IN</h2>
                <form name="Login" action="processLogin.php" method="post">
                    <div class="input-group">
                        <div class="input-group_top">
                            <span>Email</span>
                        </div>
                        <input type="email" name="email" placeholder="" required>
                    </div>
                    <div class="input-group">
                        <div class="input-group_top">
                            <span>Password </span>
                            <a href="#" class="forgot-password">Forgot?</a>
                        </div>
                        <input type="password" name="password" placeholder="" required>
                    </div>
                    <a href="#">
                        <button class="login-btn" type="submit" >Log In</button>
                    </a>
                    <a href="#">
                        <button class="google-btn">
                            <img src="google_logo.png" alt="Google icon">
                            Sign up with Google
                        </button>
                    </a>
                    <a href="#">
                        <button class="create-account-btn">Create Account</button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>