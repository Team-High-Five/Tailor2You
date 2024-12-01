<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
<!-- Main Content Section -->
<div class="main-content">
    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-bar">
            <input type="text" placeholder="To quickly find specific users">
            <button><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div class="button-container">
        <a href="<?php echo URLROOT; ?>/admin/addTailor" class="add-btn"><i class="fas fa-user-plus"></i> Add Tailor</a>
    </div>
    <!-- User Table -->
    <table class="user-table">
        <thead>
            <tr>
                <th>Tailor ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['tailors'] as $tailor): ?>
                <tr>
                    <td><?php echo $tailor->user_id ?></td>
                    <td><?php echo $tailor->name ?></td>
                    <td><?php echo $tailor->phone_number ?></td>
                    <td><?php echo $tailor->email ?></td>
                    <td><?php echo $tailor->status ?> </td>
                    <td>
                        <div class="button-container">
                            <a href="<?php echo URLROOT; ?>/admin/editTailor/<?php echo $tailor->user_id; ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                            <form action="<?php echo URLROOT; ?>/admin/deleteTailor/<?php echo $tailor->user_id; ?>" method="post" style="display:inline;" onsubmit="return confirmDelete()">
                                <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </div>    
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this tailor?');
}
</script>
</body>
</html>