<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
<!-- Main Content Section -->
<div class="main-content">
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" placeholder="To quickly find specific users">
        <button><i class="fas fa-search"></i></button>
    </div>
    <!-- User Table -->
    <table class="user-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Complaint ID</th>
                <th>Complaint Type</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table Data Placeholder for Dynamic Data -->
        </tbody>
    </table>
</div>
</body>
</html>