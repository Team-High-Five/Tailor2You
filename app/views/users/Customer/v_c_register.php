<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
    <div class="container">
        <div class="logo">
            <img src="../<?php APPROOT?>/public/img/logo_brown.png" alt="Tailor2You Logo">
        </div>
        <div class="form-section">
            <h1>As a Customer,</h1>
            <button class="google-signup">
                <img src="../<?php APPROOT?>/public/img/google_logo.png" alt="google logo">
                Sign up with Google</button>
            <div class="or-section">
                <hr><span>OR</span><hr>
            </div>
            <form action="<?php echo URLROOT; ?>/Customers/customerRegister" method="post">
            <div class="form-row">
                <div class="input-field">
                    <input type="text" placeholder="First Name" name="first_name" required>
                    <?php if (!empty($data['first_name_err'])): ?>
                        <span class="error"><?php echo $data['first_name_err']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Last Name" name="last_name" required>
                    <?php if (!empty($data['last_name_err'])): ?>
                        <span class="error"><?php echo $data['last_name_err']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="input-field">
                    <input type="email" placeholder="Email Address" name="email" required>
                    <?php if (!empty($data['email_err'])): ?>
                        <span class="error"><?php echo $data['email_err']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="input-field">
                    <input type="tel" placeholder="Phone Number" name="phone_number" required>
                    <?php if (!empty($data['phone_number_err'])): ?>
                        <span class="error"><?php echo $data['phone_number_err']; ?></span>
                    <?php endif; ?>
                </div>
            </div>  
            <div class="form-row">
                <div class="input-field">
                    <input type="text" placeholder="NIC Number" name="NIC" required>
                    <?php if (!empty($data['nic_err'])): ?>
                        <span class="error"><?php echo $data['nic_err']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="input-field">
                    <input placeholder="Date of Birth" name="birth_date" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" />
                    <?php if (!empty($data['birth_date_err'])): ?>
                        <span class="error"><?php echo $data['birth_date_err']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="input-field">
                    <input type="text" placeholder="Home Town" name="home_town" required>
                    <?php if (!empty($data['home_town_err'])): ?>
                        <span class="error"><?php echo $data['home_town_err']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Address" name="address" required>
                    <?php if (!empty($data['address_err'])): ?>
                        <span class="error"><?php echo $data['address_err']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="continue-btn">Continue</button>
        </form> 
        </div>
        <div class="right-image-section">
            <img src="../<?php APPROOT?>/public/img/customer_register.jpeg" alt="Man Fashion">
        </div>
    </div>
</body>
</html>
