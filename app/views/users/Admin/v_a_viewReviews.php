<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- Admin Review Form -->
<div class="complaint-form">
<div class="review-form-container">
    <h2>View Reviews</h2>
    
    <!-- Review Text -->
    <label for="reviewText">Review Text:</label>
    <textarea id="reviewText" name="reviewText" rows="4" disabled></textarea>

    <!-- Ratings -->
    <div class="section-title">Ratings:</div>
    <div class="ratings">
        ★ ★ ★ ★ ★
    </div>

    <!-- User Information Section -->
    <div class="section-title">User Information:</div>
    <div class="user-info">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" disabled>

        <label for="userID">User ID:</label>
        <input type="text" id="userID" name="userID" disabled>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" disabled>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" disabled>
    </div>

    <!-- Response History Section -->
    <div class="section-title">Response History</div>
    <label for="notes">Add Notes:</label>
    <textarea id="notes" name="notes" rows="4"></textarea>

    <!-- Buttons -->
    <div class="button-container">
        <button class="save-btn">Save Notes</button>
        <button class="accept-btn">Accept</button>
        <button class="reject-btn">Reject</button>
    </div>
</div>
</div>
</body>
</html>
