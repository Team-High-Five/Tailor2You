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
  <button class="add-fabric-btn" id="openEmployeeModalBtn">Add New Employee</button>

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
            <td>
              <?php if ($employee->image): ?>
                <img class="employee-table-icon" src="data:image/jpeg;base64,<?php echo base64_encode($employee->image); ?>" alt="Employee Image">
              <?php else: ?>
                <img class="employee-table-icon" src="https://via.placeholder.com/50" alt="Employee Placeholder">
              <?php endif; ?>
            </td>
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
              <button class="action-btn edit-btn" onclick="openEditEmployeeModal(<?php echo $employee->employee_id; ?>)">✎</button>
              <button class="action-btn delete-btn" onclick="confirmDelete(<?php echo $employee->employee_id; ?>)">🗑</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add New Employee Modal -->
<div id="employeeModal" class="modal">
  <div id="modal-body">
    <!-- Content from v_s_employee_add_new.php will be loaded here -->
  </div>
</div>

<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="modal">
  <div id="edit-modal-body">
    <!-- Content from v_s_edit_employee.php will be loaded here -->
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteEmployeeModal" class="modal">
  <div class="delete-modal-content">
    <div class="modal-header">
      <h1>Confirm Deletion</h1>
      <button class="close-btn" onclick="closeDeleteEmployeeModal()">&times;</button>
    </div>
    <div class="delete-modal-body">
      <p>Are you sure you want to delete this employee?</p>
      <form id="deleteEmployeeForm" action="" method="post">
        <button type="submit" class="submit-btn">Yes, Delete</button>
        <button type="button" class="reset-btn" onclick="closeDeleteEmployeeModal()">Cancel</button>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('openEmployeeModalBtn').addEventListener('click', function() {
    document.getElementById('employeeModal').style.display = 'block';
    fetch('<?php echo URLROOT; ?>/shopkeepers/addNewEmployee')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;

        // Initialize image upload functionality after modal content is loaded
        const postPreview = document.getElementById('post-preview');
        const uploadPhoto = document.getElementById('upload-photo');

        if (postPreview && uploadPhoto) {
          postPreview.addEventListener('click', function() {
            uploadPhoto.click();
          });

          uploadPhoto.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
              const reader = new FileReader();
              reader.onload = function() {
                postPreview.src = reader.result;
              };
              reader.readAsDataURL(file);

              // Validate image size
              if (file.size > 1048576) { // 1MB = 1048576 bytes
                document.getElementById('image-error').textContent = 'Image size cannot exceed 1MB';
              } else {
                document.getElementById('image-error').textContent = '';
              }
            }
          });
        }

      });
  });

  function openEditEmployeeModal(employeeId) {
    document.getElementById('editEmployeeModal').style.display = 'block';
    fetch('<?php echo URLROOT; ?>/shopkeepers/editEmployee/' + employeeId)
      .then(response => response.text())
      .then(html => {
        document.getElementById('edit-modal-body').innerHTML = html;

        // Initialize image upload functionality after modal content is loaded
        const postPreview = document.getElementById('post-preview');
        const uploadPhoto = document.getElementById('upload-photo');

        if (postPreview && uploadPhoto) {
          postPreview.addEventListener('click', function() {
            uploadPhoto.click();
          });

          uploadPhoto.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
              const reader = new FileReader();
              reader.onload = function() {
                postPreview.src = reader.result;
              };
              reader.readAsDataURL(file);

              // Validate image size
              if (file.size > 1048576) { // 1MB = 1048576 bytes
                document.getElementById('image-error').textContent = 'Image size cannot exceed 1MB';
              } else {
                document.getElementById('image-error').textContent = '';
              }
            }
          });
        }

      });
  }

  function confirmDelete(employeeId) {
    document.getElementById('deleteEmployeeModal').style.display = 'block';
    document.getElementById('deleteEmployeeForm').action = '<?php echo URLROOT; ?>/shopkeepers/deleteEmployee/' + employeeId;
  }

  function closeDeleteEmployeeModal() {
    document.getElementById('deleteEmployeeModal').style.display = 'none';
  }

  // Close modal when clicking on close button or outside
  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('employeeModal').style.display = 'none';
      document.getElementById('editEmployeeModal').style.display = 'none';
      document.getElementById('deleteEmployeeModal').style.display = 'none';
    });
  });

  window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('employeeModal')) {
      document.getElementById('employeeModal').style.display = 'none';
    }
    if (event.target == document.getElementById('editEmployeeModal')) {
      document.getElementById('editEmployeeModal').style.display = 'none';
    }
    if (event.target == document.getElementById('deleteEmployeeModal')) {
      document.getElementById('deleteEmployeeModal').style.display = 'none';
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>