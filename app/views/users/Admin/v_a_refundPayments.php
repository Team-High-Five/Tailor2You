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
                    <th>Refund ID</th>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Request Date</th>
                    <th>Processed Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table Data Placeholder for Dynamic Data -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['refund_id']) ?></td>
                        <td><?= htmlspecialchars($user['order_id']) ?></td>
                        <td><?= htmlspecialchars($user['user_name']) ?></td>
                        <td><?= htmlspecialchars($user['refund_amount']) ?></td>
                        <td>
                            <select>
                                <option value="pending" <?= $user['status'] === 'pending' ? 'selected' : '' ?>Pending</option>
                                <option value="completed" <?= $user['status'] === 'completed' ? 'selected' : '' ?>Completed</option>
                                <option value="failed" <?= $user['status'] === 'failed' ? 'selected' : '' ?>Failed</option>
                            </select>
                        </td>
                        <td><?= htmlspecialchars($user['payment_method']) ?></td>
                        <td><?= htmlspecialchars($user['request_date']) ?></td>
                        <td><?= htmlspecialchars($user['processed_date']) ?></td>
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