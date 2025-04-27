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
  <div class="modal-body">
    <!-- Content from v_s_employee_add_new.php will be loaded here -->
  </div>
</div>


<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="modal">
  <div class="modal-body">
    <!-- Content from v_s_edit_employee.php will be loaded here -->
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteFabricModal" class="modal">
  <div class="modal-body">
    <div class="delete-modal-content">
      <div class="modal-header">
        <h1>Confirm Deletion</h1>
        <button class="close-btn">&times;</button>
      </div>
      <div class="modal-content">
        <p>Are you sure you want to delete this employee?</p>
        <div class="button-rows">
          <form id="deleteEmployeeForm" action="" method="post">
            <button type="submit" class="submit-btn">Yes, Delete</button>
          </form>
         
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Open Add Employee Modal
    document.getElementById('openEmployeeModalBtn').addEventListener('click', function() {
      const modal = document.getElementById('employeeModal');

      // First display the modal
      modal.style.display = 'flex';

      // Force browser reflow to enable transition
      void modal.offsetWidth;

      // Then add the show class for animation
      modal.classList.add('show');

      // Fetch the content
      fetch('<?php echo URLROOT; ?>/shopkeepers/addNewEmployee')
        .then(response => response.text())
        .then(html => {
          document.querySelector('#employeeModal .modal-body').innerHTML = html;

          // After content is loaded, attach event handlers
          attachEventListenersToEmployeeForm();
        })
        .catch(error => {
          console.error('Error loading form:', error);
        });
    });

    // Edit Employee Modal
    window.openEditEmployeeModal = function(employeeId) {
      const modal = document.getElementById('editEmployeeModal');

      // First display the modal
      modal.style.display = 'flex';

      // Force browser reflow to enable transition
      void modal.offsetWidth;

      // Then add the show class for animation
      modal.classList.add('show');

      // Fetch the content
      fetch('<?php echo URLROOT; ?>/shopkeepers/editEmployee/' + employeeId)
        .then(response => response.text())
        .then(html => {
          document.querySelector('#editEmployeeModal .modal-body').innerHTML = html;

          // After content is loaded, attach event handlers
          attachEventListenersToEmployeeForm();
        })
        .catch(error => {
          console.error('Error loading form:', error);
        });
    };

    // Delete Employee Modal
    window.confirmDelete = function(employeeId) {
      const modal = document.getElementById('deleteFabricModal');

      // Set the form action
      document.getElementById('deleteEmployeeForm').action =
        '<?php echo URLROOT; ?>/shopkeepers/deleteEmployee/' + employeeId;

      // Show the modal with animation
      modal.style.display = 'flex';
      void modal.offsetWidth;
      modal.classList.add('show');
    };

    // Cancel delete button
    document.getElementById('cancelDelete').addEventListener('click', function() {
      closeModal(document.getElementById('deleteFabricModal'));
    });

    // Generic function to attach event listeners to employee forms
    function attachEventListenersToEmployeeForm() {
      const uploadPhoto = document.getElementById('upload-photo');
      const postPreview = document.getElementById('post-preview');
      const imageUploadArea = document.getElementById('image-upload-area');

      // Image upload area click event
      if (imageUploadArea && uploadPhoto) {
        imageUploadArea.addEventListener('click', function() {
          uploadPhoto.click();
        });
      } else if (postPreview && uploadPhoto) {
        // Fallback to old structure
        postPreview.addEventListener('click', function() {
          uploadPhoto.click();
        });
      }

      // File upload change event
      if (uploadPhoto && postPreview) {
        uploadPhoto.addEventListener('change', function(event) {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              postPreview.src = e.target.result;
              postPreview.classList.add('has-image');
            };
            reader.readAsDataURL(file);

            // Validate image size
            const errorElement = document.getElementById('image-error');
            if (errorElement) {
              if (file.size > 1048576) { // 1MB
                errorElement.textContent = 'Image size cannot exceed 1MB';
                errorElement.classList.add('show');
              } else {
                errorElement.textContent = '';
                errorElement.classList.remove('show');
              }
            }
          }
        });
      }

      // Form validation
      const addForm = document.getElementById('addEmployeeForm');
      const editForm = document.getElementById('editEmployeeForm');

      if (addForm) {
        addForm.addEventListener('submit', validateEmployeeForm);
      }

      if (editForm) {
        editForm.addEventListener('submit', validateEmployeeForm);
      }

      // Close buttons in the loaded content
      document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          closeModal(this.closest('.modal'));
        });
      });
    }

    // Validate employee form
    function validateEmployeeForm(event) {
      let isValid = true;
      const form = this;

      // First name validation
      const firstName = form.querySelector('[name="first_name"]');
      if (firstName && firstName.value.trim() === '') {
        showError(firstName, 'first_name-error', 'Please enter first name');
        isValid = false;
      } else if (firstName) {
        clearError('first_name-error');
      }

      // Last name validation
      const lastName = form.querySelector('[name="last_name"]');
      if (lastName && lastName.value.trim() === '') {
        showError(lastName, 'last_name-error', 'Please enter last name');
        isValid = false;
      } else if (lastName) {
        clearError('last_name-error');
      }

      // Phone validation
      const phone = form.querySelector('[name="phone_number"]');
      if (phone) {
        const phoneRegex = /^[0-9]{10}$/;
        if (phone.value.trim() === '') {
          showError(phone, 'phone_number-error', 'Please enter phone number');
          isValid = false;
        } else if (!phoneRegex.test(phone.value.trim())) {
          showError(phone, 'phone_number-error', 'Please enter a valid 10-digit phone number');
          isValid = false;
        } else {
          clearError('phone_number-error');
        }
      }

      // Email validation
      const email = form.querySelector('[name="email"]');
      if (email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value.trim() === '') {
          showError(email, 'email-error', 'Please enter email address');
          isValid = false;
        } else if (!emailRegex.test(email.value.trim())) {
          showError(email, 'email-error', 'Please enter a valid email address');
          isValid = false;
        } else {
          clearError('email-error');
        }
      }

      // Home town validation
      const homeTown = form.querySelector('[name="home_town"]');
      if (homeTown && homeTown.value.trim() === '') {
        showError(homeTown, 'home_town-error', 'Please enter home town');
        isValid = false;
      } else if (homeTown) {
        clearError('home_town-error');
      }

      // District validation
      const district = form.querySelector('[name="district"]');
      if (district && district.value === '') {
        showError(district, 'district-error', 'Please select a district');
        isValid = false;
      } else if (district) {
        clearError('district-error');
      }

      // Prevent form submission if validation fails
      if (!isValid) {
        event.preventDefault();
      }
    }

    function showError(element, errorId, message) {
      const errorElement = document.getElementById(errorId);
      if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');

        // Add error class to parent form-group
        if (element) {
          const formGroup = element.closest('.form-group');
          if (formGroup) formGroup.classList.add('has-error');
        }
      }
    }

    function clearError(errorId) {
      const errorElement = document.getElementById(errorId);
      if (errorElement) {
        errorElement.textContent = '';
        errorElement.classList.remove('show');

        // Remove error class from parent form-group
        const formGroup = errorElement.closest('.form-group');
        if (formGroup) formGroup.classList.remove('has-error');
      }
    }

    // Close modal function
    function closeModal(modal) {
      if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
          modal.style.display = 'none';
        }, 300); // Match transition time in CSS
      }
    }

    // Close buttons and background click handling
    document.addEventListener('click', function(event) {
      // Close button handling
      if (event.target.classList.contains('close-btn')) {
        const modal = event.target.closest('.modal');
        if (modal) closeModal(modal);
      }

      // Background click handling
      if (event.target.classList.contains('modal')) {
        closeModal(event.target);
      }
    });
  });
</script>
<style>
  /*--------------------------------------------------------------
# EMPLOYEE MODAL STYLES
--------------------------------------------------------------*/
  .employee-modal-container {
    width: 100%;
  }

  .employee-table-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: var(--card-shadow);
    border: 2px solid var(--border-color);
    background-color: rgba(255, 255, 255, 0.05);
  }

  .employee-card {
    background: var(--card-gradient);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: var(--card-shadow);
    border: 1px solid var(--border-color);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .employee-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .employee-details {
    flex: 1;
  }

  .employee-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-color);
  }

  .employee-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 20px;
    font-size: 0.9rem;
    color: var(--text-muted);
  }

  .employee-meta div {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .employee-meta i {
    color: var(--accent-color);
    font-size: 1rem;
  }

  @media (max-width: 768px) {
    .employee-card {
      flex-direction: column;
      align-items: flex-start;
      padding: 15px;
    }

    .employee-meta {
      flex-direction: column;
      gap: 5px;
    }
  }

  /* Enhanced form validation styles for employees */
  #editEmployeeForm .has-error input,
  #editEmployeeForm .has-error select,
  #addEmployeeForm .has-error input,
  #addEmployeeForm .has-error select {
    border-color: var(--danger-color);
    background-color: rgba(255, 71, 87, 0.05);
  }

  #editEmployeeForm .has-error label,
  #addEmployeeForm .has-error label {
    color: var(--danger-color);
  }
</style>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>
<script src="<?php echo URLROOT; ?>/public/js/shopkeeper/employee-filters.js"></script>