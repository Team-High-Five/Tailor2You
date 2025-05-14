<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<!-- side navigation -->
<div class="login-container">
    <div class="login-box">
        <h2>RESET PASSWORD</h2>
        <p class="recovery-text">Create a new password for your account.</p>

        <?php flash('reset_password_message'); ?>

        <form name="ResetPassword" action="<?php echo URLROOT ?>/Users/resetPassword/<?php echo $data['token']; ?>" method="post">
            <div class="input-group">
                <div class="input-group_top">
                    <span>New Password</span>
                </div>
                <input type="password" name="password" placeholder="Enter your new password" required>
                <span class="form-invalid"><?php echo !empty($data['password_err']) ? $data['password_err'] : ''; ?></span>
            </div>

            <div class="input-group">
                <div class="input-group_top">
                    <span>Confirm Password</span>
                </div>
                <input type="password" name="confirm_password" placeholder="Confirm your new password" required>
                <span class="form-invalid"><?php echo !empty($data['confirm_password_err']) ? $data['confirm_password_err'] : ''; ?></span>
            </div>

            <div class="btn-container">
                <button class="login-btn" type="submit">Reset Password</button>
            </div>
        </form>

        <div class="recovery-links">
            <p>Remember your password? <a href="<?php echo URLROOT ?>/Users/login" class="forgot-password">Back to Login</a></p>
        </div>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>