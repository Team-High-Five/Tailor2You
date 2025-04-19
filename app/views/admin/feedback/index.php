<?php require_once APPROOT . '/views/admin/inc/header.php'; ?>
<?php require_once APPROOT . '/views/admin/inc/sidebar.php'; ?>

<div class="main-content">
    <div class="page-header">
        <h1>Feedback Management</h1>
        <a href="<?php echo URLROOT; ?>/feedback/stats" class="btn btn-secondary">
            <i class="fas fa-chart-bar"></i> View Statistics
        </a>
    </div>
    
    <?php flash('feedback_message'); ?>
    
    <div class="card">
        <div class="card-header">
            <div class="filter-controls">
                <button class="filter-btn active" data-status="all">All</button>
                <button class="filter-btn" data-status="published">Published</button>
                <button class="filter-btn" data-status="pending">Pending</button>
                <button class="filter-btn" data-status="rejected">Rejected</button>
            </div>
        </div>
        
        <div class="card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rating</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['feedback'] as $feedback): ?>
                        <tr class="feedback-row" data-status="<?php echo $feedback->status; ?>">
                            <td><?php echo $feedback->name; ?></td>
                            <td><?php echo $feedback->email; ?></td>
                            <td>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $feedback->rating): ?>
                                        <span class="star filled">★</span>
                                    <?php else: ?>
                                        <span class="star">☆</span>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </td>
                            <td class="feedback-text"><?php echo $feedback->feedback_text; ?></td>
                            <td><?php echo date('M d, Y', strtotime($feedback->created_at)); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $feedback->status; ?>">
                                    <?php echo ucfirst($feedback->status); ?>
                                </span>
                            </td>
                            <td class="actions">
                                <div class="dropdown">
                                    <button class="dropdown-toggle">Actions</button>
                                    <div class="dropdown-menu">
                                        <?php if($feedback->status != 'published'): ?>
                                            <form action="<?php echo URLROOT; ?>/feedback/updateStatus/<?php echo $feedback->feedback_id; ?>" method="post">
                                                <input type="hidden" name="status" value="published">
                                                <button type="submit" class="dropdown-item">Publish</button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <?php if($feedback->status != 'pending'): ?>
                                            <form action="<?php echo URLROOT; ?>/feedback/updateStatus/<?php echo $feedback->feedback_id; ?>" method="post">
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item">Mark as Pending</button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <?php if($feedback->status != 'rejected'): ?>
                                            <form action="<?php echo URLROOT; ?>/feedback/updateStatus/<?php echo $feedback->feedback_id; ?>" method="post">
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="dropdown-item">Reject</button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <form action="<?php echo URLROOT; ?>/feedback/delete/<?php echo $feedback->feedback_id; ?>" method="post" class="delete-form">
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($data['feedback'])): ?>
                        <tr>
                            <td colspan="7" class="text-center">No feedback available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const feedbackRows = document.querySelectorAll('.feedback-row');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            const status = button.getAttribute('data-status');
            
            // Filter rows
            feedbackRows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    
    // Confirm delete
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this feedback?')) {
                e.preventDefault();
            }
        });
    });
    
    // Dropdown functionality
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        toggle.addEventListener('click', () => {
            menu.classList.toggle('show');
        });
        
        // Close when clicked outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    });
});
</script>

<?php require_once APPROOT . '/views/admin/inc/footer.php'; ?>
