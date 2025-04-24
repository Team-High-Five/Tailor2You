<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>
<div class="main-content">
  <!-- Changed to match portfolio button style -->
  <button class="btn-primary add-post-btn" onclick="window.location.href='<?php echo URLROOT; ?>/customize'">Add New Design</button>
  
  <!-- Add vertical space between button and filter bar -->
  <div style="margin: 20px 0;"></div>
  
  <div class="filter-bar">
    <h6>Filter By</h6>
    <select>
      <option>Date</option>
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

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>