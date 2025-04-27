<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <?php flash('fabric_message'); ?>

  <button class="add-fabric-btn" id="openFabricModalBtn">Add New Fabric</button>

  <div class="table-container">
    <table class="product-table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Fabric Name</th>
          <th>Fabric Id</th>
          <th>Price</th>
          <th>Stock(m)</th>
          <th>Available Color</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['fabrics'] as $fabric): ?>
          <tr>
            <td>
              <?php if ($fabric->image): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($fabric->image); ?>" alt="<?php echo $fabric->fabric_name; ?>" class="fabric-image">
              <?php else: ?>
                <img src="https://via.placeholder.com/50" alt="<?php echo $fabric->fabric_name; ?>" class="fabric-image">
              <?php endif; ?>
            </td>
            <td><?php echo $fabric->fabric_name; ?></td>
            <td><?php echo $fabric->fabric_id; ?></td>
            <td>Rs.<?php echo number_format($fabric->price_per_meter, 2); ?></td>
            <td><?php echo $fabric->stock; ?></td>
            <td>
              <?php
              $colors = explode(', ', $fabric->colors);
              foreach ($colors as $color):
              ?>
                <span class="color-dot" style="background-color: <?php echo strtolower($color); ?>;"></span>
              <?php endforeach; ?>
            </td>
            <td>
              <button class="action-btn edit-btn" onclick="openEditFabricModal(<?php echo $fabric->fabric_id; ?>)">✎</button>
              <button class="action-btn delete-btn" onclick="confirmDelete(<?php echo $fabric->fabric_id; ?>)">🗑</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add New Fabric Modal -->
<div id="fabricModal" class="modal">
  <div id="modal-body">
    <!-- Content from v_t_add_new_fabric.php will be loaded here -->
  </div>
</div>

<!-- Edit Fabric Modal -->
<div id="editFabricModal" class="modal">
  <div id="edit-modal-body">
    <!-- Content from v_t_edit_fabric.php will be loaded here -->
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteFabricModal" class="modal">
  <div class="delete-modal-content">
    <div class="modal-header">
      <h1>Confirm Deletion</h1>
      <button class="close-btn" onclick="closeDeleteFabricModal()">&times;</button>
    </div>
    <div class="delete-modal-body">
      <p>Are you sure you want to delete this fabric?</p>
      <form id="deleteFabricForm" action="" method="post">
        <button type="submit" class="submit-btn">Yes, Delete</button>
        <button type="button" class="reset-btn" onclick="closeDeleteFabricModal()">Cancel</button>
      </form>
    </div>
  </div>
</div>

<script>
  // Open Add Fabric Modal with animation
  document.getElementById('openFabricModalBtn').addEventListener('click', function() {
    const modal = document.getElementById('fabricModal');

    // First set display to flex
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';

    // Force browser reflow to enable transition
    void modal.offsetWidth;

    // Then add the show class for animation
    setTimeout(() => {
      modal.classList.add('show');
    }, 10);

    // Fetch the content
    fetch('<?php echo URLROOT; ?>/tailors/addNewFabric')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;
        initializeFormHandlers('addFabricForm', 'post-preview', 'upload-photo');
      })
      .catch(error => {
        console.error('Error loading form:', error);
        modal.classList.remove('show');
        setTimeout(() => {
          modal.style.display = 'none';
        }, 300);
      });
  });

  // Open Edit Fabric Modal with animation
  function openEditFabricModal(fabricId) {
    const modal = document.getElementById('editFabricModal');

    // First set display to flex
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';

    // Force browser reflow
    void modal.offsetWidth;

    // Then add the show class
    setTimeout(() => {
      modal.classList.add('show');
    }, 10);

    // Fetch the content
    fetch('<?php echo URLROOT; ?>/tailors/editFabric/' + fabricId)
      .then(response => response.text())
      .then(html => {
        document.getElementById('edit-modal-body').innerHTML = html;
        initializeFormHandlers('editFabricForm', 'post-preview', 'upload-photo');
      })
      .catch(error => {
        console.error('Error loading edit form:', error);
        modal.classList.remove('show');
        setTimeout(() => {
          modal.style.display = 'none';
        }, 300);
      });
  }

  // Confirm Delete Modal with animation
  function confirmDelete(fabricId) {
    const modal = document.getElementById('deleteFabricModal');

    // Set form action
    document.getElementById('deleteFabricForm').action =
      '<?php echo URLROOT; ?>/fabrics/deleteFabric/' + fabricId + '/Tailors';

    // First set display to flex
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';

    // Force browser reflow
    void modal.offsetWidth;

    // Then add the show class
    setTimeout(() => {
      modal.classList.add('show');
    }, 10);
  }

  // Generic close modal function with animation
  function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('show');

    // Wait for animation to complete before hiding
    setTimeout(() => {
      modal.style.display = 'none';
    }, 300); // Match your CSS transition time
  }

  // Close Delete Fabric Modal function
  function closeDeleteFabricModal() {
    closeModal('deleteFabricModal');
  }

  // Helper function to initialize image upload and form validation
  function initializeFormHandlers(formId, previewId, uploadId) {
    // Image preview functionality
    const preview = document.getElementById(previewId);
    const upload = document.getElementById(uploadId);

    if (preview && upload) {
      preview.addEventListener('click', function() {
        upload.click();
      });

      upload.addEventListener('change', function(event) {
        if (event.target.files.length > 0) {
          const file = event.target.files[0];
          const reader = new FileReader();

          reader.onload = function() {
            preview.src = reader.result;
          };

          reader.readAsDataURL(file);

          // Validate image size
          if (file.size > 1048576) { // 1MB = 1048576 bytes
            document.getElementById('image-error').textContent = 'Image size cannot exceed 1MB';
          } else {
            document.getElementById('image-error').textContent = '';
          }
        }
      });
    }

    // Form validation
    const form = document.getElementById(formId);
    if (form) {
      form.addEventListener('submit', function(event) {
        let isValid = true;

        // Validate fabric name
        const fabricName = document.getElementById('fabric-name');
        if (fabricName && fabricName.value.trim() === '') {
          document.getElementById('fabric-name-error').textContent = 'Please enter fabric name';
          isValid = false;
        } else if (fabricName) {
          document.getElementById('fabric-name-error').textContent = '';
        }

        // Validate price
        const price = document.getElementById('price');
        if (price && (price.value.trim() === '' || isNaN(price.value) || parseFloat(price.value) < 0)) {
          document.getElementById('price-error').textContent = 'Please enter a valid price';
          isValid = false;
        } else if (price) {
          document.getElementById('price-error').textContent = '';
        }

        // Validate stock
        const stock = document.getElementById('stock');
        if (stock && (stock.value.trim() === '' || isNaN(stock.value) || parseFloat(stock.value) < 0)) {
          document.getElementById('stock-error').textContent = 'Stock cannot be negative';
          isValid = false;
        } else if (stock) {
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
        const imageInput = document.getElementById(uploadId);
        if (imageInput && imageInput.files.length > 0) {
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
    }
  }

  // Set up event listeners for close buttons (after DOM is fully loaded)
  document.addEventListener('DOMContentLoaded', function() {
    // Use event delegation for close buttons
    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('close-btn')) {
        const modal = event.target.closest('.modal');
        if (modal) {
          modal.classList.remove('show');
          setTimeout(() => {
            modal.style.display = 'none';
          }, 300);
        }
      }
    });

    // Click outside to close modal
    window.addEventListener('click', function(event) {
      const modals = document.querySelectorAll('.modal');
      modals.forEach(modal => {
        if (event.target === modal) {
          modal.classList.remove('show');
          setTimeout(() => {
            modal.style.display = 'none';
          }, 300);
        }
      });
    });
  });
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>