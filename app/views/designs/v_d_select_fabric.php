<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
    <div class="design-details-container">
        <div class="fabric-form">
            <div class="fabric-header">
                <span>Select a Fabric</span>
            </div>
            <form action="<?php echo URLROOT; ?>/Orders/processSelection" method="post">
                <input type="hidden" name="selection_type" value="fabric">
                <input type="hidden" name="selected_fabric_id" id="selected_fabric_id" value="<?php echo isset($_SESSION['order_details']['fabric']) ? $_SESSION['order_details']['fabric']->fabric_id : ''; ?>">

                <section class="fabric-grid">
                    <?php if (!empty($data['fabrics'])): ?>
                        <?php foreach ($data['fabrics'] as $fabric): ?>
                            <div class="fabric-card <?php echo (isset($_SESSION['order_details']['fabric']) && $_SESSION['order_details']['fabric']->fabric_id == $fabric->fabric_id) ? 'selected' : ''; ?>"
                                data-fabric-id="<?php echo $fabric->fabric_id; ?>"
                                onclick="selectFabric(this, <?php echo $fabric->fabric_id; ?>)">
                                <img src="<?php echo !empty($fabric->image) ? 'data:image/jpeg;base64,' . base64_encode($fabric->image) : URLROOT . '/public/img/designs/fabric-placeholder.jpg'; ?>" alt="<?php echo $fabric->fabric_name; ?>">

                                <div class="fabric-card-content">
                                    <h3 class="fabric-name"><?php echo $fabric->fabric_name; ?></h3>
                                    <p class="fabric-price">Rs. <?php echo number_format($fabric->price_per_meter, 2); ?> per meter</p>

                                    <?php if (isset($fabric->price_adjustment) && $fabric->price_adjustment != 0): ?>
                                        <p class="fabric-price-impact <?php echo $fabric->price_adjustment > 0 ? 'price-increase' : 'price-decrease'; ?>">
                                            <?php echo $fabric->price_adjustment > 0 ? '+' : ''; ?>Rs. <?php echo number_format($fabric->price_adjustment, 2); ?> to base price
                                        </p>
                                    <?php endif; ?>

                                    <p class="fabric-desc"><?php echo $fabric->description ?? ''; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <p>Something wrong.</p>
                        </div>
                    <?php endif; ?>
                </section>

                <div class="button-group">
                    <button type="submit" class="continue-btn" id="continueBtn" <?php echo empty($data['fabrics']) || !isset($_SESSION['order_details']['fabric']) ? 'disabled' : ''; ?>>
                        Continue <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="design-image-container">
        <div class="design-image-wrapper">
            <?php if (isset($_SESSION['order_details']['design']) && !empty($_SESSION['order_details']['design']->main_image)) : ?>
                <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $_SESSION['order_details']['design']->main_image; ?>"
                    alt="<?php echo $_SESSION['order_details']['design']->name; ?>"
                    onerror="this.src='<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg'">
            <?php else : ?>
                <img src="<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg" alt="Design Image">
            <?php endif; ?>
        </div>

        <div class="design-details">
            <?php if (isset($_SESSION['order_details']['design'])): ?>
                <div class="design-name">
                    <span><?php echo $_SESSION['order_details']['design']->name; ?></span>
                </div>
                <div class="design-description">
                    <span><?php echo $_SESSION['order_details']['design']->description; ?></span>
                </div>
            <?php else: ?>
                <div class="design-name">
                    <span>Design Name</span>
                </div>
                <div class="design-description">
                    <span>Design Description</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Add Order Summary Component -->
        <?php require_once APPROOT . '/views/designs/components/order-summary.php'; ?>
    </div>
</div>

<script>
    // This function now just handles the UI changes, no AJAX
    function selectFabric(element, fabricId) {
        // Remove selected class from all fabric cards
        document.querySelectorAll('.fabric-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to the clicked card
        element.classList.add('selected');

        // Update hidden input with selected fabric ID
        document.getElementById('selected_fabric_id').value = fabricId;

        // Enable continue button if it was disabled
        document.getElementById('continueBtn').removeAttribute('disabled');
    }

    // Pre-select the fabric on page load if one was previously selected
    window.addEventListener('DOMContentLoaded', function() {
        const selectedFabricId = document.getElementById('selected_fabric_id').value;
        if (selectedFabricId) {
            const selectedCard = document.querySelector(`.fabric-card[data-fabric-id="${selectedFabricId}"]`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
                document.getElementById('continueBtn').removeAttribute('disabled');
            }
        }
    });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>