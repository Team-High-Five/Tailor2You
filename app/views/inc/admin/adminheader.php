<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo SITENAME ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/admin/styles.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/public/js/admin.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>

<body>
    <div class="background-overlay"></div>
    <!-- Header Section -->
    <div class="header-container">
        <header class="header">
            <!-- Logo -->
            <div class="logo">
                <img src="<?php echo URLROOT; ?>/public/img/admin/logo.jpg" alt="Tailor2You Logo">
            </div>
             <!-- Search Bar -->
             
            <!-- Icons Section -->
            <div class="icons-section">
                <!-- Email Icon -->
                <a href="#" class="icon-link">
                    <i class="fas fa-envelope"></i>
                </a>
                <!-- Notification Icon -->
                <a href="#" class="icon-link">
                    <i class="fas fa-bell"></i>
                </a>
                <!-- Logout Icon -->
                <a href="<?php echo URLROOT; ?>/pages/index" class="icon-link">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <div class="user-info">
                    <span>
                        <?php echo isset($data['adminDetails']->first_name) ? $data['adminDetails']->first_name : 'Guest'; ?>
                    </span>
                    <?php if (!empty($data['adminDetails']->profile_pic)): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['adminDetails']->profile_pic); ?>" alt="User Avatar">
                    <?php else: ?>
                        <img src="<?php echo URLROOT; ?>/public/img/Avatar.png" alt="User Avatar">
                    <?php endif; ?>
                </div>
            </div>
        </header>
    </div>
</body>

</html>