<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<div class="main-content">
    <div class="profile-form-container">

        <div class="profile-form">
            <div class="profile-pic">
                <div class="profile-pic-wrapper">
                    <?php if (empty($data['user']->profile_pic)): ?>
                        <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Profile Picture" id="profile-preview">
                    <?php else: ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['user']->profile_pic); ?>" alt="Profile Picture" id="profile-preview">
                    <?php endif; ?>
                </div>
                <div class="user-id">
                    <strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?>
                </div>
            </div>

            <div class="form-two-group">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <p id="first_name"><?php echo $data['user']->first_name; ?></p>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <p id="last_name"><?php echo $data['user']->last_name; ?></p>
                </div>
            </div>

            <div class="form-two-group">
                <div class="form-group">
                    <label for="email">Email</label>
                    <p id="email"><?php echo $data['user']->email; ?></p>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <p id="phone_number"><?php echo $data['user']->phone_number; ?></p>
                </div>
            </div>

            <div class="form-two-group">
                <div class="form-group">
                    <label for="nic">NIC</label>
                    <p id="nic"><?php echo $data['user']->nic; ?></p>
                </div>
                <div class="form-group">
                    <label for="birth_date">Birth Date</label>
                    <p id="birth_date"><?php echo $data['user']->birth_date; ?></p>
                </div>
            </div>

            <div class="form-two-group">
                <div class="form-group">
                    <label for="home_town">Home Town</label>
                    <p id="home_town"><?php echo $data['user']->home_town; ?></p>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <p id="address"><?php echo $data['user']->address; ?></p>
                </div>
            </div>

            <div class="profile-action-buttons">
                <a href="<?php echo URLROOT ?>/Customers/addMeasurements" class="profile-action-btn">Update Measurements</a>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>