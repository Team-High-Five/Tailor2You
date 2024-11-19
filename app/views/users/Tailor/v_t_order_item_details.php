<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="item-details-modal">
    <div class="modal-header">
      <h2>Item Details</h2>
      <a href="<?php echo URLROOT ?>/Tailors/displayOrderProgress"><button class="close-btn">&times;</button></a>
    </div>

    <div class="modal-body">
      <div class="item-details-content">
        <div class="left-section">
          <img src="../<?php APPROOT ?>/public/img/dotted_black_dress.png" alt="Dotted Black Dress" class="item-image">
          <h3 class="item-name">Dotted Black Dress</h3>
          <p class="item-price">$20.00</p>
          <div class="colors">
            <span class="color-dot" style="background-color: black;"></span>
            <span class="color-dot" style="background-color: gray;"></span>
            <span class="color-dot" style="background-color: lightblue;"></span>
          </div>
          <div class="customer-info">
            <img src="../<?php APPROOT ?>/public/img/woman_avatar.png" alt="Customer Profile" class="customer-avatar">
            <p class="customer-name">Pieris M.P</p>
          </div>
        </div>

        <div class="right-section">
          <ul class="item-specs">
            <li><strong>Material:</strong> Printed Rayon</li>
            <li><strong>Style:</strong> Short Sleeves</li>
            <li><strong>Size L Measurements:</strong> Length 35.5" / Bust 37" / Waist 38"</li>
            <li><strong>Model Height:</strong> 5 Feet 8 Inches</li>
            <li><strong>Fit:</strong> Loose Fit</li>
          </ul>
          <p class="item-description">
            <strong>Wash & Care:</strong> Hand wash with cold water, wash inside out,
            wash light colors separately & iron with care.
          </p>
          <p class="disclaimer">
            Despite every effort to provide accurate images of each product's color and design,
            actual colors and design may vary slightly.
          </p>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn-accept-btn">Accept</button>
      <button class="btn-reject-btn">Reject</button>
    </div>
  </div>
</div>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>