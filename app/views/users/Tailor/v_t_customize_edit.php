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
                <?php if (!empty($data['customization_types'])): ?>
                    <?php foreach ($data['customization_types'] as $type): ?>
                        <div class="customization-type">
                            <h3><?php echo $type->name; ?></h3>
                            <?php
                            $existingChoices = array_filter($data['design_choices'] ?? [], function ($choice) use ($type) {
                                return $choice->type_id == $type->type_id;
                            });
                            ?>

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
                        $selectedFabricIds = array_map(function ($item) {
                            return $item->fabric_id;
                        }, $data['design_fabrics'] ?? []);
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
            <!-- Measurements Section -->
            <div class="form-section">
                <h2>Required Measurements</h2>
                <p class="measurements-info">Select which measurements you need for this design. These will be requested from customers during ordering.</p>

                <?php if (isset($data['category_measurements']) && !empty($data['category_measurements'])): ?>
                    <div class="measurement-categories">
                        <div class="measurement-category">
                            <h3><?php echo $data['design']->category_name ?? $data['design']->category_id; ?> Measurements</h3>

                            <div class="measurement-grid">
                                <?php foreach ($data['category_measurements'] as $measurement): ?>
                                    <?php
                                    $isSelected = in_array($measurement->measurement_id, $data['selected_measurement_ids'] ?? []);
                                    $isRequired = isset($data['measurement_required'][$measurement->measurement_id]) ?
                                        $data['measurement_required'][$measurement->measurement_id] : $measurement->is_required;
                                    ?>
                                    <div class="measurement-item">
                                        <div class="measurement-checkbox">
                                            <input type="checkbox"
                                                name="measurements[]"
                                                value="<?php echo $measurement->measurement_id; ?>"
                                                id="meas_<?php echo $measurement->measurement_id; ?>"
                                                <?php echo $isSelected ? 'checked' : ''; ?>>
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
                                                    <option value="1" <?php echo $isRequired ? 'selected' : ''; ?>>Required</option>
                                                    <option value="0" <?php echo !$isRequired ? 'selected' : ''; ?>>Optional</option>
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
                        <?php if (isset($data['custom_measurements']) && !empty($data['custom_measurements'])): ?>
                            <?php foreach ($data['custom_measurements'] as $index => $measurement): ?>
                                <div class="custom-measurement-item" data-id="<?php echo $index + 1; ?>">
                                    <div class="custom-measurement-header">
                                        <h4>Custom Measurement #<?php echo $index + 1; ?></h4>
                                        <button type="button" class="remove-measurement">×</button>
                                    </div>
                                    <div class="custom-measurement-form">
                                        <input type="hidden" name="custom_measurement_id[]" value="<?php echo $measurement->id; ?>">
                                        <div class="form-group">
                                            <label for="custom_name_<?php echo $index + 1; ?>">Measurement Name*</label>
                                            <input type="text" id="custom_name_<?php echo $index + 1; ?>" name="custom_name[]" class="form-control" value="<?php echo $measurement->name; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_display_name_<?php echo $index + 1; ?>">Display Name*</label>
                                            <input type="text" id="custom_display_name_<?php echo $index + 1; ?>" name="custom_display_name[]" class="form-control" value="<?php echo $measurement->display_name; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_description_<?php echo $index + 1; ?>">Description</label>
                                            <textarea id="custom_description_<?php echo $index + 1; ?>" name="custom_description[]" class="form-control" rows="2"><?php echo $measurement->description; ?></textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group half-width">
                                                <label for="custom_unit_type_<?php echo $index + 1; ?>">Measurement Type*</label>
                                                <select id="custom_unit_type_<?php echo $index + 1; ?>" name="custom_unit_type[]" class="form-control" required>
                                                    <option value="length" <?php echo $measurement->unit_type == 'length' ? 'selected' : ''; ?>>Length</option>
                                                    <option value="circumference" <?php echo $measurement->unit_type == 'circumference' ? 'selected' : ''; ?>>Circumference</option>
                                                    <option value="angle" <?php echo $measurement->unit_type == 'angle' ? 'selected' : ''; ?>>Angle</option>
                                                    <option value="other" <?php echo $measurement->unit_type == 'other' ? 'selected' : ''; ?>>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group half-width">
                                                <label for="custom_required_<?php echo $index + 1; ?>">Required?</label>
                                                <select id="custom_required_<?php echo $index + 1; ?>" name="custom_required[]" class="form-control">
                                                    <option value="1" <?php echo $measurement->is_required ? 'selected' : ''; ?>>Required</option>
                                                    <option value="0" <?php echo !$measurement->is_required ? 'selected' : ''; ?>>Optional</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button type="button" id="add-custom-measurement" class="add-item-btn">
                        <i class="fas fa-plus-circle"></i> Add Custom Measurement
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?php echo URLROOT; ?>/tailors/displayCustomizeItems" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<script>
let customMeasurementCount = <?php echo isset($data['custom_measurements']) ? count($data['custom_measurements']) : 0; ?>;
</script>
<script src="<?php echo URLROOT; ?>/public/js/tailor/design-customization-edit.js"></script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>