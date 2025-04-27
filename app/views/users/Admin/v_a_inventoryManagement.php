<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="main-content">
    <table class="user-table">
        <thead>
            <tr>
                <th>Fabric ID</th>
                <th>Fabric Name</th>
                <th>Price per Meter</th>
                <th>Stock</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['fabrics'] as $fabric): ?>
                <tr>
                    <td><?php echo $fabric->fabric_id; ?></td>
                    <td><?php echo $fabric->fabric_name; ?></td>
                    <td><?php echo number_format($fabric->price_per_meter, 2); ?></td>
                    <td><?php echo $fabric->stock; ?></td>
                    <td><?php echo date('Y-m-d', strtotime($fabric->created_at)); ?></td>
                    <td>
                        <div class="button-container">
                            <!-- Edit Button -->
                            <a href="<?php echo URLROOT; ?>/admin/editFabric/<?php echo $fabric->fabric_id; ?>" class="edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="<?php echo URLROOT; ?>/admin/deleteFabric/<?php echo $fabric->fabric_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this fabric?');">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
