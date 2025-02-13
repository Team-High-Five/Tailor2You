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
  // Image preview functionality
  document.getElementById('post-preview').addEventListener('click', function() {
    document.getElementById('upload-photo').click();
  });

  document.getElementById('upload-photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function() {
      const output = document.getElementById('post-preview');
      output.src = reader.result;
    };
    reader.readAsDataURL(file);

    // Validate image size
    if (file.size > 1048576) { // 1MB = 1048576 bytes
      document.getElementById('image-error').textContent = 'Image size cannot exceed 1MB';
    } else {
      document.getElementById('image-error').textContent = '';
    }
  });

  // Form validation
  document.getElementById('addEmployeeForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Validate first name
    const firstName = document.getElementById('first_name').value;
    if (firstName.trim() === '') {
      document.getElementById('first_name-error').textContent = 'Please enter first name';
      isValid = false;
    } else {
      document.getElementById('first_name-error').textContent = '';
    }

    // Validate last name
    const lastName = document.getElementById('last_name').value;
    if (lastName.trim() === '') {
      document.getElementById('last_name-error').textContent = 'Please enter last name';
      isValid = false;
    } else {
      document.getElementById('last_name-error').textContent = '';
    }

    // Validate phone number
    const phoneNumber = document.getElementById('phone_number').value;
    if (phoneNumber.trim() === '' || !/^\d{10}$/.test(phoneNumber)) {
      document.getElementById('phone_number-error').textContent = 'Please enter a valid 10-digit phone number';
      isValid = false;
    } else {
      document.getElementById('phone_number-error').textContent = '';
    }

    // Validate email
    const email = document.getElementById('email').value;
    if (email.trim() === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      document.getElementById('email-error').textContent = 'Please enter a valid email address';
      isValid = false;
    } else {
      document.getElementById('email-error').textContent = '';
    }

    // Validate home town
    const homeTown = document.getElementById('home_town').value;
    if (homeTown.trim() === '') {
      document.getElementById('home_town-error').textContent = 'Please enter home town';
      isValid = false;
    } else {
      document.getElementById('home_town-error').textContent = '';
    }

    // Validate image size
    const imageInput = document.getElementById('upload-photo');
    if (imageInput.files.length > 0) {
      const imageFile = imageInput.files[0];
      if (imageFile.size > 1048576) {
        document.getElementById('image-error').textContent = 'Image size cannot exceed 1MB';
        isValid = false;
      } else {
        document.getElementById('image-error').textContent = '';
      }
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>