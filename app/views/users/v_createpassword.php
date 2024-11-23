<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Password</title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/createpasswordstyle.css">
</head>
<body>

  <div class="container">
    
    <!-- Form Section -->
    <div class="logo">
        <img src="../<?php APPROOT?>/public/img/logo.png" alt="Tailor2You Logo"> <!-- Update the logo source -->
      </div>
    <div class="form-section">

      <h1>Create password</h1>

      <form action="<?php echo URLROOT; ?>/tailors/createPassword" method="post">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit" class="continue-btn">Submit</button>
      </form>
    </div>

    <!-- Image Section -->
    <div class="image-section">
      <img src="../<?php APPROOT?>/public/img/Tailor_Reg.jpeg" alt="Fashion Image"> <!-- Use the image you uploaded -->
    </div>

  </div>

</body>
</html>
