<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

<style>
  .employee-table-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin: 0 auto;
  }
</style>
<div class="main-content">
  <button class="btn-primary add-post-btn" id="openEmployeeModalBtn">Add New Employee</button>
  
  <!-- Add vertical space between button and filter bar -->
  <div style="margin: 20px 0;"></div>

  <div class="filter-bar">
    <div class="filter-label">
      <i class="fas fa-filter"></i> Filter Employees
    </div>
    
    <input type="text" id="name-search" class="search-input" placeholder="Search by name...">
    
    <div class="district-filter">
      <label>District:</label>
      <select id="district-filter" class="filter-select">
        <option value="">All Districts</option>
        <option value="Ampara">Ampara</option>
        <option value="Anuradhapura">Anuradhapura</option>
        <option value="Badulla">Badulla</option>
        <option value="Batticaloa">Batticaloa</option>
        <option value="Colombo">Colombo</option>
        <option value="Galle">Galle</option>
        <option value="Gampaha">Gampaha</option>
        <option value="Hambantota">Hambantota</option>
        <option value="Jaffna">Jaffna</option>
        <option value="Kalutara">Kalutara</option>
        <option value="Kandy">Kandy</option>
        <option value="Kegalle">Kegalle</option>
        <option value="Kilinochchi">Kilinochchi</option>
        <option value="Kurunegala">Kurunegala</option>
        <option value="Mannar">Mannar</option>
        <option value="Matale">Matale</option>
        <option value="Matara">Matara</option>
        <option value="Monaragala">Monaragala</option>
        <option value="Mullaitivu">Mullaitivu</option>
        <option value="Nuwara Eliya">Nuwara Eliya</option>
        <option value="Polonnaruwa">Polonnaruwa</option>
        <option value="Puttalam">Puttalam</option>
        <option value="Ratnapura">Ratnapura</option>
        <option value="Trincomalee">Trincomalee</option>
        <option value="Vavuniya">Vavuniya</option>
      </select>
    </div>
    
    <div class="portfolio-actions" style="display: inline-block; margin-left: 10px;">
      <button id="apply-filters" class="edit-btn" style="display: inline-block; margin-right: 5px;"><i class="fas fa-check"></i> Apply</button>
      <button id="reset-filters" class="delete-btn" style="display: inline-block;"><i class="fas fa-undo"></i> Reset</button>
    </div>
  </div>

  <div class="table-container">
    <table class="product-table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Employee Name</th>
          <th>Employee Id</th>
          <th>Phone Number</th>
          <th>Home Town</th>
          <th>District</th>
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
            <td><?php echo isset($employee->district) ? $employee->district : 'Not specified'; ?></td>
            <td><?php echo $employee->email; ?></td>
            <td>
              <div class="portfolio-actions">
                <button class="edit-btn" onclick="openEditEmployeeModal(<?php echo $employee->employee_id; ?>)"><i class="fas fa-edit"></i></button>
                <button class="delete-btn" onclick="confirmDelete(<?php echo $employee->employee_id; ?>)"><i class="fas fa-trash-alt"></i></button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="no-results" style="display: none;">No employees match your filter criteria</div>
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
<script src="<?php echo URLROOT; ?>/public/js/shopkeeper/employee-filters.js"></script>