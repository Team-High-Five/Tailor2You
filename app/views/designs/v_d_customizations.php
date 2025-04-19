<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="customization-page-container">
    <div class="customization-content">
        <div class="customization-header">
            <h1>Customize Your Design</h1>
            <p>Select your preferred style elements to create your perfect garment</p>
        </div>

        <div class="customization-categories">
            <!-- Collar Options -->
            <div class="customization-category">
                <h2>Collar Styles</h2>
                <div class="customization-options">
                    <div class="option-card selected">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/collar-regular.jpg" alt="Regular Collar">
                        </div>
                        <div class="option-details">
                            <h3>Regular</h3>
                            <p>Classic collar style suitable for formal occasions</p>
                        </div>
                    </div>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/collar-button-down.jpg" alt="Button-Down Collar">
                        </div>
                        <div class="option-details">
                            <h3>Button-Down</h3>
                            <p>Collar points fastened down with buttons</p>
                        </div>
                    </div>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/collar-spread.jpg" alt="Spread Collar">
                        </div>
                        <div class="option-details">
                            <h3>Spread</h3>
                            <p>Wider angle between collar points</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cuff Options -->
            <div class="customization-category">
                <h2>Cuff Styles</h2>
                <div class="customization-options">
                    <div class="option-card selected">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/cuff-barrel.jpg" alt="Barrel Cuff">
                        </div>
                        <div class="option-details">
                            <h3>Barrel</h3>
                            <p>Standard cuff with buttons</p>
                        </div>
                    </div>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/cuff-french.jpg" alt="French Cuff">
                        </div>
                        <div class="option-details">
                            <h3>French</h3>
                            <p>Double-length cuff folded back, secured with cufflinks</p>
                        </div>
                    </div>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/cuff-convertible.jpg" alt="Convertible Cuff">
                        </div>
                        <div class="option-details">
                            <h3>Convertible</h3>
                            <p>Can be worn with buttons or cufflinks</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Options -->
            <div class="customization-category">
                <h2>Button Style</h2>
                <div class="customization-options button-options">
                    <div class="option-card selected">
                        <div class="option-circle" style="background-color: #f5f5f5;"></div>
                        <span>Pearl White</span>
                    </div>
                    <div class="option-card">
                        <div class="option-circle" style="background-color: #222;"></div>
                        <span>Black</span>
                    </div>
                    <div class="option-card">
                        <div class="option-circle" style="background-color: #8B4513;"></div>
                        <span>Brown</span>
                    </div>
                    <div class="option-card">
                        <div class="option-circle" style="background-color: #c4a77d;"></div>
                        <span>Gold</span>
                    </div>
                </div>
            </div>

            <!-- Pocket Options -->
            <div class="customization-category">
                <h2>Pocket Style</h2>
                <div class="customization-options">
                    <div class="option-card selected">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/pocket-single.jpg" alt="Single Pocket">
                        </div>
                        <div class="option-details">
                            <h3>Single Pocket</h3>
                            <p>Standard left breast pocket</p>
                        </div>
                    </div>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/pocket-none.jpg" alt="No Pocket">
                        </div>
                        <div class="option-details">
                            <h3>No Pocket</h3>
                            <p>Clean, pocket-free design</p>
                        </div>
                    </div>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT; ?>/public/img/designs/customization/pocket-double.jpg" alt="Double Pocket">
                        </div>
                        <div class="option-details">
                            <h3>Double Pocket</h3>
                            <p>Pockets on both sides</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="customization-actions">
            <a href="<?php echo URLROOT; ?>/Designs/enterMeasurement" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Measurements
            </a>
            <a href="<?php echo URLROOT; ?>/Designs/appointment" class="continue-button">
                Continue to Appointment <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="design-preview">
        <div class="preview-header">
            <h2>Design Preview</h2>
        </div>
        <div class="preview-image">
            <img src="<?php echo URLROOT; ?>/public/img/designs/shirt-preview.jpg" alt="Shirt Preview">
        </div>
        <div class="preview-details">
            <div class="preview-item">
                <span class="label">Design:</span>
                <span class="value">Classic Shirt</span>
            </div>
            <div class="preview-item">
                <span class="label">Collar:</span>
                <span class="value">Regular</span>
            </div>
            <div class="preview-item">
                <span class="label">Cuff:</span>
                <span class="value">Barrel</span>
            </div>
            <div class="preview-item">
                <span class="label">Pocket:</span>
                <span class="value">Single</span>
            </div>
            <div class="preview-item">
                <span class="label">Buttons:</span>
                <span class="value">Pearl White</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple option selection functionality
        const optionCards = document.querySelectorAll('.option-card');

        optionCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from siblings
                const siblings = card.parentElement.querySelectorAll('.option-card');
                siblings.forEach(sibling => {
                    sibling.classList.remove('selected');
                });

                // Add selected class to clicked card
                card.classList.add('selected');

                // Update preview (in a real app, this would be more sophisticated)
                const optionType = card.closest('.customization-category').querySelector('h2').textContent;
                const optionName = card.querySelector('h3') ?
                    card.querySelector('h3').textContent :
                    card.querySelector('span').textContent;

                // Find the right preview item to update
                if (optionType.includes('Collar')) {
                    document.querySelector('.preview-item:nth-child(2) .value').textContent = optionName;
                } else if (optionType.includes('Cuff')) {
                    document.querySelector('.preview-item:nth-child(3) .value').textContent = optionName;
                } else if (optionType.includes('Pocket')) {
                    document.querySelector('.preview-item:nth-child(4) .value').textContent = optionName;
                } else if (optionType.includes('Button')) {
                    document.querySelector('.preview-item:nth-child(5) .value').textContent = optionName;
                }
            });
        });
    });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>