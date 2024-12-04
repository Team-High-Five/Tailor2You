<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

<style>
  .employee-table-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
  }
</style>
<div class="main-content">

<a href="<?php echo URLROOT; ?>/Shopkeepers/addNewEmployee"> <button class="add-fabric-btn" id="openEmployeeModalBtn">Add New Fabric</button></a>

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
          <td><img class="employee-table-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="Employee" class="product-image"></td>
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