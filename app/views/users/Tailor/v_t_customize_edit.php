<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/tailor/customize_edit_styles.css">
<div class="main-content">
    <div class="customize-form-container">
        <div class="form-header">
            <h1>Edit Design</h1>
            <a href="<?php echo URLROOT; ?>/tailors/displayCustomizeItems" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Designs
            </a>
        </div>

        <?php if (!empty($data['errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($data['errors'] as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo URLROOT; ?>/designs/editDesign/<?php echo $data['design']->design_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-section">
                <h2>Basic Details</h2>

                <!-- Gender Selection -->
                <div class="form-group">
                    <label>Gender</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" name="gender" value="gents" id="gender-gents" <?php echo ($data['design']->gender == 'gents') ? 'checked' : ''; ?>>
                            <label for="gender-gents">Men's</label>
                        </div>

                        <div class="radio-item">
                            <input type="radio" name="gender" value="ladies" id="gender-ladies" <?php echo ($data['design']->gender == 'ladies') ? 'checked' : ''; ?>>
                            <label for="gender-ladies">Women's</label>
                        </div>

                        <div class="radio-item">
                            <input type="radio" name="gender" value="unisex" id="gender-unisex" <?php echo ($data['design']->gender == 'unisex') ? 'checked' : ''; ?>>
                            <label for="gender-unisex">Unisex</label>
                        </div>
                    </div>
                </div>

                <!-- Category Selection -->
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($data['categories'] as $category): ?>
                            <option value="<?php echo $category->category_id; ?>"
                                data-gender="<?php echo $category->gender_specific; ?>"
                                <?php echo ($data['design']->category_id == $category->category_id) ? 'selected' : ''; ?>>
                                <?php echo $category->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Subcategory Selection -->
                <div class="form-group">
                    <label for="sub-category">Sub Category</label>
                    <select id="sub-category" name="subcategory_id">
                        <option value="">Select Sub Category</option>
                        <?php foreach ($data['subcategories'] as $subcategory): ?>
                            <option value="<?php echo $subcategory->subcategory_id; ?>"
                                <?php echo ($data['design']->subcategory_id == $subcategory->subcategory_id) ? 'selected' : ''; ?>>
                                <?php echo $subcategory->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Design Name -->
                <div class="form-group">
                    <label for="design_name">Design Name</label>
                    <input type="text" id="design_name" name="design_name" value="<?php echo $data['design']->name; ?>" required>
                </div>

                <!-- Design Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo $data['design']->description; ?></textarea>
                </div>

                <!-- Base Price -->
                <div class="form-group">
                    <label for="base_price">Base Price (Rs)</label>
                    <input type="number" id="base_price" name="base_price" min="0" step="0.01" value="<?php echo $data['design']->base_price; ?>" required>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" name="status" value="active" id="status-active" <?php echo ($data['design']->status == 'active') ? 'checked' : ''; ?>>
                            <label for="status-active">Active</label>
                        </div>

                        <div class="radio-item">
                            <input type="radio" name="status" value="inactive" id="status-inactive" <?php echo ($data['design']->status == 'inactive') ? 'checked' : ''; ?>>
                            <label for="status-inactive">Inactive</label>
                        </div>
                    </div>
                </div>

                <!-- Current Main Image -->
                <div class="form-group">
                    <label>Current Image</label>
                    <div class="current-image-container">
                        <?php if (!empty($data['design']->main_image)): ?>
                            <div class="current-image">
                                <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $data['design']->main_image; ?>" alt="Design Image">
                            </div>
                        <?php else: ?>
                            <p>No image available</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Upload New Main Image -->
                <div class="form-group file-upload">
                    <label for="main_image">Upload New Image (optional)</label>
                    <input type="file" id="main_image" name="main_image" accept="image/*">
                    <div class="file-info">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Choose a file or drag it here</span>
                        <p class="file-name"></p>
                    </div>
                    <small class="file-hint">Leave blank to keep current image. Recommended size: 800x600px</small>
                </div>
            </div>

            <!-- Customization Options Section -->
            <div class="form-section">
                <h2>Customization Options</h2>
                <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <button type="button" id="debug-images" class="debug-btn">Debug Image Paths</button>
                    <div id="debug-output" style="display: none;" class="debug-output"></div>
                <?php endif; ?>
                <?php if (!empty($data['customization_types'])): ?>
                    <?php foreach ($data['customization_types'] as $type): ?>
                        <div class="customization-type">
                            <h3><?php echo $type->name; ?></h3>

                            <!-- Existing Options -->
                            <?php
                            $existingChoices = array_filter($data['design_choices'] ?? [], function ($choice) use ($type) {
                                return $choice->type_id == $type->type_id;
                            });
                            ?>

                            <!-- Existing Options Section - Replace the current code with this improved version -->
                            <?php if (!empty($existingChoices)): ?>
                                <div class="existing-choices">
                                    <h4>Current Options</h4>
                                    <div class="choices-grid">
                                        <?php foreach ($existingChoices as $choice): ?>
                                            <div class="choice-item">
                                                <input type="checkbox" name="existing_choices[]" value="<?php echo $choice->choice_id; ?>" id="choice_<?php echo $choice->choice_id; ?>" checked>
                                                <label for="choice_<?php echo $choice->choice_id; ?>" class="choice-card">
                                                    <div class="choice-image">
                                                        <?php if (!empty($choice->image)): ?>
                                                            <img src="<?php echo URLROOT; ?>/public/img/uploads/customizations/<?php echo $choice->image; ?>" alt="<?php echo $choice->name; ?>"
                                                                onerror="this.src='<?php echo URLROOT; ?>/public/img/placeholder-image.png'; this.onerror=null;">
                                                        <?php else: ?>
                                                            <div class="no-image">No Image</div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="choice-details">
                                                        <span class="choice-name"><?php echo $choice->name; ?></span>
                                                        <?php if ($choice->price_adjustment > 0): ?>
                                                            <span class="choice-price">+Rs <?php echo number_format($choice->price_adjustment, 2); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Add New Options -->
                            <div class="add-customization">
                                <h4>Add New Options</h4>
                                <div class="customization-options">
                                    <div class="customization-row" data-type-id="<?php echo $type->type_id; ?>">
                                        <div class="option-inputs">
                                            <div class="form-group">
                                                <input type="text" name="choice_name[<?php echo $type->type_id; ?>][]" placeholder="Option name">
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="choice_price[<?php echo $type->type_id; ?>][]" placeholder="Additional price" min="0" step="0.01">
                                            </div>
                                            <div class="form-group file-upload">
                                                <label class="file-label">
                                                    <input type="file" name="choice_image[<?php echo $type->type_id; ?>][]" accept="image/*">
                                                    <span>Choose Image</span>
                                                </label>
                                            </div>
                                        </div>
                                        <button type="button" class="add-more-btn" data-type="<?php echo $type->type_id; ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-customizations">No customization types available for this category</p>
                <?php endif; ?>
            </div>

            <!-- Fabrics Section -->
            <div class="form-section">
                <h2>Available Fabrics</h2>

                <?php if (!empty($data['fabrics'])): ?>
                    <div class="fabrics-container">
                        <?php
                        // Get an array of selected fabric IDs for easy checking
                        $selectedFabricIds = array_map(function ($item) {
                            return $item->fabric_id;
                        }, $data['design_fabrics'] ?? []);

                        // Get fabric prices map
                        $fabricPriceMap = [];
                        foreach ($data['design_fabrics'] ?? [] as $designFabric) {
                            $fabricPriceMap[$designFabric->fabric_id] = $designFabric->price_adjustment;
                        }
                        ?>

                        <?php foreach ($data['fabrics'] as $fabric): ?>
                            <div class="fabric-item">
                                <input type="checkbox" name="fabrics[]" value="<?php echo $fabric->fabric_id; ?>" id="fabric_<?php echo $fabric->fabric_id; ?>"
                                    <?php echo in_array($fabric->fabric_id, $selectedFabricIds) ? 'checked' : ''; ?>>
                                <label for="fabric_<?php echo $fabric->fabric_id; ?>" class="fabric-card">
                                    <div class="fabric-image">
                                        <?php if (!empty($fabric->image)): ?>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($fabric->image); ?>" alt="<?php echo $fabric->fabric_name; ?>">
                                        <?php else: ?>
                                            <div class="no-image">No Image</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fabric-details">
                                        <span class="fabric-name"><?php echo $fabric->fabric_name; ?></span>
                                        <span class="fabric-price">Rs <?php echo number_format($fabric->price_per_meter, 2); ?>/m</span>
                                        <div class="fabric-price-adjustment">
                                            <label for="fabric_price_<?php echo $fabric->fabric_id; ?>">Additional charge:</label>
                                            <input type="number" name="fabric_price[<?php echo $fabric->fabric_id; ?>]" id="fabric_price_<?php echo $fabric->fabric_id; ?>" value="<?php echo isset($fabricPriceMap[$fabric->fabric_id]) ? $fabricPriceMap[$fabric->fabric_id] : '0'; ?>" min="0" step="0.01">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-fabrics">No fabrics available. <a href="<?php echo URLROOT; ?>/fabrics/add">Add fabrics</a> first.</p>
                <?php endif; ?>
            </div>
            <!-- Submit Button -->
            <div class="form-actions">
                <a href="<?php echo URLROOT; ?>/tailors/displayCustomizeItems" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const subCategorySelect = document.getElementById('sub-category');
        const genderInputs = document.querySelectorAll('input[name="gender"]');
        const fileInput = document.getElementById('main_image');
        const fileInfo = document.querySelector('.file-info');
        const fileName = document.querySelector('.file-name');

        // Filter categories based on gender selection
        function filterCategories() {
            const selectedGender = document.querySelector('input[name="gender"]:checked').value;

            Array.from(categorySelect.options).forEach(option => {
                if (option.value === '') return; // Skip the placeholder option

                const optionGender = option.getAttribute('data-gender');
                if (optionGender === selectedGender || optionGender === 'unisex') {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';

                    // If the hidden option is currently selected, reset the selection
                    if (option.selected) {
                        categorySelect.value = '';
                        // Also reset subcategories
                        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                    }
                }
            });
        }

        // Update subcategories when category changes
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;

            if (categoryId) {
                // Load subcategories
                fetch('<?php echo URLROOT; ?>/designs/getSubcategories/' + categoryId)
                    .then(response => response.text())
                    .then(html => {
                        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>' + html;
                    })
                    .catch(error => {
                        console.error('Error loading subcategories:', error);
                        subCategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
                    });
            } else {
                subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            }
        });

        // File input styling
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileInfo.classList.add('has-file');
            } else {
                fileName.textContent = '';
                fileInfo.classList.remove('has-file');
            }
        });

        // Drag and drop functionality
        fileInfo.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileInfo.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });

        fileInfo.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');

            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                fileName.textContent = e.dataTransfer.files[0].name;
                fileInfo.classList.add('has-file');
            }
        });

        fileInfo.addEventListener('click', function() {
            fileInput.click();
        });

        // Apply gender filter when gender selection changes
        genderInputs.forEach(input => {
            input.addEventListener('change', filterCategories);
        });

        // Apply initial filter
        filterCategories();
    });
    // Add to existing script at the bottom
    // Handle adding more customization options
    document.querySelectorAll('.add-more-btn').forEach(button => {
        button.addEventListener('click', function() {
            const typeId = this.getAttribute('data-type');
            const rowTemplate = `
            <div class="customization-row" data-type-id="${typeId}">
                <div class="option-inputs">
                    <div class="form-group">
                        <input type="text" name="choice_name[${typeId}][]" placeholder="Option name">
                    </div>
                    <div class="form-group">
                        <input type="number" name="choice_price[${typeId}][]" placeholder="Additional price" min="0" step="0.01">
                    </div>
                    <div class="form-group file-upload">
                        <label class="file-label">
                            <input type="file" name="choice_image[${typeId}][]" accept="image/*">
                            <span>Choose Image</span>
                        </label>
                    </div>
                </div>
                <button type="button" class="remove-row-btn">×</button>
            </div>
        `;

            // Find the container for this type
            const container = this.closest('.customization-options');

            // Create a temporary div to hold the HTML
            const temp = document.createElement('div');
            temp.innerHTML = rowTemplate;

            // Append the new row
            container.appendChild(temp.firstElementChild);

            // Add event listener to the new remove button
            container.querySelector('.customization-row:last-child .remove-row-btn')
                .addEventListener('click', function() {
                    this.closest('.customization-row').remove();
                });
        });
    });

    // Handle file inputs for custom styling
    document.addEventListener('change', function(e) {
        if (e.target && e.target.type === 'file' && e.target.closest('.file-label')) {
            const fileLabel = e.target.closest('.file-label');
            if (e.target.files.length > 0) {
                fileLabel.querySelector('span').textContent = e.target.files[0].name;
                fileLabel.classList.add('has-file');
            } else {
                fileLabel.querySelector('span').textContent = 'Choose Image';
                fileLabel.classList.remove('has-file');
            }
        }
    });
    if (document.getElementById('debug-images')) {
        document.getElementById('debug-images').addEventListener('click', function() {
            const debugOutput = document.getElementById('debug-output');
            const imageElements = document.querySelectorAll('.choice-image img');

            let debugHTML = '<h4>Image Path Information:</h4><ul>';

            imageElements.forEach((img, index) => {
                const src = img.getAttribute('src');
                const alt = img.getAttribute('alt');
                const status = img.complete && img.naturalHeight !== 0 ? 'Loaded' : 'Failed to load';

                debugHTML += `<li>Image ${index + 1} (${alt}):<br>
                         Path: ${src}<br>
                         Status: <span class="${status === 'Loaded' ? 'success' : 'error'}">${status}</span></li>`;
            });

            debugHTML += '</ul>';
            debugOutput.innerHTML = debugHTML;
            debugOutput.style.display = debugOutput.style.display === 'none' ? 'block' : 'none';
        });
    }
</script>

<!-- Add this CSS section -->


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>