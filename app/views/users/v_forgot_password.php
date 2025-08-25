<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<!-- side navigation -->
<div class="login-container">
    <div class="login-box">
        <h2>PASSWORD RECOVERY</h2>
        <p class="recovery-text">Enter your email address and we'll send you instructions to reset your password.</p>
        
        <?php flash('forgot_password_message'); ?>
        
        <form name="ForgotPassword" action="<?php echo URLROOT ?>/Users/forgotPassword" method="post">
            <div class="input-group">
                <div class="input-group_top">
                    <span>Email</span>
                </div>
                <input type="email" name="email" placeholder="Enter your email address" required>
                <span class="form-invalid"><?php echo !empty($data['email_err']) ? $data['email_err'] : ''; ?></span>
            </div>
            
            <div class="btn-container">
                <button class="login-btn" type="submit">Send Recovery Link</button>
            </div>
        </form>
        
        <div class="recovery-links">
            <p>Remember your password? <a href="<?php echo URLROOT ?>/Users/login" class="forgot-password">Back to Login</a></p>
        </div>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>