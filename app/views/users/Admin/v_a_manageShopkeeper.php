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
                    <th>ShopKeeper ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <!-- Table Data Placeholder for Dynamic Data -->
            <?php foreach ($data['shopkeepers'] as $shopkeeper): ?>
                <tr>
                    <td><?php echo $shopkeeper->user_id ?></td>
                    <td><?php echo $shopkeeper->name ?></td>
                    <td><?php echo $shopkeeper->phone_number ?></td>
                    <td><?php echo$shopkeeper->email ?></td>
                    <td><?php echo $shopkeeper->status; ?> </td>
                    <td>
                    <div class="button-container">
                        <a href="<?php echo URLROOT; ?>/admin/editShopkeeper/<?php echo $shopkeeper->user_id; ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <form action="<?php echo URLROOT; ?>/admin/deleteShopkeeper/<?php echo $shopkeeper->user_id; ?>" method="post" style="display:inline;" onsubmit="return confirmDelete()">
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
    return confirm('Are you sure you want to delete this user?');
    }  
    </script>
</body>


</html>



