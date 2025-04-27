<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="<?php echo URLROOT; ?>/admin/admindashboard"><i class="fas fa-home"></i> Dashboard</a>
    <button class="dropdown-btn"><i class="fas fa-users"></i> User Management <i class="fas fa-caret-down"></i></button>
    <div class="dropdown-container">
        <a href="<?php echo URLROOT; ?>/admin/manageCustomer">Manage Customers</a>
        <a href="<?php echo URLROOT; ?>/admin/manageTailor">Manage Tailors</a>
        <a href="<?php echo URLROOT; ?>/admin/manageShopkeeper">Manage Shopkeepers</a>
    </div>
    <a href="<?php echo URLROOT; ?>/admin/inventoryManagement"><i class="fas fa-boxes"></i> Inventory Management</a>
    <a href="<?php echo URLROOT; ?>/admin/refundPayments"><i class="fas fa-dollar-sign"></i> Refund Payments</a>
    <a href="<?php echo URLROOT; ?>/admin/reviewSection"><i class="fas fa-comments"></i> Reviews</a>
    <a href="<?php echo URLROOT; ?>/admin/generateReports"><i class="fas fa-file-alt"></i> Reports</a>
</div>

<!-- Menu Icon to Open Sidebar -->
<div class="menu-icon" onclick="toggleSidebar()">&#9776;</div>