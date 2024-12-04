<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="item-details-container">
    <div class="details-header">
      <h2>Order Details</h2>
      <a href="<?php echo URLROOT ?>/Tailors/displayOrderProgress">
        <button class="close-button">&times;</button>
      </a>
    </div>

    <div class="details-content">
      <div class="product-showcase">
        <img
          src="../<?php APPROOT ?>/public/img/dotted_black_dress.png"
          alt="Dotted Black Dress"
          class="product-image">
        <h3 class="product-title">Dotted Black Dress</h3>
        <p class="product-price">$20.00</p>

        <div class="color-options">
          <div class="color-option" style="background-color: black;" title="Black"></div>
          <div class="color-option" style="background-color: gray;" title="Gray"></div>
          <div class="color-option" style="background-color: lightblue;" title="Light Blue"></div>
        </div>

        <div class="customer-details">
          <img
            src="../<?php APPROOT ?>/public/img/woman_avatar.png"
            alt="Customer Profile"
            class="customer-avatar">
          <div>
            <p class="customer-name">Pieris M.P</p>
            <p class="customer-id">Customer ID: #12345</p>
          </div>
        </div>
      </div>

      <div class="specifications">
        <ul class="spec-list">
          <li class="spec-item">
            <span class="spec-label">Material:</span>
            <span>Printed Rayon</span>
          </li>
          <li class="spec-item">
            <span class="spec-label">Style:</span>
            <span>Short Sleeves</span>
          </li>
          <li class="spec-item">
            <span class="spec-label">Length:</span>
            <span>35.5 inches</span>
          </li>
          <li class="spec-item">
            <span class="spec-label">Bust:</span>
            <span>37 inches</span>
          </li>
          <li class="spec-item">
            <span class="spec-label">Waist:</span>
            <span>38 inches</span>
          </li>
          <li class="spec-item">
            <span class="spec-label">Model Height:</span>
            <span>5 Feet 8 Inches</span>
          </li>
          <li class="spec-item">
            <span class="spec-label">Fit Type:</span>
            <span>Loose Fit</span>
          </li>
        </ul>

        <div class="care-instructions">
          <h4>Care Instructions</h4>
          <p>• Hand wash with cold water</p>
          <p>• Wash inside out</p>
          <p>• Wash light colors separately</p>
          <p>• Iron with care</p>
          <small class="disclaimer">
            * Colors may vary slightly from the images shown
          </small>
        </div>
      </div>
    </div>

    <div class="action-buttons">
      <button class="action-button accept-button">Accept Order</button>
      <button class="action-button reject-button">Reject Order</button>
    </div>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>