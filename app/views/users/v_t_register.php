<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign-Up</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/registerStyle.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../<?php APPROOT?>/public/img/logo.png" alt="Tailor2You Logo">
        </div>
        <div class="form-section">
            <h1>As a Customer,</h1>
            <button class="google-signup">
                <img src="../<?php APPROOT?>/public/img/google_logo.png" alt="google logo">
                Sign up with Google</button>
            <div class="or-section">
                <hr><span>OR</span><hr>
            </div>
            <form action="<?php echo URLROOT?>/Tailors/tailorRegister" method="post">
                <div class="form-row">
                    <input type="text" placeholder="First Name" name= "first_name" required>
                    <input type="text" placeholder="Last Name" name= "last_name" required>
                </div>
                <div class="form-row">
                    <input type="email" placeholder="Email Address" name= "email" required>
                    <input type="tel" placeholder="Phone Number" name= "phone_number"  required>
                </div>  
                <div class="form-row">
                    <input type="text" placeholder="NIC Number" name= "NIC" required>
                    <input placeholder="Date of Birth"  name= "birth_date" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" />
                </div>
                <div class="form-row">
                    <input type="text" placeholder="Home Town" name= "home_town"  required>
                    <input type="text" placeholder="Address" name= "address"  required>
                    
                </div>
                <button type="submit" class="continue-btn">Continue</button>
            </form>
        </div>
        <div class="image-section">
            <img src="../<?php APPROOT?>/public/img/customer.jpeg" alt="Man Fashion">
        </div>
    </div>
</body>
</html>
