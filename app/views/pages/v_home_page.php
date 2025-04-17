<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<!-- slider -->
<?php require_once APPROOT . '/views/pages/inc/components/main_slidebar.php'; ?>
<!-- Shop by Category Section -->
<section class="category">
    <div class="topic">Shop By Category</div><br>
    <div class="topic-soon">Available Soon</div>
    <div class="category-grid">
        <button class="category-item" style="background-image: url('<?php echo URLROOT; ?>/public/img/home/men.jpg');">
            <h1>Men</h1>
        </button>
        <button class="category-item" style="background-image: url('<?php echo URLROOT; ?>/public/img/home/women.jpg');">
            <h1>Women</h1>
        </button>
        <button class="category-item" style="background-image: url('<?php echo URLROOT; ?>/public/img/home/girl.jpg');">
            <h1>Girls</h1>
        </button>
        <button class="category-item" style="background-image: url('<?php echo URLROOT; ?>/public/img/home/boy.jpg');">
            <h1>Boys</h1>
        </button>
    </div>
</section>

<?php
$designs = $data['designs'] ?? [];
require_once APPROOT . '/views/pages/inc/components/design.php';
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
<footer class="footer">
    <div class="footer-container">
        <!-- About Us Section -->
        <div class="aboutUs">
            <h3>About Us</h3>
            <p>
                At Tailor2You, we’re dedicated to providing personalized fashion services right at your convenience. Whether you're looking for custom-made outfits, alterations, or quick fixes, our expert tailors are here to bring your vision to life. With our platform, you can easily find the nearest tailors in your area and get the quality and fit you deserve.
            </p>
        </div>

        <!-- Contact Us Section -->
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>
                Email: <a href="mailto:contact@example.com">tailor2you@gmail.com</a><br>
                Phone: <a href="tel:+1234567890">+94 767 665 560</a><br>

            </p>
        </div>
    </div>
    <p class="footer-rights">
        &copy; 2024 Tailor2You. All rights reserved.
    </p>
</footer>
<script src="<?php echo URLROOT; ?>/public/js/script.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/slidebar.js"></script>


</body>

</html>