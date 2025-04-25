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
  <button class="add-fabric-btn" id="openModalBtn">Add New Design</button>
  <div class="filter-bar">
    <div class="filter-label">
      <i class="fas fa-filter"></i> Filter Designs
    </div>
    <select id="filter-date" class="filter-select">
      <option value="">All Dates</option>
      <option value="7">Last 7 Days</option>
      <option value="30">Last 30 Days</option>
      <option value="90">Last 3 Months</option>
      <option value="180">Last 6 Months</option>
      <option value="365">Last Year</option>
    </select>
    <select id="filter-gender" class="filter-select">
      <option value="">All Genders</option>
      <option value="gents">Men's</option>
      <option value="ladies">Women's</option>
      <option value="unisex">Unisex</option>
    </select>
    <select id="filter-status" class="filter-select">
      <option value="">All Status</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
    <button id="reset-filters" class="rst-btn">Reset</button>
  </div>
  <div class="product-grid">
    <?php if (!empty($data['designs'])): ?>
      <?php foreach ($data['designs'] as $design): ?>
        <div class="product-card"
          data-gender="<?php echo htmlspecialchars($design->gender); ?>"
          data-status="<?php echo htmlspecialchars($design->status); ?>"
          data-created-at="<?php echo htmlspecialchars($design->created_at); ?>">
          <?php if (!empty($design->main_image)): ?>
            <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $design->main_image; ?>" alt="<?php echo htmlspecialchars($design->name); ?>">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/shirt.png" alt="No Image">
          <?php endif; ?>
          <h3><?php echo htmlspecialchars($design->name); ?></h3>
          <p><?php echo htmlspecialchars($design->category_name); ?></p>
          <p class="price">Rs:<?php echo number_format($design->base_price, 0); ?></p>
          <p><?php echo ucfirst(htmlspecialchars($design->gender)); ?></p>
          <div class="product-actions">
            <a href="<?php echo URLROOT; ?>/designs/editDesign/<?php echo $design->design_id; ?>" class="action-btn edit-btn">
              <i class="fas fa-pencil-alt"></i>
              <span>Edit</span>
            </a>
            <button class="action-btn delete-btn" data-id="<?php echo $design->design_id; ?>">
              <i class="fas fa-trash-alt"></i>
              <span>Delete</span>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="no-designs-message">
        <p>You haven't created any designs yet. Click "Add New Design" to get started.</p>
      </div>
    <?php endif; ?>
  </div>
  <script src="<?php echo URLROOT; ?>/public/js/tailor/design-filters.js"></script>

  <!-- Add this script for delete functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.delete-design').forEach(button => {
        button.addEventListener('click', function() {
          const designId = this.getAttribute('data-id');
          if (confirm('Are you sure you want to delete this design?')) {
            window.location.href = `<?php echo URLROOT; ?>/designs/deleteDesign/${designId}`;
          }
        });
      });
    });
  </script>
</div>

<!-- Modal Structure -->
<div id="customizeModal" class="modal">

  <div id="modal-body">
    <!-- Content from v_t_customize_add_new.php will be loaded here -->
  </div>
</div>
<script>
  document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('customizeModal').style.display = 'block';
    // Load the content of v_t_customize_add_new.php into the modal
    fetch('<?php echo URLROOT; ?>/designs/addCustomizeItem')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;
        setupFormHandlers();
      });
  });

  document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('customizeModal').style.display = 'none';
  });

  function setupFormHandlers() {
    const categorySelect = document.getElementById('category');
    const subCategorySelect = document.getElementById('sub-category');
    const genderInputs = document.querySelectorAll('input[name="gender"]');

    if (!categorySelect || !subCategorySelect || !genderInputs) {
      console.error('Form elements not found');
      return;
    }

    // Store original categories for filtering
    const originalCategories = [...categorySelect.options].slice(1);

    // Handle gender selection
    genderInputs.forEach(input => {
      input.addEventListener('change', function() {
        const selectedGender = this.value;
        // Filter categories based on gender
        categorySelect.innerHTML = '<option value="">Select Category</option>';
        originalCategories.forEach(option => {
          if (option.dataset.gender === selectedGender || option.dataset.gender === 'unisex') {
            categorySelect.appendChild(option.cloneNode(true));
          }
        });
        // Reset subcategories
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
      });
    });

    categorySelect.addEventListener('change', function() {
      const categoryId = this.value;
      console.log('Selected category ID:', categoryId);

      if (categoryId) {
        // Load subcategories
        fetch('<?php echo URLROOT; ?>/designs/getSubcategories/' + categoryId)
          .then(response => response.text())
          .then(html => {
            console.log('Received HTML:', html);
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>' + html;
          })
          .catch(error => {
            console.error('Error loading subcategories:', error);
            subCategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
          });
      } else {
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
      }
    });
  }
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>