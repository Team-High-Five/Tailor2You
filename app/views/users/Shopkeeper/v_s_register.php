<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<div class="container">
    <div class="left-image-section">
        <img src="../<?php APPROOT ?>/public/img/shopkeeper_reg.png" alt="Man Fashion">
    </div>
    <div class="form-section">
        <h1>As a Shopkeeper,</h1>
        <button class="google-signup">
            <img src="../<?php APPROOT ?>/public/img/google_logo.png" alt="google logo">
            Sign up with Google</button>
        <div class="or-section">
            <hr><span>OR</span>
            <hr>
        </div>
        <form action="<?php echo URLROOT ?>/Shopkeepers/shopkeeperRegister" method="post">
            <div class="form-row">
                <input type="text" placeholder="First Name" name="first_name" required>
                <input type="text" placeholder="Last Name" name="last_name" required>
            </div>
            <div class="form-row">
                <input type="email" placeholder="Email Address" name="email" required>
                <input type="tel" placeholder="Phone Number" name="phone_number" required>
            </div>
            <div class="form-row">
                <input type="text" placeholder="NIC Number" name="NIC" required>
                <input placeholder="Date of Birth" name="birth_date" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" />
            </div>
            <div class="form-row">
                <input type="text" placeholder="Home Town" name="home_town" required>
                <input type="text" placeholder="Address" name="address" required>
            </div>
            <button type="submit" class="right-continue-btn">Continue</button>
        </form>
    </div>
    <div class="logo">
        <img src="../<?php APPROOT ?>/public/img/logo_brown.png" alt="Tailor2You Logo">
    </div>

</div>
</body>

</html>