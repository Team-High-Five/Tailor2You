<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/changepassword.css'>
<script src="<?php echo URLROOT; ?>/public/js/customer/changepass-validations.js"></script>

<div class="passcontainer">
    <main class="main-content">
        <section class="content">
            <h2>Change Password</h2>

            <?php flash('user_message'); ?>

            <form id="changePasswordForm" class="change-form" action="<?php echo URLROOT; ?>/Customers/changePassword" method="post" onsubmit="return validateChangePasswordForm()">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           placeholder="Enter current password" />
                    <span id="current_password_err" class="error"><?php echo $data['current_password_err'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           placeholder="Enter new password" />
                    <span id="new_password_err" class="error"><?php echo $data['new_password_err'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           placeholder="Confirm new password" />
                    <span id="confirm_password_err" class="error"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </section>
    </main>
</div>

<!-- <style>
    .error {
        color: red;
        font-size: 14px;
    }
</style> -->

