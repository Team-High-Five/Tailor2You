<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
    <div class="design-details-container">
        <div class="customization-content">
            <div class="customization-header">
                <span>Customize Your Design</span>
                <p>Select your preferred style elements to create your perfect garment</p>
            </div>

            <!-- Form to submit customization choices -->
            <form action="<?php echo URLROOT; ?>/Orders/processCustomizations" method="post">

                <?php if (!empty($data['customizations'])): ?>
                    <div class="customization-categories">
                        <?php foreach ($data['customizations'] as $typeId => $customization): ?>
                            <!-- Customization Type Section -->
                            <div class="customization-category">
                                <h2><?php echo $customization['type']->name; ?></h2>
                                <?php if (!empty($customization['type']->description)): ?>
                                    <p class="type-description"><?php echo $customization['type']->description; ?></p>
                                <?php endif; ?>

                                <div class="customization-options <?php echo strtolower(str_replace(' ', '-', $customization['type']->name)) . '-options'; ?>">
                                    <?php foreach ($customization['choices'] as $index => $choice): ?>
                                        <div class="option-card <?php echo $index === 0 ? 'selected' : ''; ?>"
                                            data-choice-id="<?php echo $choice->choice_id; ?>"
                                            onclick="selectOption(this, '<?php echo $typeId; ?>', <?php echo $choice->choice_id; ?>)">

                                            <?php if (!empty($choice->image)): ?>
                                                <div class="option-image">
                                                    <img src="<?php echo URLROOT; ?>/public/img/uploads/customizations/<?php echo $choice->image; ?>"
                                                        alt="<?php echo $choice->name; ?>">
                                                </div>
                                            <?php elseif (strpos(strtolower($customization['type']->name), 'button') !== false): ?>
                                                <!-- For button types with no image, show a circle -->
                                                <div class="option-circle" style="background-color: <?php echo !empty($choice->description) ? $choice->description : '#ccc'; ?>"></div>
                                            <?php endif; ?>

                                            <div class="option-details">
                                                <h3><?php echo $choice->name; ?></h3>
                                                <?php if (!empty($choice->description) && strpos(strtolower($customization['type']->name), 'button') === false): ?>
                                                    <p><?php echo $choice->description; ?></p>
                                                <?php endif; ?>

                                                <?php if ($choice->price_adjustment != 0): ?>
                                                    <p class="price-adjustment <?php echo $choice->price_adjustment > 0 ? 'price-increase' : 'price-decrease'; ?>">
                                                        <?php echo $choice->price_adjustment > 0 ? '+' : ''; ?>Rs. <?php echo number_format($choice->price_adjustment, 2); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Hidden input to store selected option -->
                                <input type="hidden"
                                    name="customization_<?php echo $typeId; ?>"
                                    id="customization_<?php echo $typeId; ?>"
                                    value="<?php echo $customization['choices'][0]->choice_id; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-customizations">
                        <p>No customization options available for this design.</p>
                    </div>
                <?php endif; ?>

                <div class="button-group">
                    <a href="<?php echo URLROOT; ?>/Orders/selectColor" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="continue-btn">Continue <i class="fas fa-arrow-right"></i></button>
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
    function selectOption(element, typeId, choiceId) {
        // Remove selected class from siblings
        const siblings = element.parentElement.querySelectorAll('.option-card');
        siblings.forEach(sibling => {
            sibling.classList.remove('selected');
        });

        // Add selected class to clicked card
        element.classList.add('selected');

        // Update hidden input with selected choice ID
        document.getElementById('customization_' + typeId).value = choiceId;
    }

    // Pre-select any saved customizations when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // This would load any previously selected customizations from session
        // You'll need to pass this data to the view if implementing this feature
    });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>