<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

    <div class="search-container">
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
        <?php if (isset($data['customers']) && !empty($data['customers'])): ?>
            <?php foreach ($data['customers'] as $customer): ?>
                <tr>
                    <td><?php echo $customer->user_id; ?></td>
                    <td><?php echo $customer->name; ?></td>
                    <td><?php echo $customer->phone_number; ?></td>
                    <td><?php echo $customer->email; ?></td>
                    <td><?php echo $customer->status; ?> </td>
                    <td>
                        <div class="button-container">
                            <a href="<?php echo URLROOT; ?>/admin/editCustomer/<?php echo $customer->user_id; ?>"
                                class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                            <form action="<?php echo URLROOT; ?>/admin/deleteCustomer/<?php echo $customer->user_id; ?>"
                                method="post" style="display:inline;" onsubmit="return confirmDelete()">
                                <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </div>
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
</div>
</body>

</html>