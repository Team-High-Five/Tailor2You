<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

<div class="add-new-fabric-container">
    <div class="add-new-fabric-content">
        <div class="modal-header">
            <h1>Add New Employee</h1>
            <a href="<?php echo URLROOT ?>/Shopkeepers/displayEmployees"><button class="close-btn">&times;</button></a>
        </div>
        <div class="fabric-form-container">
            <form id="addEmployeeForm" action="<?php echo URLROOT; ?>/Shopkeepers/addNewEmployee" method="post" enctype="multipart/form-data">
                <div class="post-pic-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" required>
                    <span class="error-message" id="first_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                    <span class="error-message" id="last_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
                    <span class="error-message" id="phone_number-error"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter Email" required>
                    <span class="error-message" id="email-error"></span>
                </div>
                <div class="form-group">
                    <label for="home_town">Home Town</label>
                    <input type="text" id="home_town" name="home_town" placeholder="Enter Home Town" required>
                    <span class="error-message" id="home_town-error"></span>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('post-preview').addEventListener('click', function() {
        document.getElementById('upload-photo').click();
    });

    document.getElementById('upload-photo').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('post-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>