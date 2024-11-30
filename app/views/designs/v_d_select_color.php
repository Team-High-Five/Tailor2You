<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
    <div class="design-details-container">
        <div class="color-form">
            <div class="color-header">
                <span>Select a Color</span>
            </div>
            <section class="color-grid">
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/shadeblue1.jpg" alt="Shade Blue">
                    <p class="color-name">Shade Blue</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/gray1.jpg" alt="Gray">
                    <p class="color-name">Gray</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/yellow1.jpg" alt="Yellow">
                    <p class="color-name">Yellow</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/Greenblank1.jpg" alt="Green">
                    <p class="color-name">Green</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/black1.jpg" alt="Black">
                    <p class="color-name">Black</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
            </section>
            <div class="continue-button">
                <a href="<?php echo URLROOT ?>/Designs/enterMeasurement"><button class="continue-btn">Continue</button></a>
            </div>
        </div>
    </div>
    <div class="design-image-container">
        <img src="<?php echo URLROOT; ?>/public/img/designs/design1.jpeg" alt="Design">
        <div class="design-details">
            <div class="design-name">
                <span>Design Name</span>
            </div>
            <div class="design-description">
                <span>Design Description</span>
            </div>
        </div>
    </div>
</div>
</body>