<div class="post-modal-content">
  <div class="modal-header">
    <h1>Edit Portfolio Item</h1>
    <button class="close-btn">&times;</button>
  </div>

  <div class="modal-content">
    <form id="editPostForm" action="<?php echo URLROOT; ?>/Tailors/updatePost/<?php echo $data['post']->id; ?>" method="post" enctype="multipart/form-data">
      <!-- Image Upload Section -->
      <div class="upload-section">
        <div class="post-pic-wrapper" id="image-upload-area">
          <?php if (!empty($data['post']->image)): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($data['post']->image); ?>" alt="Post Image" id="post-preview" class="has-image">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Image" id="post-preview">
          <?php endif; ?>

          <div class="overlay">
            <i class="ri-camera-line"></i>
            <p>Click to change image</p>
          </div>
        </div>
        <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
        <span class="error-message" id="image-error"></span>
      </div>

      <!-- Form Fields -->
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo $data['post']->title; ?>" required>
        <span class="error-message" id="title-error"></span>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?php echo $data['post']->description; ?></textarea>
        <span class="error-message" id="description-error"></span>
      </div>

      <!-- Two-column layout for select fields -->
      <div class="form-row">
        <!-- Gender selection -->
        <div class="form-group half">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="men" <?php echo ($data['post']->gender === 'men') ? 'selected' : ''; ?>>Men</option>
            <option value="women" <?php echo ($data['post']->gender === 'women') ? 'selected' : ''; ?>>Women</option>
            <option value="unisex" <?php echo ($data['post']->gender === 'unisex') ? 'selected' : ''; ?>>Unisex</option>
          </select>
          <span class="error-message" id="gender-error"></span>
        </div>

        <!-- Item Type selection -->
        <div class="form-group half">
          <label for="item-type">Item Type</label>
          <select id="item-type" name="item_type" required>
            <option value="">Select Item Type</option>
            <option value="shirt" <?php echo ($data['post']->item_type === 'shirt') ? 'selected' : ''; ?>>Shirt</option>
            <option value="pant" <?php echo ($data['post']->item_type === 'pant') ? 'selected' : ''; ?>>Pant</option>
            <option value="frock" <?php echo ($data['post']->item_type === 'frock') ? 'selected' : ''; ?>>Frock</option>
            <option value="skirt" <?php echo ($data['post']->item_type === 'skirt') ? 'selected' : ''; ?>>Skirt</option>
            <option value="blouse" <?php echo ($data['post']->item_type === 'blouse') ? 'selected' : ''; ?>>Blouse</option>
            <option value="suit" <?php echo ($data['post']->item_type === 'suit') ? 'selected' : ''; ?>>Suit</option>
            <option value="other" <?php echo ($data['post']->item_type === 'other') ? 'selected' : ''; ?>>Other</option>
          </select>
          <span class="error-message" id="item-type-error"></span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="button-rows">
        <button type="submit" class="submit-btn">
          <i class="ri-save-line"></i> Save Changes
        </button>
        <button type="button" class="reset-btn" id="cancel-edit">
          <i class="ri-close-line"></i> Cancel
        </button>
      </div>
    </form>
  </div>
</div>