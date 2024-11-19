<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="content">
    <h1>Fabric Stock</h1>
    <a href="<?php echo URLROOT ?>/Tailors/addNewFabric"><button class="add-fabric-btn">Add New Fabric</button></a>

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
          <tr>
            <td><img src="https://via.placeholder.com/50" alt="Linen" class="product-image"></td>
            <td>Linen</td>
            <td>001</td>
            <td>$690.00</td>
            <td>63</td>
            <td>
              <span class="color-dot" style="background-color: black;"></span>
              <span class="color-dot" style="background-color: pink;"></span>
              <span class="color-dot" style="background-color: #D4A373;"></span>
            </td>
            <td>
              <button class="action-btn edit-btn">✎</button>
              <button class="action-btn delete-btn">🗑</button>
            </td>
          </tr>
          <!-- Add more rows as needed -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>