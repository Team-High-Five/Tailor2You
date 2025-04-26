<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
    <form action="<?php echo URLROOT; ?>/designs/saveDesign" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="category_id" value="<?php echo $data['category']->category_id; ?>">
        <input type="hidden" name="subcategory_id" value="<?php echo $data['subcategory']->subcategory_id; ?>">
        <input type="hidden" name="design_name" value="<?php echo $data['design_data']['design_name']; ?>">
        <input type="hidden" name="base_price" value="<?php echo $data['design_data']['base_price']; ?>">

        <!-- Tab Navigation -->
        <div class="design-tabs">
            <button type="button" class="tab-btn active" data-tab="basic-info">Basic Information</button>
            <button type="button" class="tab-btn" data-tab="customizations">Customization Options</button>
            <button type="button" class="tab-btn" data-tab="fabrics">Fabric Selection</button>
            <button type="button" class="tab-btn" data-tab="measurements">Required Measurements</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Basic Information Tab -->
            <div class="tab-pane active" id="basic-info">
                <div class="top-row">
                    <div class="category-section">
                        <h2>Category</h2>
                        <p><?php echo $data['category']->name; ?></p>
                    </div>
                    <div class="subcategory-section">
                        <h2>Sub Category</h2>
                        <p><?php echo $data['subcategory']->name; ?></p>
                    </div>
                </div>

                <div class="photo-section">
                    <div class="photo-container">
                        <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Design Preview" id="design-preview">
                        <input type="file" name="main_image" id="main-image" accept="image/*" required>
                        <p class="change-photo">Upload Design Photo</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" cols="50"></textarea>
                </div>

                <div class="tab-navigation">
                    <button type="button" class="next-tab" data-next="customizations">Next: Customization Options</button>
                </div>
            </div>

            <!-- Customization Options Tab -->
            <div class="tab-pane" id="customizations">
                <h2>Optional Customizations</h2>
                <p class="options-info">You can leave customizations empty or add details for any options you offer.</p>

                <!-- Add this hidden template that will be used by JavaScript -->
                <div id="choice-template" style="display: none;">
                    <div class="choice-item">
                        <div class="choice-image-container">
                            <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Choice Preview" class="choice-preview-img">
                            <input type="file" name="choice_image[TYPE_ID][]" class="choice-image-input" accept="image/*">
                            <div class="required-badge">Required if adding option</div>
                        </div>
                        <input type="text" name="choice_name[TYPE_ID][]" placeholder="Option Name" class="name-input">
                        <input type="number" name="choice_price[TYPE_ID][]" placeholder="Additional Cost (Rs)(Optional)" step="0.01" class="price-input" min="0">
                        <button type="button" class="remove-choice">×</button>
                    </div>
                </div>

                <div class="customization-accordion">
                    <?php foreach ($data['customization_types'] as $type): ?>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h3><?php echo $type->name; ?></h3>
                                <span class="accordion-toggle">+</span>
                            </div>
                            <div class="accordion-content">
                                <div class="customization-choices" data-type="<?php echo $type->type_id; ?>">
                                    <!-- Empty div to start with no options -->
                                </div>
                                <button type="button" class="add-choice" data-type="<?php echo $type->type_id; ?>">+ Add Option</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="tab-navigation">
                    <button type="button" class="prev-tab" data-prev="basic-info">Previous: Basic Information</button>
                    <button type="button" class="next-tab" data-next="fabrics">Next: Fabric Selection</button>
                </div>
            </div>

            <!-- Fabrics Tab -->
            <div class="tab-pane" id="fabrics">
                <h2>Available Fabrics</h2>
                <p>Select the fabrics that can be used with this design.</p>

                <div class="fabric-selection">
                    <?php if (!empty($data['fabrics'])): ?>
                        <?php foreach ($data['fabrics'] as $fabric): ?>
                            <div class="fabric-item">
                                <input type="checkbox" name="fabrics[]" value="<?php echo $fabric->fabric_id; ?>" id="fabric_<?php echo $fabric->fabric_id; ?>">
                                <?php
                                if (isset($fabric->image) && !empty($fabric->image)) {
                                    $imgSrc = 'data:image/jpeg;base64,' . base64_encode($fabric->image);
                                } else {
                                    $imgSrc = URLROOT . '/public/img/placeholder-fabric.png';
                                }
                                ?>
                                <img src="<?php echo $imgSrc; ?>" alt="<?php echo $fabric->fabric_name; ?>" class="fabric-image">
                                <label for="fabric_<?php echo $fabric->fabric_id; ?>"><?php echo $fabric->fabric_name ?? 'Unnamed Fabric'; ?></label>
                                <input type="number" name="fabric_price[<?php echo $fabric->fabric_id; ?>]" placeholder="Additional Cost (Rs)" step="10" class="fabric-price" min="0">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-fabrics">
                            <p>No fabrics available. <a href="<?php echo URLROOT; ?>/Tailors/addNewFabric">Add fabric</a> first.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-navigation">
                    <button type="button" class="prev-tab" data-prev="customizations">Previous: Customization Options</button>
                    <button type="button" class="next-tab" data-next="measurements">Next: Required Measurements</button>
                </div>
            </div>

            <!-- Measurements Tab -->
            <div class="tab-pane" id="measurements">
                <h2>Required Measurements</h2>
                <p class="measurements-info">Select which measurements you need for this design. These will be requested from customers during ordering.</p>

                <?php if (isset($data['category_measurements']) && !empty($data['category_measurements'])): ?>
                    <div class="measurement-categories">
                        <div class="measurement-category">
                            <h3><?php echo $data['category']->name; ?> Measurements</h3>

                            <div class="measurement-grid">
                                <?php foreach ($data['category_measurements'] as $measurement): ?>
                                    <div class="measurement-item">
                                        <div class="measurement-checkbox">
                                            <input type="checkbox"
                                                name="measurements[]"
                                                value="<?php echo $measurement->measurement_id; ?>"
                                                id="meas_<?php echo $measurement->measurement_id; ?>"
                                                <?php echo $measurement->is_required ? 'checked' : ''; ?>>
                                            <label for="meas_<?php echo $measurement->measurement_id; ?>">
                                                <?php echo $measurement->display_name; ?>
                                            </label>
                                        </div>
                                        <div class="measurement-details">
                                            <div class="measurement-description">
                                                <?php echo $measurement->description; ?>
                                            </div>
                                            <div class="measurement-required">
                                                <select name="measurement_required[<?php echo $measurement->measurement_id; ?>]">
                                                    <option value="1" selected>Required</option>
                                                    <option value="0">Optional</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-measurements">
                        <p>No standard measurements defined for this category.</p>
                    </div>
                <?php endif; ?>

                <div class="custom-measurements">
                    <h3>Custom Measurements</h3>
                    <p>Add any custom measurements you need for this design</p>

                    <div id="custom-measurements-container">
                        <!-- Will be populated by JavaScript -->
                    </div>

                    <button type="button" id="add-custom-measurement" class="add-item-btn">
                        <i class="fas fa-plus-circle"></i> Add Custom Measurement
                    </button>
                </div>

                <div class="tab-navigation">
                    <button type="button" class="prev-tab" data-prev="fabrics">Previous: Fabric Selection</button>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button type="submit" class="submit-btn">Save Design</button>
            <a href="<?php echo URLROOT; ?>/tailors/displayCustomizeItems"><button type="button" class="exit-btn">Cancel</button></a>
        </div>
    </form>
</div>

<!-- Add Tab Navigation JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        const nextButtons = document.querySelectorAll('.next-tab');
        const prevButtons = document.querySelectorAll('.prev-tab');

        // Tab button click handler
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');

                // Update active tab button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Show selected tab content
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    if (pane.id === tabId) {
                        pane.classList.add('active');
                    }
                });
            });
        });

        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const nextTabId = this.getAttribute('data-next');

                // Find and click the corresponding tab button
                const targetTabButton = document.querySelector(`.tab-btn[data-tab="${nextTabId}"]`);
                if (targetTabButton) {
                    targetTabButton.click();
                }
            });
        });

        // Previous button click handler
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                const prevTabId = this.getAttribute('data-prev');

                // Find and click the corresponding tab button
                const targetTabButton = document.querySelector(`.tab-btn[data-tab="${prevTabId}"]`);
                if (targetTabButton) {
                    targetTabButton.click();
                }
            });
        });

        // Accordion functionality for customization options
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const toggle = this.querySelector('.accordion-toggle');

                // Toggle display
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    toggle.textContent = '+';
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    toggle.textContent = '−';
                }
            });
        });
    });
</script>

<!-- Include existing design customization JS -->
<script src="<?php echo URLROOT; ?>/public/js/tailor/design-customization.js"></script>

<!-- Include measurement JS -->
<script src="<?php echo URLROOT; ?>/public/js/tailor/design-measurements.js"></script>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>