<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

<style>
  .employee-table-icon {
    width: 50px;
    height: 50%;
    border-radius: 50%;
  }
</style>
<div class="main-content">

  <a href="<?php echo URLROOT; ?>/Shopkeepers/addNewEmployee"> <button class="add-fabric-btn" id="openEmployeeModalBtn">Add New Employee</button></a>

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
        <?php foreach ($data['employees'] as $employee) : ?>
          <tr>
            <td><img class="employee-table-icon" src="<?php echo URLROOT; ?>/public/uploads/<?php echo $employee->image; ?>" alt="Employee" class="product-image"></td>
            <td>
              <?php if (isset($employee->first_name) && isset($employee->last_name)): ?>
                <?php echo $employee->first_name . ' ' . $employee->last_name; ?>
              <?php else: ?>
                <?php echo 'Name not available'; ?>
              <?php endif; ?>
            </td>
            <td><?php echo $employee->employee_id; ?></td>
            <td><?php echo $employee->phone_number; ?></td>
            <td><?php echo $employee->home_town; ?></td>
            <td><?php echo $employee->email; ?></td>
            <td>
              <button class="action-btn edit-btn">✎</button>
              <button class="action-btn delete-btn">🗑</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>