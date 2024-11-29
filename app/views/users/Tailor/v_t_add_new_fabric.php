<div class="add-new-fabric-container">
  <div class="add-new-fabric-content">
    <div class="modal-header">
      <h1>Add New Fabric</h1>
      <a href="<?php echo URLROOT ?>/Tailors/displayFabricStock"><button class="close-btn">&times;</button></a>
    </div>
    <div class="fabric-form-container">
      <form id="addFabricForm" action="<?php echo URLROOT; ?>/Tailors/addNewFabric" method="post" enctype="multipart/form-data">

        <div class="post-pic-wrapper">
          <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
        </div>
        <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
        <span class="error-message" id="image-error"></span>
        <div class="form-group">
          <label for="fabric-name">Fabric Name</label>
          <input type="text" id="fabric-name" name="fabric_name" placeholder="Enter Fabric name" required>
          <span class="error-message" id="fabric-name-error"></span>
        </div>
        <div class="form-group">
          <label for="price">Price (Rs)</label>
          <input type="text" id="price" name="price" placeholder="Enter Price" required>
          <span class="error-message" id="price-error"></span>
        </div>
        <div class="form-group">
          <label for="color">Color</label>
          <div id="color">
            <?php foreach ($data['colors'] as $color): ?>
              <div class="checkbox-group">
                <input type="checkbox" id="color_<?php echo $color->color_id; ?>" name="colors[]" value="<?php echo $color->color_id; ?>">
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
          <input type="text" id="stock" name="stock" placeholder="Enter Quantity" required>
          <span class="error-message" id="stock-error"></span>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
  </div>
</div>