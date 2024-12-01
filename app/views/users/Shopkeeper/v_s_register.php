<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<div class="container">
    <div class="left-image-section">
        <img src="<?php echo URLROOT; ?>/public/img/shopkeeper_reg.png" alt="Man Fashion">
    </div>
    <div class="form-section">
        <h1>As a Shopkeeper,</h1>
        <button class="google-signup">
            <img src="<?php echo URLROOT; ?>/public/img/google_logo.png" alt="google logo">
            Sign up with Google</button>
        <div class="or-section">
            <hr><span>OR</span>
            <hr>
        </div>
        <form id="registerForm" action="<?php echo URLROOT; ?>/Shopkeepers/shopkeeperRegister" method="post">
            <div class="form-row">
                <div class="input-field">
                    <input type="text" placeholder="First Name" name="first_name" required>
                    <span class="error" id="first_name_err"></span>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Last Name" name="last_name" required>
                    <span class="error" id="last_name_err"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="input-field">
                    <input type="email" placeholder="Email Address" name="email" required>
                    <span class="error" id="email_err"></span>
                    <?php if (!empty($data['email_err'])): ?>
                        <span class="error"><?php echo $data['email_err']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="input-field">
                    <input type="tel" placeholder="Phone Number" name="phone_number" required>
                    <span class="error" id="phone_number_err"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="input-field">
                    <input type="text" placeholder="NIC Number" name="NIC" required>
                    <span class="error" id="NIC_err"></span>
                </div>
                <div class="input-field">
                    <input placeholder="Date of Birth" name="birth_date" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" />
                    <span class="error" id="birth_date_err"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="input-field">
                    <input type="text" placeholder="Home Town" name="home_town" required>
                    <span class="error" id="home_town_err"></span>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Address" name="address" required>
                    <span class="error" id="address_err"></span>
                </div>
            </div>
            <button type="submit" class="right-continue-btn">Continue</button>
        </form>
    </div>
    <div class="logo">
        <img src="<?php echo URLROOT; ?>/public/img/logo_brown.png" alt="Tailor2You Logo">
    </div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/user-validations.js"></script>
</body>

</html>