<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

    <!-- Main Content Section -->
    <div class="content">
        <!-- User Management Tabs -->
        <div class="tabs">
            <button>Customers</button>
            <button>Tailors</button>
            <button>Shopkeepers</button>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="To quickly find specific users">
            <button><i class="fas fa-search"></i></button>
        </div>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table Data Placeholder for Dynamic Data -->
         
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['customer_id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['phone_number'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <select>
                            <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>Active</option>
                            <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>Inactive</option>
                        </select>
                    </td>
                    <td>
                        <button class="view-btn"><i class="fas fa-eye"></i> View</button>
                        <button class="edit-btn"><i class="fas fa-edit"></i> Edit</button>
                        <button class="delete-btn"><i class="fas fa-trash-alt"></i> Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>