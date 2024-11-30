<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITENAME ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/admin/styles.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/public/js/admin.js" defer></script>
</head>
<body>
    <div class="background-overlay"></div>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/public/img/admin/logo.jpg" alt="Tailor2You Logo"> <!-- Replace with your logo image path -->
        </div>
        <div class="profile-section">
            <i class="fas fa-bell"></i>
            <div class="profile-info">
                <img src="<?php echo URLROOT; ?>/public/img/admin/propic.png" alt="Profile Picture" class="profile-pic">
                <div>
                    <p class="profile-title">Title</p>
                    <p class="profile-description">Description</p>
                </div>
            </div>
            <i class="fas fa-ellipsis-h" onclick="toggleDropdown()"></i>
            <!-- Dropdown menu -->
            <div class="dropdown-menu" id="dropdownMenu">
                <button onclick="logout()">Logout</button>
                <button onclick="signOut()">Sign Out</button>
            </div>
        </div>
    </header>
</body>
</html>