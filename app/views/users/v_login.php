<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/inc/components/topnav.php'; ?>

<div class="form-container">
    <div class="form-header">
        <h1>User Login</h1>
        <p>Fill this credentials to log in</p>
    </div>
    <form action="<?php echo URLROOT?>/Users/login" method="POST">
        <div class="form-group ">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $data['email']?>">
            <span class="form-invalid"><?php echo $data['email_err']?></span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?php echo $data['password']?>">
            <span class="form-invalid"><?php echo $data['password_err']?></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
    <?php flash('register_success'); ?>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>