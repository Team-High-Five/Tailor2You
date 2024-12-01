<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="slider">
   <div class="list">
       <div class="item">
            <img src="<?php echo URLROOT; ?>/public/img/home/chooseTailor.jpg">
            <div class="overlay"></div>

            <div class="content">
                <div class="title">Choose Your Tailor,<br> Right Now</div>
                <div class="des">
                We leave no detail to chance,<br>
                Advanced measurement tools ensure accuracy down to the millimeter.
                Fabric quality, pattern alignment, and stitching are rigorously checked to ensure every piece exceeds expectations.
                Every order is a complete package, tailored to perfection and delivered with care.
                </div>
                
            </div>
        </div>
    </div>
    <!-- Group thumbnails and arrows -->
    <div class="slider-controls">
        <div class="thumbnail">
            <div class="item active">
                <img src="<?php echo URLROOT; ?>/public/img/home/hero1.png">
            </div>
            <div class="item">
                <img src="<?php echo URLROOT; ?>/public/img/home/hero3.jpg">
            </div>
        </div>
        <div class="arrows">
            <button id="prev">&lt;</button>
            <button id="next">&gt;</button>
        </div>
    </div>
    <!-- time running -->
    <div class="time"></div>
</div>
