<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
    <form action="<?php echo URLROOT; ?>/designs/saveDesign" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="category_id" value="<?php echo $data['category']->category_id; ?>">
        <input type="hidden" name="subcategory_id" value="<?php echo $data['subcategory']->subcategory_id; ?>">
        <input type="hidden" name="design_name" value="<?php echo $data['design_data']['design_name']; ?>">
        <input type="hidden" name="base_price" value="<?php echo $data['design_data']['base_price']; ?>">

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

        <div class="option-section">
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
                    <input type="number" name="choice_price[TYPE_ID][]" placeholder="Additional Cost (Rs)(Optional)" step="0.01" class="price-input">
                    <button type="button" class="remove-choice">×</button>
                </div>
            </div>

            <?php foreach ($data['customization_types'] as $type): ?>
                <div class="option-group">
                    <h3><?php echo $type->name; ?></h3>
                    <div class="option-photo">
                        <div class="customization-choices" data-type="<?php echo $type->type_id; ?>">
                            <!-- Empty div to start with no options -->
                        </div>
                        <button type="button" class="add-choice" data-type="<?php echo $type->type_id; ?>">+ Add Option</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="fabric-section">
            <h2>Available Fabrics</h2>
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
        </div>

        <div class="action-buttons">
            <button type="submit" class="submit-btn">Save Design</button>
            <a href="<?php echo URLROOT; ?>/tailors/displayCustomizeItems"><button class="exit-btn" type="No"> Cancel</button></a>
        </div>
    </form>
</div>

<script src="<?php echo URLROOT; ?>/public/js/tailor/design-customization.js"></script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>