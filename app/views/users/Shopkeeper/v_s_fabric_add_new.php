<div class="add-new-fabric-container">
  <div class="add-new-fabric-content">
    <div class="modal-header">
      <h1>Add New Fabric</h1>
      <a href="<?php echo URLROOT ?>/Shopkeepers/displayFabricStock"><button class="close-btn">&times;</button></a>
    </div>
    <div class="fabric-form-container">
      <form id="addFabricForm" action="<?php echo URLROOT; ?>/Shopkeepers/addNewFabric" method="post" enctype="multipart/form-data">

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

<script>
  document.getElementById('post-preview').addEventListener('click', function() {
    document.getElementById('upload-photo').click();
  });

  document.getElementById('upload-photo').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function() {
      const output = document.getElementById('post-preview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  });

  document.getElementById('addFabricForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Validate fabric name
    const fabricName = document.getElementById('fabric-name').value;
    if (fabricName.trim() === '') {
      document.getElementById('fabric-name-error').textContent = 'Please enter fabric name';
      isValid = false;
    } else {
      document.getElementById('fabric-name-error').textContent = '';
    }

    // Validate price
    const price = document.getElementById('price').value;
    if (price.trim() === '' || isNaN(price) || parseFloat(price) < 0) {
      document.getElementById('price-error').textContent = 'Please enter a valid price';
      isValid = false;
    } else {
      document.getElementById('price-error').textContent = '';
    }

    // Validate stock
    const stock = document.getElementById('stock').value;
    if (stock.trim() === '' || isNaN(stock) || parseFloat(stock) < 0) {
      document.getElementById('stock-error').textContent = 'Stock cannot be negative';
      isValid = false;
    } else {
      document.getElementById('stock-error').textContent = '';
    }

    // Validate colors
    const colors = document.querySelectorAll('input[name="colors[]"]:checked');
    if (colors.length === 0) {
      document.getElementById('color-error').textContent = 'Please select at least one color';
      isValid = false;
    } else {
      document.getElementById('color-error').textContent = '';
    }

    // Validate image size
    const imageInput = document.getElementById('upload-photo');
    if (imageInput.files.length > 0) {
      const imageFile = imageInput.files[0];
      if (imageFile.size > 1048576) { // 1MB = 1048576 bytes
        document.getElementById('image-error').textContent = 'Image size cannot exceed 1MB';
        isValid = false;
      } else {
        document.getElementById('image-error').textContent = '';
      }
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
</script>