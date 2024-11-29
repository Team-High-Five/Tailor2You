<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
    <!-- Main Content Section -->
    <div class="content">
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
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= $user['user_name'] ?></td>
                        <td><?= $user['complaint_id'] ?></td>
                        <td><?= $user['complaint_type'] ?></td>
                        <td><?= $user['date'] ?></td>
                        <td>
                            <select>
                                <option value="pending" <?= $user['status'] === 'pending' ? 'selected' : '' ?>Pending</option>
                                <option value="processed" <?= $user['status'] === 'processed' ? 'selected' : '' ?>Processed</option>
                            </select>
                        </td>
                        <td>
                            <button class="view-btn"><i class="fas fa-eye"></i> View</button>
                            <button class="edit-btn"><i class="fas fa-edit"></i> Resolve</button>
                            <button class="delete-btn"><i class="fas fa-trash-alt"></i> Reject</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>