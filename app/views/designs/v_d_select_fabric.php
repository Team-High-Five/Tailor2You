<!-- filepath: c:\xampp\htdocs\Tailor2You\app\views\designs\v_d_select_fabric.php -->
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
                    <div class="fabric-card-content">
                        <h3 class="fabric-name">Cotton Poplin Woven</h3>
                        <p class="fabric-price">Rs. 750.00 per meter</p>
                        <div class="buttons">
                            <button class="select-btn" onclick="selectFabric(this, 1)">Select</button>
                        </div>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab1.jpeg" alt="Solid Linen">
                    <div class="fabric-card-content">
                        <h3 class="fabric-name">Solid Linen</h3>
                        <p class="fabric-price">Rs. 950.00 per meter</p>
                        <div class="buttons">
                            <button class="select-btn" onclick="selectFabric(this, 2)">Select</button>
                        </div>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab8.jpeg" alt="Silk">
                    <div class="fabric-card-content">
                        <h3 class="fabric-name">Silk</h3>
                        <p class="fabric-price">Rs. 1,250.00 per meter</p>
                        <div class="buttons">
                            <button class="select-btn" onclick="selectFabric(this, 3)">Select</button>
                        </div>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/fab6.jpeg" alt="Cotton">
                    <div class="fabric-card-content">
                        <h3 class="fabric-name">Cotton</h3>
                        <p class="fabric-price">Rs. 850.00 per meter</p>
                        <div class="buttons">
                            <button class="select-btn" onclick="selectFabric(this, 4)">Select</button>
                        </div>
                    </div>
                </div>
                <div class="fabric-card">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/PİNTEREST.jpeg" alt="Camicia elegante">
                    <div class="fabric-card-content">
                        <h3 class="fabric-name">Camicia elegante</h3>
                        <p class="fabric-price">Rs. 1,150.00 per meter</p>
                        <div class="buttons">
                            <button class="select-btn" onclick="selectFabric(this, 5)">Select</button>
                        </div>
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
    let selectedFabricId = null;

    function selectFabric(btnElement, fabricId) {
        // Remove selected class from all fabric cards
        document.querySelectorAll('.fabric-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to the clicked card
        const selectedCard = btnElement.closest('.fabric-card');
        selectedCard.classList.add('selected');
        selectedFabricId = fabricId;

        // Enable continue button
        document.getElementById('continueBtn').removeAttribute('disabled');
    }

    // Set up continue button
    document.getElementById('continueBtn').addEventListener('click', function() {
        if (selectedFabricId) {
            window.location.href = '<?php echo URLROOT; ?>/Designs/selectColor/' + selectedFabricId;
        }
    });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>