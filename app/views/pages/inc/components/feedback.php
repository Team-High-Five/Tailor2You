<section class="feedback">
    <div class="feedback-container">
        <!-- Feedback Cards -->
        <div class="feedback-cards">
            <h1 class="main-heading">We would love to hear about your experience!</h1>
            <div class="feedback-scroller">
                <div id="feedback-list">
                    <?php if (!empty($data['reviews'])): ?>
                        <?php foreach ($data['reviews'] as $review): ?>
                            <div class="feedback-card">
                                <p class="feedback-text">"<?php echo htmlspecialchars($review->review_text); ?>"</p>
                                <p class="feedback-rating">Rating: <?php echo str_repeat('⭐', $review->rating); ?></p>
                                <p class="feedback-date"><?php echo date('F j, Y', strtotime($review->created_at)); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No feedback available yet.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Navigation Controls -->
            <div class="feedback-navigation">
                <button class="nav-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                <div class="scroll-indicator">
                    <div class="scroll-progress"></div>
                </div>
                <button class="nav-btn next-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Feedback Form or Sign In Button -->
        <div class="feedback-form-container">
            <?php if (isLoggedIn()): ?>
                <!-- Logged-in users see feedback form -->
                <h2 class="form-title">Share Your Experience</h2>
                <form id="feedback-form" action="<?php echo URLROOT; ?>/Feedback/submit" method="POST">
                    <div class="form-group">
                        <label for="rating">Rate Us</label>
                        <select id="rating" name="rating" required>
                            <option value="" disabled selected>Select a rating</option>
                            <option value="5">5 Stars - Excellent</option>
                            <option value="4">4 Stars - Very Good</option>
                            <option value="3">3 Stars - Good</option>
                            <option value="2">2 Stars - Fair</option>
                            <option value="1">1 Star - Poor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="feedback">Your Feedback</label>
                        <textarea id="feedback" name="feedback" placeholder="Tell us what you liked and how we can improve..." rows="4" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Submit Feedback</button>
                </form>
            <?php else: ?>
                <!-- Non-logged-in users see sign-in button -->
                <div class="signin-prompt">
                    <h3>Want to share your experience?</h3>
                    <p>Sign in to leave your feedback and help us improve.</p>
                    <a href="<?php echo URLROOT; ?>/users/login" class="signin-btn">Sign In to Add Feedback</a>
                </div>
            <?php endif; ?>
        </div>
        <script src="<?php echo URLROOT; ?>/public/js/feedback.js"></script>
</section>