<div class="add-new-fabric-container">
  
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
          <label for="color">Color <small>(scroll to see all options)</small></label>
          <div class="color-scroll-container">
            <div class="checkbox-group" id="color">
              <?php foreach ($data['colors'] as $color): ?>
                <div>
                  <input type="checkbox" id="color_<?php echo $color->color_id; ?>" name="colors[]" value="<?php echo $color->color_id; ?>">
                  <label for="color_<?php echo $color->color_id; ?>">
                    <span class="color-swatch" data-color="<?php echo $color->color_name; ?>"></span>
                    <?php echo $color->color_name; ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
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
<style>
  .checkbox-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
  }
</style>
<script>
  // Enhanced color selection experience
  document.addEventListener('DOMContentLoaded', function() {
    // Search functionality for colors (optional enhancement)
    const colorSearchInput = document.createElement('input');
    colorSearchInput.type = 'text';
    colorSearchInput.placeholder = 'Search colors...';
    colorSearchInput.classList.add('color-search');

    const colorContainer = document.querySelector('.color-scroll-container');
    if (colorContainer) {
      colorContainer.parentNode.insertBefore(colorSearchInput, colorContainer);

      colorSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const colorItems = document.querySelectorAll('.checkbox-group label');

        colorItems.forEach(item => {
          const colorName = item.textContent.trim().toLowerCase();
          const colorBox = item.closest('div');

          if (colorName.includes(searchTerm)) {
            colorBox.style.display = '';
          } else {
            colorBox.style.display = 'none';
          }
        });
      });

      // Auto-scroll to selected items
      const checkboxes = document.querySelectorAll('.checkbox-group input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          if (this.checked) {
            const label = this.nextElementSibling;
            label.scrollIntoView({
              behavior: 'smooth',
              block: 'nearest'
            });
          }
        });
      });

      // Add "Select All" and "Clear" buttons
      const controlsDiv = document.createElement('div');
      controlsDiv.classList.add('color-selection-controls');

      const selectAllBtn = document.createElement('button');
      selectAllBtn.type = 'button';
      selectAllBtn.classList.add('micro-btn');
      selectAllBtn.textContent = 'Select All';

      const clearBtn = document.createElement('button');
      clearBtn.type = 'button';
      clearBtn.classList.add('micro-btn');
      clearBtn.textContent = 'Clear';

      controlsDiv.appendChild(selectAllBtn);
      controlsDiv.appendChild(clearBtn);

      colorContainer.parentNode.insertBefore(controlsDiv, colorContainer.nextSibling);

      selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(box => box.checked = true);
      });

      clearBtn.addEventListener('click', function() {
        checkboxes.forEach(box => box.checked = false);
      });
    }
  });
</script>
