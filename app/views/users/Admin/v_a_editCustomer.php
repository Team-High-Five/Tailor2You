<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
<div class="complaint-form">
    <div class="container">
        <!-- User Info Section -->
        <div class="form-section">
            <!-- Left Column: Profile Picture -->
            <div class="left-column">
                <?php if (!empty($data['customer']->profile_pic)): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['customer']->profile_pic); ?>"
                        alt="User Profile Picture">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/img/default-profile.png" alt="Default Profile Picture">
                <?php endif; ?>
                <p><?php echo $data['customer']->first_name . ' ' . $data['customer']->last_name; ?></p>
                <p><?php echo $data['customer']->email; ?></p>
                <p><?php echo $data['customer']->phone_number; ?></p>
            </div>

            <!-- Right Column: Form to Edit Details -->
            <div class="right-column">
                <form action="<?php echo URLROOT; ?>/admin/updateCustomer" method="POST" enctype="multipart/form-data"
                    onsubmit="return confirmSave()">
                    <input type="hidden" name="user_id" value="<?php echo $data['customer']->user_id; ?>">
                    <div class="row">
                        <div class="input-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name"
                                value="<?php echo $data['customer']->first_name; ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name"
                                value="<?php echo $data['customer']->last_name; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $data['customer']->email; ?>"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone_number"
                                value="<?php echo $data['customer']->phone_number; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="nic">NIC</label>
                            <input type="text" id="nic" name="nic" value="<?php echo $data['customer']->nic; ?>">
                        </div>
                        <div class="input-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" id="birth_date" name="birth_date"
                                value="<?php echo $data['customer']->birth_date; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="home_town">Home Town</label>
                            <input type="text" id="home_town" name="home_town"
                                value="<?php echo $data['customer']->home_town; ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address"
                                value="<?php echo $data['customer']->address; ?>" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="profile_pic">Profile Picture</label>
                        <input type="file" id="profile_pic" name="profile_pic">
                    </div>
                    <div class="input-group">
                        <label for="status">Account Status</label>
                        <select id="status" name="status" required>
                            <option value="active" <?php if ($data['customer']->status == 'active')
                                echo 'selected'; ?>>
                                Active</option>
                            <option value="inactive" <?php if ($data['customer']->status == 'inactive')
                                echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button type="submit">Save</button>
                        <button type="button" class="cancel-btn" onclick="return confirmCancel()">Cancel</button>
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
            window.location.href = '<?php echo URLROOT; ?>/admin/manageCustomer';
        }
        return false;
    }
</script>
</body>

</html>