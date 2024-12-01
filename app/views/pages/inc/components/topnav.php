<header class="header">
    <div class="logo">
        <img src="<?php echo URLROOT; ?>/public/img/logo_brown.png" alt="Tailor House Logo">
    </div>
    <nav class="nav-links">
        <a href="<?php echo URLROOT ?>/pages/index" class="nav-link" data-target="index">Home</a>
        <a href="#colllection" class="nav-link" id="collectionLink" data-target="menspage#colllection">Collection</a>
        <a href="#genderSection" class="nav-link" id="customTailoringLink" data-target="index.php#genderSection">Custom Tailoring</a>
        <a href="<?php echo URLROOT ?>/pages/tailorPage" class="nav-link" data-target="tailorPage">Master Tailors</a>
        <a href="#" class="nav-link">About Atelier</a>
        <a href="#" class="nav-link">Contact</a>
    </nav>
    <div class="icons">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'customer'): ?>
            <div class="dropdown">
                <span class="account-text"><?php echo $_SESSION['user_first_name']; ?></span>
                <?php if (!empty($_SESSION['user_profile_pic'])): ?>
                    <img class="page-user-icon" src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['user_profile_pic']); ?>" alt="User Avatar">
                <?php else: ?>
                    <i class="fas fa-user-circle profile-icon"></i>
                <?php endif; ?>
                <div class="dropdown-menu">
                    <a href="<?php echo URLROOT; ?>/customers/profile">Profile</a>
                    <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="dropdown">
                <span class="account-text">Account</span>
                <i class="fas fa-user dropdown-toggle"></i>
                <div class="dropdown-menu">
                    <a href="<?php echo URLROOT; ?>/users/selectCreateAccount">Create Account</a>
                    <a href="<?php echo URLROOT; ?>/users/login">Sign In</a>
                </div>
            </div>
        <?php endif; ?>
        <i class="fas fa-heart" onclick="requireLogin()"></i>
        <i class="fas fa-shopping-cart" onclick="requireLogin()"></i>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const target = link.getAttribute('data-target');
                if (target) {
                    window.location.href = '<?php echo URLROOT; ?>/pages/' + target;
                }
            });
        });
    });
</script>