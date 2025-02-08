<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>

<div class="passcontainer">
    <main class="main-content">
        <section class="content">
            <h2>Change Password</h2>

            <?php flash('user_message'); ?>

            <form class="change-form" action="<?php echo URLROOT; ?>/Users/changePassword" method="post">
                
                <!-- Current Password -->
                <label for="current-password">Current Password</label>
                <input type="password" id="current_password" name="current_password" value="<?php echo htmlspecialchars($data['current_password'] ?? ''); ?>">
                <?php if (!empty($data['current_password_err'])) : ?>
                    <span class="error"><?php echo $data['current_password_err']; ?></span>
                <?php endif; ?>

                <!-- New Password -->
                <label for="new-password">New Password</label>
                <input type="password" id="new_password" name="new_password" value="<?php echo htmlspecialchars($data['new_password'] ?? ''); ?>">
                <?php if (!empty($data['new_password_err'])) : ?>
                    <span class="error"><?php echo $data['new_password_err']; ?></span>
                <?php endif; ?>

                <!-- Confirm Password -->
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo htmlspecialchars($data['confirm_password'] ?? ''); ?>">
                <?php if (!empty($data['confirm_password_err'])) : ?>
                    <span class="error"><?php echo $data['confirm_password_err']; ?></span>
                <?php endif; ?>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </section>
    </main>
</div>

<style>
    .error {
        color: red;
        font-size: 14px;
    }
</style>

</body>
</html>
