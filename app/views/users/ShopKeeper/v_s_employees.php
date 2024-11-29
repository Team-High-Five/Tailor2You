<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

<div class="main-content">
  <button class="add-fabric-btn">Add New Employee</button>

  <div class="table-container">
    <table class="product-table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Employee Name</th>
          <th>Employee Id</th>
          <th>Phone Number</th>
          <th>Home Town</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><img src="young woman talking.png" alt="Employee" class="product-image"></td>
          <td>Kumudu Y.M.</td>
          <td>001</td>
          <td>0705679436</td>
          <td>Mawanella</td>
          <td>kumudu@gmail.com</td>
          <td>
            <button class="action-btn edit-btn">✎</button>
            <button class="action-btn delete-btn">🗑</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>