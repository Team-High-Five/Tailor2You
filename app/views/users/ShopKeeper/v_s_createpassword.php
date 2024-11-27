<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="container">

  <div class="left-image-section">
    <img src="../<?php APPROOT ?>/public/img/shopkeeper_reg.png" alt="Man Fashion">
  </div>
  <div class="form-section">

    <h1>Create a password</h1>

    <form action="<?php echo URLROOT; ?>/tailors/createPassword" method="post">
      <div class="form-line">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="form-line">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="right-continue-btn">Submit</button>
    </form>
  </div>

  <div class="logo">
    <img src="../<?php APPROOT ?>/public/img/logo_brown.png" alt="Tailor2You Logo">
  </div>
</div>

</body>

</html>