<?php if ($_SESSION['user_type'] == 'shopkeeper') {
    require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php';
    require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php';
    require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] == 'tailor') {
    require_once APPROOT . '/views/users/Tailor/inc/Header.php';
    require_once APPROOT . '/views/users/Tailor/inc/sideBar.php';
    require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} ?>
<div class="main-content">
    <?php flash('profile_message'); ?>
    <?php flash('profile_error'); ?>
    <?php flash('profile_success'); ?>
    <form id="profileForm" action="<?php echo URLROOT; ?>/tailors/profileUpdate" method="POST" enctype="multipart/form-data">
        <div class="profile-pic">
            <div class="profile-pic-wrapper">
                <?php if (empty($data['user']->profile_pic)): ?>
                    <img src="<?php echo URLROOT; ?>/public/img/Add_Image.png" alt="Profile Picture" id="profile-preview">
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
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $data['user']->first_name; ?>" required>
                <?php if (!empty($data['first_name_err'])): ?>
                    <span class="error"><?php echo $data['first_name_err']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $data['user']->last_name; ?>" required>
                <?php if (!empty($data['last_name_err'])): ?>
                    <span class="error"><?php echo $data['last_name_err']; ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-two-group">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $data['user']->email; ?>" readonly>
                <?php if (!empty($data['email_err'])): ?>
                    <span class="error"><?php echo $data['email_err']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $data['user']->phone_number; ?>" required>
                <?php if (!empty($data['phone_number_err'])): ?>
                    <span class="error"><?php echo $data['phone_number_err']; ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-two-group">
            <div class="form-group">
                <label for="nic">NIC</label>
                <input type="text" id="nic" name="nic" value="<?php echo $data['user']->nic; ?>" required>
                <?php if (!empty($data['nic_err'])): ?>
                    <span class="error"><?php echo $data['nic_err']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="birth_date">Birth Date</label>
                <input type="date" id="birth_date" name="birth_date" value="<?php echo $data['user']->birth_date; ?>" required>
                <?php if (!empty($data['birth_date_err'])): ?>
                    <span class="error"><?php echo $data['birth_date_err']; ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-two-group">
            <div class="form-group">
                <label for="home_town">Home Town</label>
                <input type="text" id="home_town" name="home_town" value="<?php echo $data['user']->home_town; ?>" required>
                <?php if (!empty($data['home_town_err'])): ?>
                    <span class="error"><?php echo $data['home_town_err']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo $data['user']->address; ?>" required>
                <?php if (!empty($data['address_err'])): ?>
                    <span class="error"><?php echo $data['address_err']; ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="4"><?php echo $data['user']->bio; ?></textarea>
            <?php if (!empty($data['bio_err'])): ?>
                <span class="error"><?php echo $data['bio_err']; ?></span>
            <?php endif; ?>
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
    </form>
</div>


<!-- Confirmation Modal with Single Button -->
<div id="confirmationPopup" class="modal single-button">
    <div class="modal-body">
        <div class="delete-modal-content">
            <div class="modal-header">
                <h1>Confirmation</h1>
                <button class="close-btn">&times;</button>
            </div>
            <div class="modal-content">
                <div class="confirmation-icon">
                    <i class="ri-error-warning-line"></i>
                </div>
                <p>Are you sure you want to make changes?</p>
                <div class="button-rows">
                    <button type="button" class="submit-btn" id="confirmUpdate">Yes, Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Define these functions in global scope
    function openConfirmationModal() {
        const modal = document.getElementById('confirmationPopup');
        modal.style.display = 'flex';
        void modal.offsetWidth;
        modal.classList.add('show');
    }

    function closeConfirmationModal() {
        const modal = document.getElementById('confirmationPopup');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    function confirmUpdate() {
        openConfirmationModal();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Profile picture upload
        document.getElementById('profile-preview').addEventListener('click', function() {
            document.getElementById('upload-photo').click();
        });

        document.getElementById('upload-photo').addEventListener('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const output = document.getElementById('profile-preview');
                    output.src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });

        // Button event listeners
        document.querySelector('#confirmationPopup .close-btn').addEventListener('click', function() {
            closeConfirmationModal();
        });

        // Submit the form
        document.getElementById('confirmUpdate').addEventListener('click', function() {
            document.getElementById('profileForm').submit();
        });

        // Close modal on cancel button (if it exists)
        const cancelButton = document.getElementById('cancelUpdate');
        if (cancelButton) {
            cancelButton.addEventListener('click', function() {
                closeConfirmationModal();
            });
        }

        // Close modal on background click
        document.getElementById('confirmationPopup').addEventListener('click', function(event) {
            if (event.target === this) {
                closeConfirmationModal();
            }
        });
    });
</script>
<style>
    /* Add these to your New_Pop_up_styles.css file */
    .confirmation-icon {
        text-align: center;
        margin-bottom: 20px;
    }

    .confirmation-icon i {
        font-size: 4rem;
        color: var(--warning-color);
        animation: pulse 1.5s infinite;
        display: inline-block;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .delete-modal-content p {
        text-align: center;
        font-size: 1.2rem;
        margin-bottom: 25px;
        color: var(--text-color);
    }

    /* Make button rows more appropriate for confirmation */
    .delete-modal-content .button-rows {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 10px;
    }

    /* Style for single button layout */
    .single-button .button-rows {
        grid-template-columns: 1fr;
        max-width: 200px;
        margin: 20px auto 0;
    }

    /* Add this class to the modal if you want a single button */
    .single-button .submit-btn {
        width: 100%;
        padding: 12px 20px;
        font-size: 1.1rem;
    }
</style>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>