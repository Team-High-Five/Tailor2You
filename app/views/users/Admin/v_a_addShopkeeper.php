<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="main-content">
    <div class="container">
        <h2>Add Shopkeeper</h2>
        <div class="form-section">
            <div class="left-column">
                <img src="<?php echo URLROOT; ?>/img/default-profile.png" alt="Profile Picture" id="profileImagePreview">
            </div>
            <div class="right-column">
                <form action="<?php echo URLROOT; ?>/admin/addShopkeeper" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" required>
                        </div>
                        <div class="input-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone_number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="nic">NIC</label>
                            <input type="text" id="nic" name="nic">
                        </div>
                        <div class="input-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" id="birth_date" name="birth_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="home_town">Home Town</label>
                            <input type="text" id="home_town" name="home_town">
                        </div>
                        <div class="input-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address">
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio"></textarea>
                    </div>
                    <div class="input-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category">
                    </div>
                    <div class="input-group">
                        <label for="profile_pic">Profile Picture</label>
                        <input type="file" id="profile_pic" name="profile_pic" onchange="previewImage(event)">
                    </div>
                    <div class="input-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="save-btn">Save</button>
                        <a href="<?php echo URLROOT; ?>/admin/manageShopkeeper" class="cancel-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('profileImagePreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>