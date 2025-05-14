<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<!-- side navigation -->
<div class="login-container">
    <div class="login-box">
        <h2>LOG IN</h2>
        <form name="Login" action="<?php echo URLROOT ?>/Users/login" method="post">
            <div class="input-group">
                <div class="input-group_top">
                    <span>Email</span>
                </div>
                <input type="email" name="email" placeholder="" required>
                <span class="form-invalid"><?php echo !empty($data['email_err']) ? $data['email_err'] : ''; ?></span>
            </div>
            <div class="input-group">
                <div class="input-group_top">
                    <span>Password </span>
                    <a href="<?php echo URLROOT; ?>/Users/forgotPassword" class="forgot-password">Forgot?</a>
                </div>
                <input type="password" name="password" placeholder="" required>
                <span class="form-invalid"><?php echo !empty($data['password_err']) ? $data['password_err'] : ''; ?></span>
            </div>
            <div class="btn-container">
                <button class="login-btn" type="submit">Log In</button>
                <button class="google-btn">
                    <img src="../<?php APPROOT ?>/public/img/google_logo.png" alt="Google icon">
                    Sign up with Google
                </button>

            </div>
        </form>
        <a href="<?php echo URLROOT ?>/Users/selectCreateAccount"> <button class="create-btn" class="create-account-btn">Create Account</button></a>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>