<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="main-content">
    <div class="search-container">
        <div class="search-bar">
            <input type="text" placeholder="To quickly find specific users">
            <button><i class="fas fa-search"></i></button>
        </div>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($data['users']) && !empty($data['users'])): ?>
                <?php foreach ($data['users'] as $user): ?>
                    <tr>
                        <td><?php echo $user->id; ?></td>
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->role; ?></td>
                        <td>
                            <div class="button-container">
                                <a href="<?php echo URLROOT; ?>/admin/edit<?php echo ucfirst($user->role); ?>/<?php echo $user->id; ?>" class="edit-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteUser/<?php echo $user->id; ?>" method="post" style="display:inline;" onsubmit="return confirmDelete()">
                                    <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this user?');
}
</script>
