<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="container">

  <!-- Form Section -->
  <div class="logo">
    <img src="<?php echo URLROOT; ?>/public/img/logo_brown.png" alt="Tailor2You Logo"> <!-- Update the logo source -->
  </div>
  <div class="form-section">

    <h1>Create a password</h1>

    <form id="createPasswordForm" action="<?php echo URLROOT; ?>/tailors/createPassword" method="post">
      <div class="form-line">
        <input type="password" name="password" placeholder="Password" required>
        <span class="error" id="password_err"></span>
      </div>
      <div class="form-line">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <span class="error" id="confirm_password_err"></span>
      </div>
      <button type="submit" class="continue-btn">Submit</button>
    </form>
  </div>

  <!-- Image Section -->
  <div class="right-image-section">
    <img src="<?php echo URLROOT; ?>/public/img/Tailor.png" alt="Man Fashion">
  </div>

</div>
<!-- JavaScript -->
<script src="<?php echo URLROOT; ?>/public/js/pass-validations.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/user-validations.js"></script>
</body>

</html>