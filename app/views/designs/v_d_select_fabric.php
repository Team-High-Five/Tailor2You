<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
    <div class="design-details-container">
        <div class="fabric-form">
            <div class="fabric-header">
                <span>Select a Fabric</span>
            </div>
            <section class="fabric-grid">
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab4.jpeg" alt="Cotton Poly Poplin Woven">
                    <p class="fabric-name">Cotton Poly Poplin Woven</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab1.jpeg" alt="Solid Linen">
                    <p class="fabric-name">Solid Linen</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab8.jpeg" alt="Silk">
                    <p class="fabric-name">Silk</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab6.jpeg" alt="Cotton">
                    <p class="fabric-name">Cotton</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/PİNTEREST.jpeg" alt="Camicia elegante">
                    <p class="fabric-name">Camicia elegante</p>
                    <div class="buttons">
                        <button>Select</button>
                    </div>
                </div>
            </section>
            <div class="continue-button">
                <a href="<?php echo URLROOT ?>/Designs/selectColor"><button class="continue-btn">Continue</button></a>
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