<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>
<div class="main-content">
    <div class="profile-form-container">
        <div class="profile-form">
            <form id="profileForm" action="<?php echo URLROOT; ?>/Shopkeepers/profileUpdate" method="POST" enctype="multipart/form-data">
                <div class="profile-pic">
                    <div class="profile-pic-wrapper">
                        <?php if (empty($data['user']->profile_pic)): ?>
                            <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Profile Picture" id="profile-preview">
                        <?php else: ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($data['user']->profile_pic); ?>" alt="Profile Picture" id="profile-preview">
                        <?php endif; ?>
                        <div class="profile-pic-overlay">
                            <i class="ri-camera-line"></i>
                        </div>
                    </div>
                    <input type="file" id="upload-photo" name="profile_pic" accept="image/*" display="none">
                    <div class="user-id">
                        <strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?>
                    </div>
                </div>

                <div class="form-two-group">
                    <div class="form-group">
                        <label for="first_name">Shop Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo $data['user']->first_name; ?>" required>
                        <span class="error" id="first_name_err"></span>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Owner's Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $data['user']->last_name; ?>" required>
                        <span class="error" id="last_name_err"></span>
                    </div>
                </div>

                <div class="form-two-group">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $data['user']->email; ?>" readonly>
                        <span class="error" id="email_err"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="<?php echo $data['user']->phone_number; ?>" required>
                        <span class="error" id="phone_number_err"></span>
                    </div>
                </div>

                <div class="form-two-group">
                    <div class="form-group">
                        <label for="nic">NIC</label>
                        <input type="text" id="nic" name="NIC" value="<?php echo $data['user']->nic; ?>" required>
                        <span class="error" id="NIC_err"></span>
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Birth Date</label>
                        <input type="date" id="birth_date" name="birth_date" value="<?php echo $data['user']->birth_date; ?>" required>
                        <span class="error" id="birth_date_err"></span>
                    </div>
                </div>

                <div class="form-two-group">
                    <div class="form-group">
                        <label for="home_town">Home Town</label>
                        <input type="text" id="home_town" name="home_town" value="<?php echo $data['user']->home_town; ?>" required>
                        <span class="error" id="home_town_err"></span>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?php echo $data['user']->address; ?>" required>
                        <span class="error" id="address_err"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="4"><?php echo $data['user']->bio; ?></textarea>
                    <span class="error" id="bio_err"></span>
                </div>

                <div class="radio-group">
                    <span class="title">Category:</span>
                    <label>
                        <input type="radio" name="category" value="Gents" <?php echo $data['user']->category == 'Gents' ? 'checked' : ''; ?>>
                        Gents
                    </label>
                    <label>
                        <input type="radio" name="category" value="Ladies" <?php echo $data['user']->category == 'Ladies' ? 'checked' : ''; ?>>
                        Ladies
                    </label>
                    <label>
                        <input type="radio" name="category" value="Both" <?php echo $data['user']->category == 'Both' ? 'checked' : ''; ?>>
                        Both
                    </label>
                </div>

                <button type="button" class="submit-btn" onclick="confirmUpdate()">Update Profile</button>
                <button type="button" class="delete-btn" onclick="confirmDelete()">Delete Profile</button>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Popup -->
<div id="confirmationPopup" class="popup">
    <div class="popup-content">
        <div class="modal-header">
            <h2>Confirmation</h2>
            <span class="close-btn" onclick="closePopup()">&times;</span>
        </div>
        <div class="update-modal-body">
            <i class="ri-error-warning-line"></i>
            <p>Are you sure you want to make changes?</p>
            <div class="button-rows">
                <button type="submit" class="submit-btn" onclick="submitForm()">Yes, Update</button>
                <button type="button" class="reset-btn" onclick="closePopup()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteUserModal" class="modal">
    <div class="delete-modal-content">
        <div class="modal-header">
            <h1>Confirm Deletion</h1>
            <button class="close-btn" onclick="closeDeleteUserModal()">&times;</button>
        </div>
        <div class="delete-modal-body">
            <p>Are you sure you want to delete this profile?</p>
            <form id="deleteUserForm" action="<?php echo URLROOT; ?>/Users/deleteUser/<?php echo $_SESSION['user_id']; ?>" method="post">
                <button type="submit" class="submit-btn">Yes, Delete</button>
                <button type="button" class="reset-btn" onclick="closeDeleteUserModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/user-profile-validations.js"></script>
<script>
    document.getElementById('profile-preview').addEventListener('click', function() {
        document.getElementById('upload-photo').click();
    });

    document.getElementById('upload-photo').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    function confirmUpdate() {
        document.getElementById('confirmationPopup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('confirmationPopup').style.display = 'none';
    }

    function submitForm() {
        if (validateForm()) {
            document.getElementById('profileForm').submit();
        }
    }

    function confirmDelete() {
        document.getElementById('deleteUserModal').style.display = 'block';
    }

    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').style.display = 'none';
    }

    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('deleteUserModal')) {
            document.getElementById('deleteUserModal').style.display = 'none';
        }
    });
</script>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>