<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<!-- slider -->
<?php require_once APPROOT . '/views/pages/inc/components/main_slidebar.php'; ?>

<span id="collection"></span>
<?php
$designs = $data['designs'] ?? [];
require_once APPROOT . '/views/pages/inc/components/new_collection.php';
?>
<!-- Image Section -->
<!-- <section class="image-section">
        <img src="image/image.png" alt="Tailoring Image">
    </section> -->
<!-- Book Appointment Section -->
<section class="appointment">
    <div class="title">Ready to Elevate Your Style?</div><br>
    <div class="italic">Meet with Expert Tailors.</div><br><br>
    <a href="<?php echo URLROOT ?>/pages/tailorPage#tailorSection"><button class="large-button">Book an Appointment</button></a>
</section>
<span id="genderSection"></span>
<?php require_once APPROOT . '/views/pages/inc/components/gender_selection.php'; ?>


<span id="feedback"></span>
<!-- Feedback Section -->
<section class="feedback">
    <div class="feedback-header">
        <p class="sub-heading">Your words matter</p>
    </div>
    <div class="feedback-container">
        <!-- Feedback Cards -->
        <div class="feedback-cards">
            <h1 class="main-heading">We would love to hear about your experience!</h1>
            <div id="feedback-list">
                <!-- Feedback dynamically loaded -->
            </div>
        </div>
        <!-- Feedback Form -->
        <div class="feedback-form-container">

            <form id="feedback-form">
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
<span id="footer"></span>

<script src="<?php echo URLROOT; ?>/public/js/script.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/slidebar.js"></script>

<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>