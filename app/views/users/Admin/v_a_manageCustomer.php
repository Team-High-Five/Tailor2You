<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
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
            <?php if (isset($data['customers']) && !empty($data['customers'])): ?>
                <?php foreach ($data['customers'] as $customer): ?>
                    <tr>
                        <td><?php echo $customer->user_id; ?></td>
                        <td><?php echo $customer->name; ?></td>
                        <td><?php echo $customer->phone_number; ?></td>
                        <td><?php echo $customer->email; ?></td>
                        <td>Active</td>
                        <td>
                            <a href="#">Edit</a> | <a href="#">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No customers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>