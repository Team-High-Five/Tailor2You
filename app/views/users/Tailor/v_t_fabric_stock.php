<?php if ($_SESSION['user_type'] == 'shopkeeper') {
  require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] == 'tailor') {
  require_once APPROOT . '/views/users/Tailor/inc/Header.php';
  require_once APPROOT . '/views/users/Tailor/inc/sideBar.php';
  require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} ?>
<div class="main-content">
  <?php flash('fabric_message'); ?>
  <?php flash('fabric_error'); ?>
  <?php flash('fabric_success'); ?>
  
  <button class="btn-primary add-post-btn" id="openFabricModalBtn">Add New Fabric</button>

  <!-- Add vertical space between button and filter bar -->
  <div style="margin: 20px 0;"></div>

  <div class="filter-bar">
    <div class="filter-label">
      <i class="fas fa-filter"></i> Filter Fabrics
    </div>

    <div class="price-filter">
      <label>Price:</label>
      <select id="price-sort" class="filter-select">
        <option value="">Default</option>
        <option value="asc">Lowest to Highest</option>
        <option value="desc">Highest to Lowest</option>
      </select>
    </div>

    <div class="stock-filter">
      <label>Stock:</label>
      <select id="stock-sort" class="filter-select">
        <option value="">Default</option>
        <option value="asc">Lowest to Highest</option>
        <option value="desc">Highest to Lowest</option>
      </select>
    </div>

    <div class="color-filter">
      <label>Colors:</label>
      <select id="color-select" class="filter-select">
        <option value="">All Colors</option>
        <option value="red">Red</option>
        <option value="blue">Blue</option>
        <option value="green">Green</option>
        <option value="black">Black</option>
        <option value="white">White</option>
        <option value="yellow">Yellow</option>
        <option value="purple">Purple</option>
        <option value="orange">Orange</option>
        <option value="gray">Gray</option>
        <option value="brown">Brown</option>
      </select>
    </div>

    <button id="reset-filters" class="rst-btn">Reset</button>
  </div>

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
              <div class="portfolio-actions">
                <button class="edit-btn" onclick="openEditFabricModal(<?php echo $fabric->fabric_id; ?>)"><i class="fas fa-edit"></i></button>
                <button class="delete-btn" onclick="confirmDelete(<?php echo $fabric->fabric_id; ?>)"><i class="fas fa-trash-alt"></i></button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="no-results" style="display: none;">No fabrics match your filter criteria</div>
  </div>
</div>

<!-- Add New Fabric Modal -->
<div id="fabricModal" class="modal">
  <div class="modal-body">
    <!-- Content from v_s_add_new_fabric.php will be loaded here -->
  </div>
</div>

<!-- Edit Fabric Modal -->
<div id="editFabricModal" class="modal">
  <div class="modal-body">
    <!-- Content from v_s_edit_fabric.php will be loaded here -->
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteFabricModal" class="modal">
  <div class="modal-body">
    <div class="delete-modal-content">
      <div class="modal-header">
        <h1>Confirm Deletion</h1>
        <button class="close-btn">&times;</button>
      </div>
      <div class="modal-content">
        <p>Are you sure you want to delete this fabric?</p>
        <div class="button-rows">
          <form id="deleteFabricForm" action="" method="post">
            <button type="submit" class="submit-btn">Yes, Delete</button>
          </form>
          <button type="button" class="reset-btn" onclick="closeDeleteFabricModal()">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Open Add Fabric Modal
    document.getElementById('openFabricModalBtn').addEventListener('click', function() {
      const modal = document.getElementById('fabricModal');

      // First display the modal
      modal.style.display = 'flex';

      // Force browser reflow to enable transition
      void modal.offsetWidth;

      // Then add the show class for animation
      modal.classList.add('show');

      // Fetch the content
      fetch('<?php echo URLROOT; ?>/tailors/addNewFabric')
        .then(response => response.text())
        .then(html => {
          document.querySelector('#fabricModal .modal-body').innerHTML = html;

          // After content is loaded, attach event handlers
          attachEventListeners('addFabricForm', 'post-preview', 'upload-photo');
        })
        .catch(error => {
          console.error('Error loading form:', error);
        });
    });

    // Edit Fabric Modal
    window.openEditFabricModal = function(fabricId) {
      const modal = document.getElementById('editFabricModal');

      // First display the modal
      modal.style.display = 'flex';

      // Force browser reflow to enable transition
      void modal.offsetWidth;

      // Then add the show class for animation
      modal.classList.add('show');

      // Fetch the content
      fetch('<?php echo URLROOT; ?>/tailors/editFabric/' + fabricId)
        .then(response => response.text())
        .then(html => {
          document.querySelector('#editFabricModal .modal-body').innerHTML = html;

          // After content is loaded, attach event handlers
          attachEventListeners('editFabricForm', 'post-preview', 'upload-photo');
        })
        .catch(error => {
          console.error('Error loading form:', error);
        });
    };

    // Delete Fabric Modal
    window.confirmDelete = function(fabricId) {
      const modal = document.getElementById('deleteFabricModal');

      // Set the form action
      document.getElementById('deleteFabricForm').action =
        '<?php echo URLROOT; ?>/tailors/deleteFabric/' + fabricId;

      // Show the modal with animation
      modal.style.display = 'flex';
      void modal.offsetWidth;
      modal.classList.add('show');
    };

    window.closeDeleteFabricModal = function() {
      const modal = document.getElementById('deleteFabricModal');
      modal.classList.remove('show');

      setTimeout(() => {
        modal.style.display = 'none';
      }, 300);
    };

    // Generic function to attach event listeners to forms
    function attachEventListeners(formId, previewId, uploadId) {
      const form = document.getElementById(formId);
      const preview = document.getElementById(previewId);
      const upload = document.getElementById(uploadId);

      if (preview) {
        // Find the wrapper div
        const wrapper = preview.closest('.post-pic-wrapper');
        if (wrapper && upload) {
          wrapper.addEventListener('click', function() {
            upload.click();
          });
        }
      }

      if (upload && preview) {
        upload.addEventListener('change', function(event) {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function() {
              preview.src = reader.result;
              preview.classList.add('has-image');
            };
            reader.readAsDataURL(file);

            // Image validation
            const errorElement = document.getElementById('image-error');
            if (errorElement) {
              if (file.size > 1048576) { // 1MB
                errorElement.textContent = 'Image size cannot exceed 1MB';
                errorElement.classList.add('show');
              } else {
                errorElement.textContent = '';
                errorElement.classList.remove('show');
              }
            }
          }
        });
      }

      // Form validation
      if (form) {
        form.addEventListener('submit', function(event) {
          validateFabricForm(event, form);
        });
      }
    }

    // Function to validate fabric forms
    function validateFabricForm(event, form) {
      let isValid = true;

      // Fabric name validation
      const fabricName = form.querySelector('[name="fabric_name"]');
      if (fabricName && fabricName.value.trim() === '') {
        showError(fabricName, 'fabric-name-error', 'Please enter fabric name');
        isValid = false;
      } else if (fabricName) {
        clearError('fabric-name-error');
      }

      // Price validation
      const price = form.querySelector('[name="price"]');
      if (price && (price.value.trim() === '' || isNaN(price.value) || parseFloat(price.value) <= 0)) {
        showError(price, 'price-error', 'Please enter a valid price');
        isValid = false;
      } else if (price) {
        clearError('price-error');
      }

      // Stock validation
      const stock = form.querySelector('[name="stock"]');
      if (stock && (stock.value.trim() === '' || isNaN(stock.value) || parseFloat(stock.value) < 0)) {
        showError(stock, 'stock-error', 'Stock cannot be negative');
        isValid = false;
      } else if (stock) {
        clearError('stock-error');
      }

      // Colors validation
      const colors = form.querySelectorAll('input[name="colors[]"]:checked');
      if (colors.length === 0) {
        showError(null, 'color-error', 'Please select at least one color');
        isValid = false;
      } else {
        clearError('color-error');
      }

      // Prevent form submission if validation fails
      if (!isValid) {
        event.preventDefault();
      }
    }

    function showError(element, errorId, message) {
      const errorElement = document.getElementById(errorId);
      if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');

        // Add error class to parent form-group if element exists
        if (element) {
          const formGroup = element.closest('.form-group');
          if (formGroup) formGroup.classList.add('has-error');
        }
      }
    }

    function clearError(errorId) {
      const errorElement = document.getElementById(errorId);
      if (errorElement) {
        errorElement.textContent = '';
        errorElement.classList.remove('show');

        // Find parent and remove error class
        const formGroup = errorElement.closest('.form-group');
        if (formGroup) formGroup.classList.remove('has-error');
      }
    }

    // Close buttons and background click handling
    document.addEventListener('click', function(event) {
      // Close button handling
      if (event.target.classList.contains('close-btn')) {
        const modal = event.target.closest('.modal');
        if (modal) {
          modal.classList.remove('show');
          setTimeout(() => {
            modal.style.display = 'none';
          }, 300);
        }
      }

      // Background click handling
      if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
        setTimeout(() => {
          event.target.style.display = 'none';
        }, 300);
      }
    });
  });
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>
<script src="<?php echo URLROOT; ?>/public/js/tailor/fabric-filters.js"></script>