<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
    <form action="<?php echo URLROOT; ?>/tailors/saveDesign" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="category_id" value="<?php echo $data['category']->category_id; ?>">
        <input type="hidden" name="subcategory_id" value="<?php echo $data['subcategory']->subcategory_id; ?>">
        <input type="hidden" name="design_name" value="<?php echo $data['design_name']; ?>">
        <input type="hidden" name="base_price" value="<?php echo $data['base_price']; ?>">

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

        <div class="option-section">
            <?php foreach ($data['customization_types'] as $type): ?>
                <div class="option-group">
                    <h3><?php echo $type->name; ?></h3>
                    <div class="option-photo">
                        <div class="customization-choices" data-type="<?php echo $type->type_id; ?>">
                            <div class="choice-item">
                                <input type="file" name="choice_image[<?php echo $type->type_id; ?>][]" class="choice-image" accept="image/*">
                                <input type="text" name="choice_name[<?php echo $type->type_id; ?>][]" placeholder="Option Name" class="name-input" required>
                                <input type="number" name="choice_price[<?php echo $type->type_id; ?>][]" placeholder="Additional Cost" step="0.01" class="price-input">
                                <button type="button" class="remove-choice">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-choice" data-type="<?php echo $type->type_id; ?>">+ Add Option</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="fabric-section">
            <h2>Available Fabrics</h2>
            <div class="fabric-selection">
                <?php foreach ($data['fabrics'] as $fabric): ?>
                    <div class="fabric-item">
                        <input type="checkbox" name="fabrics[]" value="<?php echo $fabric->fabric_id; ?>" id="fabric_<?php echo $fabric->fabric_id; ?>">
                        <label for="fabric_<?php echo $fabric->fabric_id; ?>"><?php echo $fabric->name; ?></label>
                        <input type="number" name="fabric_price[<?php echo $fabric->fabric_id; ?>]" placeholder="Additional Cost" step="0.01">
                        <div class="fabric-colors">
                            <?php foreach ($fabric->colors as $color): ?>
                                <span class="color-dot" style="background-color: <?php echo $color->color_code; ?>" title="<?php echo $color->color_name; ?>"></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="action-buttons">
            <button type="submit" class="submit-btn">Save Design</button>
            <a href="<?php echo URLROOT; ?>/tailors/customize" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<script src="<?php echo URLROOT; ?>/js/design-customization.js"></script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>