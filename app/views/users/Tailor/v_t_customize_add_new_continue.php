<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
    <form action="<?php echo URLROOT; ?>/designs/saveDesign" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="category_id" value="<?php echo $data['category']->category_id; ?>">
        <input type="hidden" name="subcategory_id" value="<?php echo $data['subcategory']->subcategory_id; ?>">
        <input type="hidden" name="design_name" value="<?php echo $data['design_data']['design_name']; ?>">
        <input type="hidden" name="base_price" value="<?php echo $data['design_data']['base_price']; ?>">
        <div class="design-tabs">
            <button type="button" class="tab-btn active" data-tab="basic-info">Basic Information</button>
            <button type="button" class="tab-btn" data-tab="customizations">Customization Options</button>
            <button type="button" class="tab-btn" data-tab="fabrics">Fabric Selection</button>
            <button type="button" class="tab-btn" data-tab="measurements">Required Measurements</button>
        </div>
        <div class="tab-content">
      
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
            <div class="tab-pane" id="customizations">
                <h2>Optional Customizations</h2>
                <p class="options-info">You can leave customizations empty or add details for any options you offer.</p>
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
<style>
    .exit-btn {
        background-color:transparent;
        color: var(--text-color);
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.3s ease, color 0.3s ease;
        margin-top: 20px;
    }
    .exit-btn:hover {
        background-color:var(--glass-color);
        color:var(--text-mute);


    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        const nextButtons = document.querySelectorAll('.next-tab');
        const prevButtons = document.querySelectorAll('.prev-tab');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');

                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    if (pane.id === tabId) {
                        pane.classList.add('active');
                    }
                });
            });
        });
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
    // Real-time price validation
    document.addEventListener('DOMContentLoaded', function() {
        // Get all price input fields (both customization options and fabric prices)
        const priceInputs = document.querySelectorAll('.price-input, .fabric-price');

        // Add validation to each price input
        priceInputs.forEach(input => {
            // Create validation message element
            const validationMsg = document.createElement('div');
            validationMsg.className = 'price-validation-message';
            input.parentNode.appendChild(validationMsg);

            // Add event listeners for real-time validation
            input.addEventListener('input', validatePrice);
            input.addEventListener('blur', validatePrice);

            // Initial validation state
            input.dataset.valid = 'true';
        });

        // Validate price function
        function validatePrice(e) {
            const input = e.target;
            const value = input.value.trim();
            const validationMsg = input.parentNode.querySelector('.price-validation-message');

            // Reset validation state
            validationMsg.textContent = '';
            validationMsg.classList.remove('error', 'warning');
            input.classList.remove('price-error', 'price-warning');
            input.dataset.valid = 'true';

            // Skip validation if field is empty (assuming it's optional)
            if (value === '') {
                return;
            }

            // Check if it's a valid number
            if (isNaN(parseFloat(value)) || !isFinite(value)) {
                showError(input, validationMsg, 'Please enter a valid number');
                return;
            }

            // Check for negative numbers
            if (parseFloat(value) < 0) {
                showError(input, validationMsg, 'Price cannot be negative');
                return;
            }

            // Check decimal places (max 2 decimal places)
            const decimalParts = value.split('.');
            if (decimalParts.length > 1 && decimalParts[1].length > 2) {
                showWarning(input, validationMsg, 'Maximum 2 decimal places allowed');
                return;
            }

            // Additional check for unrealistic high values (optional)
            if (parseFloat(value) > 100000) {
                showWarning(input, validationMsg, 'Price seems unusually high');
                return;
            }
        }

        function showError(input, msgElement, message) {
            input.classList.add('price-error');
            msgElement.textContent = message;
            msgElement.classList.add('error');
            input.dataset.valid = 'false';
        }

        function showWarning(input, msgElement, message) {
            input.classList.add('price-warning');
            msgElement.textContent = message;
            msgElement.classList.add('warning');
            input.dataset.valid = 'warning';
        }

        // Validate all prices before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const invalidInputs = document.querySelectorAll('.price-input[data-valid="false"], .fabric-price[data-valid="false"]');

            if (invalidInputs.length > 0) {
                e.preventDefault();
                // Scroll to the first invalid input
                invalidInputs[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                invalidInputs[0].focus();

                // Show form-level error message
                const formError = document.createElement('div');
                formError.className = 'design-flash error';
                formError.innerHTML = `
        <div class="flash-icon"><i class="fas fa-exclamation-circle"></i></div>
        <div class="flash-content">Please fix the price errors before saving.</div>
      `;

                // Insert at the top of the active tab
                const activeTab = document.querySelector('.tab-pane.active');
                activeTab.insertAdjacentElement('afterbegin', formError);

                // Remove the message after 5 seconds
                setTimeout(() => formError.remove(), 5000);
            }
        });
    });

    function attachPriceValidation(container) {
        const newPriceInputs = container.querySelectorAll('.price-input');
        newPriceInputs.forEach(input => {
            if (!input.hasAttribute('data-validation-attached')) {
                // Mark as having validation attached
                input.setAttribute('data-validation-attached', 'true');

                // Create validation message element
                const validationMsg = document.createElement('div');
                validationMsg.className = 'price-validation-message';
                input.parentNode.appendChild(validationMsg);

                // Add event listeners
                input.addEventListener('input', validatePrice);
                input.addEventListener('blur', validatePrice);

                // Initial validation state
                input.dataset.valid = 'true';
            }
        });
    }

    // Call this function after adding new customization options
    document.addEventListener('choiceAdded', function(e) {
        if (e.detail && e.detail.container) {
            attachPriceValidation(e.detail.container);
        }
    });
</script>

<style>
    /* Price validation styles */
    .price-input,
    .fabric-price {
        position: relative;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .price-error {
        border-color: #ff4757 !important;
        box-shadow: 0 0 0 1px rgba(255, 71, 87, 0.5) !important;
        background-color: rgba(255, 71, 87, 0.05) !important;
    }

    .price-warning {
        border-color: #ffa502 !important;
        box-shadow: 0 0 0 1px rgba(255, 165, 2, 0.5) !important;
        background-color: rgba(255, 165, 2, 0.05) !important;
    }

    .price-validation-message {
        position: absolute;
        font-size: 12px;
        margin-top: 4px;
        font-weight: 500;
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: opacity 0.3s ease, max-height 0.3s ease;
        left: 0;
        right: 0;
    }

    .price-validation-message.error,
    .price-validation-message.warning {
        opacity: 1;
        max-height: 40px;
    }

    .price-validation-message.error {
        color: #ff4757;
    }

    .price-validation-message.warning {
        color: #ffa502;
    }

    /* For fabric items, adjust positioning */
    .fabric-item .price-validation-message {
        text-align: center;
    }

    /* Shake animation for invalid inputs when form is submitted */
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-5px);
        }

        40%,
        80% {
            transform: translateX(5px);
        }
    }

    .shake {
        animation: shake 0.5s ease;
    }
</style>
<!-- Include existing design customization JS -->
<script src="<?php echo URLROOT; ?>/public/js/tailor/design-customization.js"></script>

<!-- Include measurement JS -->
<script src="<?php echo URLROOT; ?>/public/js/tailor/design-measurements.js"></script>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>