<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>

<!-- Link to the external CSS file -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/shopkeeper/edit-post.css">

<div class="edit-post-container">
    <div class="edit-post-content centered-card">
        <div class="modal-header">
            <h1>Edit Post</h1>
            <button class="close-btn">&times;</button>
        </div>
        <div class="post-form-container">
            <form id="editPostForm" action="<?php echo URLROOT; ?>/shopkeepers/editPost/<?php echo $data['post_id']; ?>" method="post" enctype="multipart/form-data">
                <div class="post-pic-wrapper">
                    <?php if (!empty($data['image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['image']); ?>" alt="Post Image" id="post-preview">
                    <?php else: ?>
                        <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Image" id="post-preview">
                    <?php endif; ?>
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo $data['title']; ?>" required>
                    <span class="error-message" id="title-error"></span>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5" required><?php echo $data['description']; ?></textarea>
                    <span class="error-message" id="description-error"></span>
                </div>
                
                <!-- Gender selection -->
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="men" <?php echo (isset($data['gender']) && $data['gender'] == 'men') ? 'selected' : ''; ?>>Men</option>
                        <option value="women" <?php echo (isset($data['gender']) && $data['gender'] == 'women') ? 'selected' : ''; ?>>Women</option>
                        <option value="unisex" <?php echo (isset($data['gender']) && $data['gender'] == 'unisex') ? 'selected' : ''; ?>>Unisex</option>
                    </select>
                    <span class="error-message" id="gender-error"></span>
                </div>
                
                <!-- Item Type selection -->
                <div class="form-group">
                    <label for="item-type">Item Type</label>
                    <select id="item-type" name="item_type" required>
                        <option value="">Select Item Type</option>
                        <option value="shirt" <?php echo (isset($data['item_type']) && $data['item_type'] == 'shirt') ? 'selected' : ''; ?>>Shirt</option>
                        <option value="pant" <?php echo (isset($data['item_type']) && $data['item_type'] == 'pant') ? 'selected' : ''; ?>>Pant</option>
                        <option value="frock" <?php echo (isset($data['item_type']) && $data['item_type'] == 'frock') ? 'selected' : ''; ?>>Frock</option>
                        <option value="skirt" <?php echo (isset($data['item_type']) && $data['item_type'] == 'skirt') ? 'selected' : ''; ?>>Skirt</option>
                        <option value="blouse" <?php echo (isset($data['item_type']) && $data['item_type'] == 'blouse') ? 'selected' : ''; ?>>Blouse</option>
                    </select>
                    <span class="error-message" id="item-type-error"></span>
                </div>
                
                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>
