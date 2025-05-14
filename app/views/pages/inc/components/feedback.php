<section class="feedback">
    <div class="feedback-container">
        <!-- Feedback Cards -->
        <div class="feedback-cards">
            <h1 class="main-heading">We would love to hear about your experience!</h1>
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
        <!-- Feedback Form -->
        <div class="feedback-form-container">

            <form id="feedback-form" action="<?php echo URLROOT; ?>/Feedback/submit" method="POST">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="rating">Rate Us</label>
                <select id="rating" name="rating" required>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>

                <label for="feedback">Your Feedback</label>
                <textarea id="feedback" name="feedback" placeholder="Write feedback" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</section>