<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
<!-- Admin Review Form -->
<div class="complaint-form">
<div class="review-form-container">
    <h2>View Review</h2>
    
    <!-- Review Text -->
    <label for="reviewText">Review Text:</label>
    <textarea id="reviewText" name="reviewText" rows="4" disabled><?php echo $data['review_text']; ?></textarea>

    <!-- Ratings -->
    <div class="section-title">Ratings:</div>
    <div class="ratings">
        <?php echo str_repeat('★', $data['rating']); ?> <!-- Display stars based on rating -->
    </div>

    <!-- User Information Section -->
    <div class="section-title">User Information:</div>
    <div class="user-info">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" value="<?php echo $data['user_name']; ?>" disabled>

        <label for="userID">User ID:</label>
        <input type="text" id="userID" name="userID" value="<?php echo $data['user_id']; ?>" disabled>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>" disabled>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $data['phone']; ?>" disabled>
    </div>

    <!-- Admin Notes Section -->
    <div class="section-title">Response History</div>
    <label for="notes">Add Notes:</label>
    <textarea id="notes" name="notes" rows="4"><?php echo $data['admin_notes']; ?></textarea>

    <!-- Buttons -->
    <div class="button-container">
        <form action="<?php echo URLROOT; ?>/admin/updateReviewStatus/<?php echo $data['review_id']; ?>/accepted" method="post" style="display:inline;">
            <button type="submit" class="accept-btn">Accept</button>
        </form>
        <form action="<?php echo URLROOT; ?>/admin/updateReviewStatus/<?php echo $data['review_id']; ?>/rejected" method="post" style="display:inline;">
            <button type="submit" class="reject-btn">Reject</button>
        </form>
    </div>
</div>
</div>
</body>
</html>
