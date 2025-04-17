<!-- filepath: c:\xampp\htdocs\Tailor2You\app\views\designs\v_d_select_color.php -->
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
                        <button onclick="selectColor(this, 1)">Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/gray1.jpg" alt="Gray">
                    <p class="color-name">Gray</p>
                    <div class="buttons">
                        <button onclick="selectColor(this, 2)">Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/yellow1.jpg" alt="Yellow">
                    <p class="color-name">Yellow</p>
                    <div class="buttons">
                        <button onclick="selectColor(this, 3)">Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/Greenblank1.jpg" alt="Green">
                    <p class="color-name">Green</p>
                    <div class="buttons">
                        <button onclick="selectColor(this, 4)">Select</button>
                    </div>
                </div>
                <div class="color-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/black1.jpg" alt="Black">
                    <p class="color-name">Black</p>
                    <div class="buttons">
                        <button onclick="selectColor(this, 5)">Select</button>
                    </div>
                </div>
            </section>
            <div class="continue-button">
                <button class="continue-btn" id="continueBtn" disabled>Continue</button>
            </div>
        </div>
    </div>
    <div class="design-image-container">
        <img src="<?php echo URLROOT; ?>/public/img/designs/still-life-with-classic-shirts-hanger.jpg" alt="Design">
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

<script>
    let selectedColorId = null;

    function selectColor(btnElement, colorId) {
        // Remove selected class from all color cards
        document.querySelectorAll('.color-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to the clicked card
        const selectedCard = btnElement.closest('.color-card');
        selectedCard.classList.add('selected');
        selectedColorId = colorId;

        // Enable continue button
        document.getElementById('continueBtn').removeAttribute('disabled');
    }

    // Set up continue button
    document.getElementById('continueBtn').addEventListener('click', function() {
        if (selectedColorId) {
            window.location.href = '<?php echo URLROOT; ?>/Designs/enterMeasurement/' + selectedColorId;
        }
    });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>