<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="item-measurements-container">
    <div class="details-header">
      <h2>Measurements</h2>
      <a href="<?php echo URLROOT ?>/Tailors/displayOrders">
        <button class="close-button">&times;</button>
      </a>
    </div>

    <div class="details-content">
      <div class="product-showcase">
        <img
          src="../<?php APPROOT ?>/public/img/woman_avatar.png"
          alt="Customer Profile"
          class="customer-image">
        <h3 class="product-title">Pieris M.P</h3>
        <p class="product-price">Customer ID: #12345</p>
      </div>

      <div class="specifications">
        <div class="table-container">
          <table class="measurement-table">
            <thead>
              <tr>
                <th>Measurement</th>
                <th>Description</th>
                <th>Measurement</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Neck Circumference</td>
                <td>Around the base of the neck</td>
                <td>14 - 18</td>
              </tr>
              <tr>
                <td>Chest</td>
                <td>Fullest part of the chest</td>
                <td>34 - 48</td>
              </tr>
              <tr>
                <td>Waist</td>
                <td>Narrowest part of the waist</td>
                <td>28 - 44</td>
              </tr>
              <tr>
                <td>Hip</td>
                <td>Fullest part of the hips</td>
                <td>36 - 50</td>
              </tr>
              <tr>
                <td>Shoulder Width</td>
                <td>Distance between shoulder seams</td>
                <td>16 - 22</td>
              </tr>
              <tr>
                <td>Sleeve Length</td>
                <td>From shoulder seam to wrist</td>
                <td>24 - 36</td>
              </tr>
              <tr>
                <td>Armhole</td>
                <td>Circumference of the armhole</td>
                <td>16 - 22</td>
              </tr>
              <tr>
                <td>Shirt Length</td>
                <td>From the base of the neck to the hem</td>
                <td>28 - 36</td>
              </tr>
              <tr>
                <td>Cuff Circumference</td>
                <td>Around the wrist</td>
                <td>7 - 10</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="action-buttons">
      <button class="action-button request-edit-button">Request Edit</button>
    </div>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>