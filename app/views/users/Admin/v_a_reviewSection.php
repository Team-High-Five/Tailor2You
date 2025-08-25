<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<!-- Main Content Section -->
<div class="main-content">
    

    <!-- Review Table -->
    <table class="user-table" id="reviewTable">
        <thead>
            <tr>
                <th>Review ID</th>
                <th>User ID</th>
                <th>Review Text</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Admin Notes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($data['reviews']) && !empty($data['reviews'])): ?>
                <?php foreach ($data['reviews'] as $review): ?>
                    <tr>
                        <td><?php echo $review->review_id; ?></td>
                        <td><?php echo $review->user_id; ?></td>
                        <td><?php echo htmlspecialchars($review->review_text); ?></td>
                        <td><?php echo $review->rating; ?></td>
                        <td>
                            <form action="<?php echo URLROOT; ?>/Feedback/updateStatus/<?php echo $review->review_id; ?>" method="POST" class="status-form">
                                <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                    <option value="pending" <?php echo $review->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="accepted" <?php echo $review->status == 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                                    <option value="rejected" <?php echo $review->status == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <textarea name="admin_notes" class="admin-notes" placeholder="Add notes"><?php echo htmlspecialchars($review->admin_notes); ?></textarea>
                        </td>
                        <td class="action-column">
                            <a href="<?php echo URLROOT; ?>/admin/viewReview/<?php echo $review->review_id; ?>" class="view-btn">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="<?php echo URLROOT; ?>/admin/deleteReview/<?php echo $review->review_id; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this review?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No reviews found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- JavaScript for Search Functionality -->
<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('reviewTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(filter)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? '' : 'none';
    }
}

// Function for automatically saving admin notes when changed
document.addEventListener('DOMContentLoaded', function() {
    const adminNotes = document.querySelectorAll('.admin-notes');
    
    adminNotes.forEach(note => {
        note.addEventListener('blur', function() {
            const reviewId = this.closest('tr').querySelector('td:first-child').textContent;
            const noteText = this.value;
            const statusDropdown = this.closest('tr').querySelector('.status-dropdown');
            const status = statusDropdown.value;
            
            // Send AJAX request to update the notes
            fetch(`${URLROOT}/Feedback/updateNotes/${reviewId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `admin_notes=${encodeURIComponent(noteText)}&status=${encodeURIComponent(status)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optional: Show success message
                    console.log('Notes updated successfully');
                } else {
                    console.error('Failed to update notes');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
</body>
</html>
