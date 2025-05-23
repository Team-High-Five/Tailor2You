<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="complaint-form">
    <div class="container">
        <div class="form-section">
            <div class="left-column">
                <?php if (!empty($data['shopkeeper']->profile_pic)): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['shopkeeper']->profile_pic); ?>"
                        alt="User Profile Picture">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/img/default-profile.png" alt="Default Profile Picture">
                <?php endif; ?>
                <p><?php echo $data['shopkeeper']->first_name . ' ' . $data['shopkeeper']->last_name; ?></p>
                <p><?php echo $data['shopkeeper']->email; ?></p>
                <p><?php echo $data['shopkeeper']->phone_number; ?></p>
            </div>
            <div class="right-section">
            <h2>Basic Info</h2>
            <form action="<?php echo URLROOT; ?>/admin/updateShopkeeper" method="post" enctype="multipart/form-data" onsubmit="return confirmSave()">
                <input type="hidden" name="user_id" value="<?php echo $data['shopkeeper']->user_id; ?>">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" value="<?php echo $data['shopkeeper']->first_name; ?>" required>

                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last_name" value="<?php echo $data['shopkeeper']->last_name; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $data['shopkeeper']->email; ?>" required>

                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone_number" value="<?php echo $data['shopkeeper']->phone_number; ?>" required>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo $data['shopkeeper']->address; ?>" required>
                <div class="input-group">
                        <label for="profile_pic">Profile Picture</label>
                        <input type="file" id="profile_pic" name="profile_pic">
                    </div>
                <label for="account-status">Account Status</label>
                <select id="account-status" name="status" required>
                    <option value="active" <?php if($data['shopkeeper']->status == 'active') echo 'selected'; ?>>Active</option>
                    <option value="inactive" <?php if($data['shopkeeper']->status == 'inactive') echo 'selected'; ?>>Inactive</option>
                </select>
                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save</button>
                    <button type="reset" class="cancel-btn" onclick="return confirmCancel()">Cancel</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmSave() {
    return confirm('Are you sure you want to save these changes?');
}

function confirmCancel() {
    if (confirm('Are you sure you want to cancel?')) {
        window.location.href = '<?php echo URLROOT; ?>/admin/manageShopkeeper';
    }
    return false;
}
</script>
</body>
</html>
