<header class="header">
    <div class="logo">
        <img src="<?php echo URLROOT; ?>/public/img/logo_brown.png" alt="Tailor House Logo">
    </div>
    <nav class="nav-links">
        <a href="<?php echo URLROOT ?>/pages/index" class="nav-link">Home</a>
        <a href="#colllection" class="nav-link" id="collectionLink">Collection</a>
        <a href="#genderSection" class="nav-link" id="customTailoringLink">Custom Tailoring</a>
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
            </di    v>
        </div>
        <i class="fas fa-heart" onclick="requireLogin()"></i>
        <i class="fas fa-shopping-cart" onclick="requireLogin()"></i>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const customTailoringLink = document.getElementById('customTailoringLink');
    const genderSection = document.getElementById('genderSection');

    customTailoringLink.addEventListener('click', function(event) {
        event.preventDefault();
        const currentUrl = window.location.href;
        const homeUrl = '<?php echo URLROOT; ?>/pages/index';

        if (currentUrl.includes(homeUrl)) {
            // If already on the home page, scroll to the section
            genderSection.scrollIntoView({
                behavior: 'smooth'
            });
        } else {
            // Redirect to the home page with the hash
            window.location.href = homeUrl + '#genderSection';
        }
    });

    // Check if the URL contains the hash and scroll to the section
    if (window.location.hash === '#genderSection') {
        genderSection.scrollIntoView({
            behavior: 'smooth'
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const collectionLink = document.getElementById('collectionLink');
    const colllection = document.getElementById('colllection');

    collectionLink.addEventListener('click', function(event) {
        event.preventDefault();
        const currentUrl = window.location.href;
        const homeUrl = '<?php echo URLROOT; ?>/pages/mensPage';

        if (currentUrl.includes(homeUrl)) {
            // If already on the home page, scroll to the section
            colllection.scrollIntoView({
                behavior: 'smooth'
            });
        } else {
            // Redirect to the home page with the hash
            window.location.href = homeUrl + '#colllection';
        }
    });

    // Check if the URL contains the hash and scroll to the section
    if (window.location.hash === '#colllection') {
        colllection.scrollIntoView({
            behavior: 'smooth'
        });
    }
});
</script>