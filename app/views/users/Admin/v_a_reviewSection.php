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
                <th>Review ID</th>
                <th>Review Text</th>
                <th>Ratings</th>
                <th>Date</th>
                <th>Status</th>
                <th>Admin Notes</th> <!-- Display Admin Notes -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['reviews'] as $review): ?>
                <tr>
                    <td><?php echo $review->review_id; ?></td>
                    <td><?php echo $review->review_text; ?></td>
                    <td><?php echo $review->rating; ?></td>
                    <td><?php echo $review->created_at; ?></td>
                    <td><?php echo $review->status; ?></td>
                    <td><?php echo $review->admin_notes; ?></td> <!-- Display Admin Notes -->
                    <td>
                        <div class="button-container">
                            <!-- View Button -->
                            <a href="<?php echo URLROOT; ?>/admin/viewReview/<?php echo $review->review_id; ?>" class="edit-btn">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <!-- Delete Button -->
                            <form action="<?php echo URLROOT; ?>/admin/deleteReview/<?php echo $review->review_id; ?>" method="post" style="display:inline;" onsubmit="return confirmDelete()">
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
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this review?');
}
</script>
</body>
</html>
