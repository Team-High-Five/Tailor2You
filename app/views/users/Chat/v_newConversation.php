<?php
// Load appropriate header files based on user type
if ($_SESSION['user_type'] === 'tailor') {
    $data['title'] = 'Messages | Tailor Dashboard';
    require_once APPROOT . '/views/users/Tailor/inc/Header.php';
    require_once APPROOT . '/views/users/Tailor/inc/SideBar.php';
    require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] === 'customer') {
    $data['title'] = 'Messages | Customer Dashboard';
    require_once APPROOT . '/views/users/Customer/inc/Header.php';
    require_once APPROOT . '/views/users/Customer/inc/sideBar.php';
    require_once APPROOT . '/views/users/Customer/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] === 'shopkeeper') {
    $data['title'] = 'Messages | Shopkeeper Dashboard';
    require_once APPROOT . '/views/users/ShopKeeper/inc/Header.php';
    require_once APPROOT . '/views/users/ShopKeeper/inc/SideBar.php';
    require_once APPROOT . '/views/users/ShopKeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] === 'admin') {
    $data['title'] = 'Messages | Admin Dashboard';
    require_once APPROOT . '/views/inc/admin/adminheader.php';
    require_once APPROOT . '/views/inc/admin/adminsidebar.php';
}
?>
<div class="contact-container">
    <div class="sidebar-header">
        Contact List
    </div>
    <ul class="contact-list">
        <?php if (!empty($data['users']) && is_array($data['users'])): ?>
            <?php foreach ($data['users'] as $user): ?>
                <li class="contact-item">
                    <a href="<?php echo URLROOT; ?>/Chat/index/<?php echo $user->user_id; ?>">
                        <div class="user-icon">
                            <span><?php echo strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)); ?></span>
                        </div>
                        <div class="user-details">
                            <span class="user-name"><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                            <span class="user-info">User ID: <?php echo $user->user_id; ?></span>
                            <span class="user-info">Phone: <?php echo isset($user->phone_number) ? $user->phone_number : 'N/A'; ?></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-contacts">No contacts available.</p>
        <?php endif; ?>
    </ul>
</div>

<?php
// Include appropriate footer based on user type
if ($_SESSION['user_type'] === 'tailor') {
    require_once APPROOT . '/views/users/Tailor/inc/footer.php';
} elseif ($_SESSION['user_type'] === 'customer') {
    require_once APPROOT . '/views/users/Customer/inc/footer.php';
} elseif ($_SESSION['user_type'] === 'shopkeeper') {
    require_once APPROOT . '/views/users/ShopKeeper/inc/footer.php';
} elseif ($_SESSION['user_type'] === 'admin') {
    require_once APPROOT . '/views/inc/admin/adminfooter.php';
}
?>