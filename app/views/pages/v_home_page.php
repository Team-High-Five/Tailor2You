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
<?php require_once APPROOT . '/views/pages/inc/components/feedback.php'; ?>
<span id="footer"></span>

<script src="<?php echo URLROOT; ?>/public/js/script.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/slidebar.js"></script>

<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>