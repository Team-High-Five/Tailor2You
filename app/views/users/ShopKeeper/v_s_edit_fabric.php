<div class="add-new-fabric-container">
  <div class="add-new-fabric-content">
    <div class="modal-header">
      <h1>Edit Fabric</h1>
      <a href="<?php echo URLROOT ?>/Shopkeepers/displayFabricStock"><button class="close-btn">&times;</button></a>
    </div>
    <div class="fabric-form-container">
      <form id="editFabricForm" action="<?php echo URLROOT; ?>/Shopkeepers/editFabric/<?php echo $data['fabric_id']; ?>" method="post" enctype="multipart/form-data">
        <div class="post-pic-wrapper">
          <?php if (empty($data['image'])): ?>
            <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
          <?php else: ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($data['image']); ?>" alt="Fabric Image" id="post-preview">
          <?php endif; ?>
        </div>

        <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
        <span class="error-message" id="image-error"></span>
        <div class="form-group">
          <label for="fabric-name">Fabric Name</label>
          <input type="text" id="fabric-name" name="fabric_name" value="<?php echo $data['fabric_name']; ?>" required>
          <span class="error-message" id="fabric-name-error"></span>
        </div>
        <div class="form-group">
          <label for="price">Price (Rs)</label>
          <input type="text" id="price" name="price" value="<?php echo $data['price']; ?>" required>
          <span class="error-message" id="price-error"></span>
        </div>
        <div class="form-group">
          <label for="color">Color</label>
          <div id="color">
            <?php foreach ($data['colors'] as $color): ?>
              <div class="checkbox-group">
                <input type="checkbox" id="color_<?php echo $color->color_id; ?>" name="colors[]" value="<?php echo $color->color_id; ?>" <?php echo in_array($color->color_name, $data['selected_colors']) ? 'checked' : ''; ?>>
                <label for="color_<?php echo $color->color_id; ?>">
                  <span class="color-swatch" data-color="<?php echo $color->color_name; ?>"></span>
                  <?php echo $color->color_name; ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
          <span class="error-message" id="color-error"></span>
        </div>
        <div class="form-group">
          <label for="stock">Stock (m)</label>
          <input type="text" id="stock" name="stock" value="<?php echo $data['stock']; ?>" required>
          <span class="error-message" id="stock-error"></span>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
  </div>
</div>

<script>

</script>