<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
  <button class="add-fabric-btn" id="openModalBtn">Add New Design</button>
  <div class="filter-bar">
    <button class="filter-btn">Filter By</button>
    <select>
      <option>14 Feb 2019</option>
      <!-- Add more date options as needed -->
    </select>
    <select>
      <option>Order Type</option>
      <!-- Add more order types as needed -->
    </select>
    <select>
      <option>Order Status</option>
      <!-- Add more statuses as needed -->
    </select>
  </div>
  <div class="product-grid">
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/shirt.png" alt="Long Sleeves">
      <h3>Long Sleeves</h3>
      <p>Shirts</p>
      <p class="price">Rs:3000</p>
      <p>Men</p>
      <div class="product-actions">
        <button class="btn-primary">Edit</button>
        <button class="btn-danger">Delete</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/trouser.png" alt="Trousers">
      <h3>Trousers</h3>
      <p>Pants</p>
      <p class="price">Rs:4000</p>
      <p>Men</p>
      <div class="product-actions">
        <button class="btn-primary">Edit</button>
        <button class="btn-danger">Delete</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/shirt.png" alt="Jacket">
      <h3>Jacket</h3>
      <p>Shirts</p>
      <p class="price">Rs:10000</p>
      <p>Men</p>
      <div class="product-actions">
        <button class="btn-primary">Edit</button>
        <button class="btn-danger">Delete</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/trouser.png" alt="Trousers">
      <h3>Trousers</h3>
      <p>Pants</p>
      <p class="price">Rs:4000</p>
      <p>Men</p>
      <div class="product-actions">
        <button class="btn-primary">Edit</button>
        <button class="btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="customizeModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h1>Add New Design</h1>
      <button class="close-btn">&times;</button>
    </div>
    <div id="modal-body">
      <!-- Content from v_t_customize_add_new.php will be loaded here -->
    </div>
  </div>
</div>

<script>
  document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('customizeModal').style.display = 'block';
    // Load the content of v_t_customize_add_new.php into the modal
    fetch('<?php echo URLROOT; ?>/tailors/addCustomizeItem')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;
      });
  });

  document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('customizeModal').style.display = 'none';
  });

  window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('customizeModal')) {
      document.getElementById('customizeModal').style.display = 'none';
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>