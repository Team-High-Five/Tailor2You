<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>


<div class="measurement-modal">
  <div class="modal-header">
    <h2>Measurements</h2>
    <a href="<?php echo URLROOT ?>/Shopkeepers/displayOrders"><button class="close-btn">&times;</button></a>
  </div>

  <div class="customer-info">
    <img src="../<?php APPROOT ?>/public/img/woman_avatar.png" alt="Customer Profile" class="customer-avatar">
    <p class="customer-name">Pieris M.P</p>
  </div>
  <div class="modal-body">

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

  <div class="modal-footer">
    <button class="btn request-edit-btn">Request Edit</button>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>