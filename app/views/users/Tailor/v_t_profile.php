<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="profile-form-container">
    <div class="profile-form">
      <div class="profile-pic">
        <label for="upload-photo">
          <?php if ($data['tailor']->profile_pic): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($data['tailor']->profile_pic); ?>" alt="Profile Picture" id="profile-preview">
          <?php else: ?>
            <img src="../<?php echo APPROOT; ?>/public/img/Add_Image.png" alt="Profile Picture" id="profile-preview">
          <?php endif; ?>
        </label>
        <input type="file" id="upload-photo" name="profile_pic" accept="image/*" style="display: none;">
        <div>
          <strong>User ID:</strong> <?php echo $_SESSION['tailor_id']; ?>
        </div>
      </div>
      <form action="<?php echo URLROOT; ?>/tailors/profileUpdate" method="POST" enctype="multipart/form-data">
        <div class="form-two-group">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $data['tailor']->first_name; ?>" required>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $data['tailor']->last_name; ?>" required>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $data['tailor']->email; ?>" required>
          </div>
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $data['tailor']->phone_number; ?>" required>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="nic">NIC</label>
            <input type="text" id="nic" name="nic" value="<?php echo $data['tailor']->nic; ?>" required>
          </div>
          <div class="form-group">
            <label for="birth_date">Birth Date</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo $data['tailor']->birth_date; ?>" required>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="home_town">Home Town</label>
            <input type="text" id="home_town" name="home_town" value="<?php echo $data['tailor']->home_town; ?>" required>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $data['tailor']->address; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label for="bio">Bio</label>
          <textarea id="bio" name="bio" placeholder="Bio"><?php echo $data['tailor']->bio; ?></textarea>
        </div>
        <div class="radio-group">
          <label>Category:</label>
          <label><input type="radio" name="category" value="Gents" <?php echo $data['tailor']->category == 'Gents' ? 'checked' : ''; ?>> Gents</label>
          <label><input type="radio" name="category" value="Ladies" <?php echo $data['tailor']->category == 'Ladies' ? 'checked' : ''; ?>> Ladies</label>
          <label><input type="radio" name="category" value="Both" <?php echo $data['tailor']->category == 'Both' ? 'checked' : ''; ?>> Both</label>
        </div>
        <div class="buttons">
          <button type="submit" class="submit-btn">Update Profile</button>
          <a href="<?php echo URLROOT; ?>/tailors/profile" class="reset-btn">Reset</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('upload-photo').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('profile-preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>