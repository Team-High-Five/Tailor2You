<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
    <div class="design-details-container">
        <div class="color-form">
            <div class="color-header">
                <span>Select a Color</span>
            </div>

            <form action="<?php echo URLROOT; ?>/Orders/processSelection" method="post">
                <input type="hidden" name="selection_type" value="color">
                <input type="hidden" name="selected_color_id" id="selected_color_id" value="<?php echo isset($_SESSION['order_details']['color']) ? $_SESSION['order_details']['color']->color_id : ''; ?>">

                <section class="color-grid">
                    <?php if (!empty($data['colors'])): ?>
                        <?php foreach ($data['colors'] as $color): ?>

                            <div class="color-card <?php echo (isset($_SESSION['order_details']['color']) && $_SESSION['order_details']['color']->color_id == $color->color_id) ? 'selected' : ''; ?>"
                                data-color-id="<?php echo $color->color_id; ?>"
                                onclick="selectColor(this, <?php echo $color->color_id; ?>)">

                                <?php if (!empty($color->image)): ?>
                                    <img src="<?php echo !empty($color->image) ? 'data:image/jpeg;base64,' . base64_encode($color->image) : URLROOT . '/public/img/designs/color-placeholder.jpg'; ?>" alt="<?php echo $color->color_name; ?>">
                                <?php else: ?>
                                    <div class="color-swatch"
                                        data-color="<?php echo htmlspecialchars($color->color_name); ?>"
                                        style="<?php echo empty($color->color_code) ? '' : 'background-color: ' . $color->color_code . ';'; ?>">
                                    </div>
                                <?php endif; ?>
                                <!-- Add this content wrapper div like in fabric cards -->
                                <div class="color-card-content">
                                    <h3 class="color-name"><?php echo $color->color_name; ?></h3>
                                    <?php if (!empty($color->color_code)): ?>
                                        <p class="color-code">Color code: <?php echo $color->color_code; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($color->description)): ?>
                                        <p class="color-desc"><?php echo $color->description; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <p>No colors available for this fabric. Please contact the tailor.</p>
                        </div>
                    <?php endif; ?>
                </section>

                <div class="continue-button">
                    <button type="submit" class="continue-btn" id="continueBtn" <?php echo empty($data['colors']) || !isset($_SESSION['order_details']['color']) ? 'disabled' : ''; ?>>Continue</button>
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
    function selectColor(element, colorId) {
        // Remove selected class from all color cards
        document.querySelectorAll('.color-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to the clicked card
        element.classList.add('selected');

        // Update hidden input with selected color ID
        document.getElementById('selected_color_id').value = colorId;

        // Enable continue button if it was disabled
        document.getElementById('continueBtn').removeAttribute('disabled');
    }

    // Pre-select the color on page load if one was previously selected
    window.addEventListener('DOMContentLoaded', function() {
        const selectedColorId = document.getElementById('selected_color_id').value;
        if (selectedColorId) {
            const selectedCard = document.querySelector(`.color-card[data-color-id="${selectedColorId}"]`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
                document.getElementById('continueBtn').removeAttribute('disabled');
            }
        }
    });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>