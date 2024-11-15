<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/inc/components/topnav.php'; ?>
<div class="form-container">
    <div class="form-header">
        <h1>User Sign Up</h1>
        <p>Please fill this form to create an account</p>
    </div>
    <form action="<?php echo URLROOT?>/Users/Register" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value = "<?php echo $data['name']?>">
            <span class="form-invalid"><?php echo $data['name_err']?></span>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value = "<?php echo $data['email']?>">
            <span class="form-invalid"><?php echo $data['email_err']?></span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" value = "<?php echo $data['password']?>">
            <span class="form-invalid"><?php echo $data['password_err']?></span>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" value = "<?php echo $data['confirm_password']?>">     
            <span class="form-invalid"><?php echo $data['confirm_password_err']?></span>

        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>