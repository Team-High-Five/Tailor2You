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
            <img src="<?php echo URLROOT; ?>/public/img/admin/logo.jpg" alt="Tailor2You Logo">
            <!-- Replace with your logo image path -->
        </div>
        <div class="profile-section">
            <i class="fas fa-bell"></i>
            <div class="user-info">
                <span>
                    <?php if (isset($_SESSION['user_first_name'])): ?>
                        <?php echo $_SESSION['user_first_name']; ?>
                    <?php else: ?>
                        Guest
                    <?php endif; ?>
                </span>
                <?php if (!empty($_SESSION['user_profile_pic'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['user_profile_pic']); ?>"
                        alt="User Avatar">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/img/Avatar.png" alt="User Avatar">
                <?php endif; ?>
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