<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="order-progress-container">
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
    <button class="reset-filter-btn">Reset Filter</button>
  </div>


  <div class="order-card">
    <div class="order-details">
      <img src="../<?php APPROOT ?>/public/img/dotted_black_dress.png" alt="Dotted Black Dress" class="product-image">
      <div>
        <p class="product-name">Dotted Black Dress</p>
        <p class="product-price">$20.00 x1</p>
      </div>
    </div>
    <div class="order-info">
      <p class="order-id">Order #1067907</p>
      <p class="order-date">Placed on 02/09/2024</p>
      <div class="customer-info">
        <img src="../<?php APPROOT ?>/public/img/woman_avatar.png" alt="Customer Image" class="customer-avatar">
        <p class="customer-name">Pieris M.P</p>
        <span class="status processing">Processing</span>
      </div>
      <div class="progress-bar">
        <div class="progress" style="width: 60%;"></div>
        <p class="progress-text">Status 60%</p>
      </div>
      <div class="action-buttons">
        <button class="assign-button">Assign a Tailor ▼</button>
        <button class="status-button">Order Status ▼</button>
        <button class="view-order">View Order</button>
      </div>
    </div>
  </div>

  <!-- Add another order-card for the next item -->
  <div class="order-card">
    <div class="order-details">
      <img src="../<?php APPROOT ?>/public/img/rockstar_jacket.png" alt="Rockstar Jacket" class="product-image">
      <div>
        <p class="product-name">Rockstar Jacket</p>
        <p class="product-price">$22.00 x1</p>
      </div>
    </div>
    <div class="order-info">
      <p class="order-id">Order #1067908</p>
      <p class="order-date">Placed on 04/07/2024</p>
      <div class="customer-info">
        <img src="../<?php APPROOT ?>/public/img/woman showing v sign avatar.png" alt="Customer Image" class="customer-avatar">
        <p class="customer-name">De Silva N.G</p>
        <span class="status completed">Completed</span>
      </div>
      <div class="progress-bar">
        <div class="progress" style="width: 100%;"></div>
        <p class="progress-text">Status 100%</p>
      </div>
      <div class="action-buttons">
        <button class="assign-button">Assign a Tailor ▼</button>
        <button class="status-button">Order Status ▼</button>
        <button class="view-order">View Order</button>
      </div>
    </div>
  </div>
</div>
<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>