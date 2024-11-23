<header class="header">
    <div class="logo">
        <img src="<?php echo URLROOT; ?>/public/img/logo_brown.png" alt="Tailor House Logo">
    </div>
    <nav class="nav-links">
        <a href="<?php echo URLROOT ?>/pages/index" class="nav-link">Home</a>
        <a href="#" class="nav-link">Collection</a>
        <a href="#" class="nav-link">Custom Tailoring</a>
        <a href="#" class="nav-link">Master Tailors</a>
        <a href="#" class="nav-link">About Atelier</a>
        <a href="#" class="nav-link">Contact</a>
    </nav>
    <div class="icons">
        <div class="dropdown">
            <span class="account-text">Account</span>
            <i class="fas fa-user dropdown-toggle"></i>
            <div class="dropdown-menu">
                <a href="<?php echo URLROOT; ?>/users/selectCreateAccount">Create Account</a>
                <a href="<?php echo URLROOT; ?>/users/login">Sign In</a>
            </div>
        </div>
        <i class="fas fa-heart" onclick="requireLogin()"></i>
        <i class="fas fa-shopping-cart" onclick="requireLogin()"></i>
    </div>
</header>