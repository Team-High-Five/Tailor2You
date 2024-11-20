<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="profile-form-container">
    <div class="profile-form">
      <form action="<?php echo URLROOT; ?>/tailors/profileUpdate" method="POST" enctype="multipart/form-data">
        <div class="profile-pic">
          <label for="upload-photo">
            <?php if (empty($data['tailor']->profile_pic)): ?>
              <img src="<?php echo URLROOT; ?>/public/img/Add_Image.png" alt="Profile Picture" id="profile-preview">
            <?php else: ?>
              <img src="data:image/jpeg;base64,<?php echo base64_encode($data['tailor']->profile_pic); ?>"
                alt="Profile Picture" id="profile-preview">
            <?php endif; ?>
          </label>
          <input type="file" id="upload-photo" name="profile_pic" accept="image/*" style="display: none;">
          <div>
            <strong>User ID:</strong> <?php echo $_SESSION['tailor_id']; ?>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $data['tailor']->first_name; ?>"
              required>
            <?php if (!empty($data['first_name_err'])): ?>
              <span class="error"><?php echo $data['first_name_err']; ?></span>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $data['tailor']->last_name; ?>"
              required>
            <?php if (!empty($data['last_name_err'])): ?>
              <span class="error"><?php echo $data['last_name_err']; ?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $data['tailor']->email; ?>" required>
            <?php if (!empty($data['email_err'])): ?>
              <span class="error"><?php echo $data['email_err']; ?></span>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number"
              value="<?php echo $data['tailor']->phone_number; ?>" required>
            <?php if (!empty($data['phone_number_err'])): ?>
              <span class="error"><?php echo $data['phone_number_err']; ?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="nic">NIC</label>
            <input type="text" id="nic" name="nic" value="<?php echo $data['tailor']->nic; ?>" required>
            <?php if (!empty($data['nic_err'])): ?>
              <span class="error"><?php echo $data['nic_err']; ?></span>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="birth_date">Birth Date</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo $data['tailor']->birth_date; ?>"
              required>
            <?php if (!empty($data['birth_date_err'])): ?>
              <span class="error"><?php echo $data['birth_date_err']; ?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-two-group">
          <div class="form-group">
            <label for="home_town">Home Town</label>
            <input type="text" id="home_town" name="home_town" value="<?php echo $data['tailor']->home_town; ?>"
              required>
            <?php if (!empty($data['home_town_err'])): ?>
              <span class="error"><?php echo $data['home_town_err']; ?></span>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $data['tailor']->address; ?>" required>
            <?php if (!empty($data['address_err'])): ?>
              <span class="error"><?php echo $data['address_err']; ?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-group">
          <label for="bio">Bio</label>
          <textarea id="bio" name="bio" placeholder="Bio"><?php echo $data['tailor']->bio; ?></textarea>
          <?php if (!empty($data['bio_err'])): ?>
            <span class="error"><?php echo $data['bio_err']; ?></span>
          <?php endif; ?>
        </div>
        <div class="radio-group">
          <label class="title">Category:</label>
          <label><input type="radio" name="category" value="Gents" <?php echo $data['tailor']->category == 'Gents' ? 'checked' : ''; ?>> Gents</label>
          <label><input type="radio" name="category" value="Ladies" <?php echo $data['tailor']->category == 'Ladies' ? 'checked' : ''; ?>> Ladies</label>
          <label><input type="radio" name="category" value="Both" <?php echo $data['tailor']->category == 'Both' ? 'checked' : ''; ?>> Both</label>
          <?php if (!empty($data['category_err'])): ?>
            <span class="error"><?php echo $data['category_err']; ?></span>
          <?php endif; ?>
        </div>


        <div class="buttons">
          <button type="submit" class="submit-btn">Update Profile</button>
          <a href="<?php echo URLROOT; ?>/tailors/profile" class="reset-btn"> <button
              class="reset-btn">Reset</button></a>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.getElementById('upload-photo').addEventListener('change', function (event) {
    const reader = new FileReader();
    reader.onload = function () {
      const output = document.getElementById('profile-preview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  });
</script>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>