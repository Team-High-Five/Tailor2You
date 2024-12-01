<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>


  <div class="add-new-fabric-container">
    <div class="add-new-fabric-content">
      <div class="modal-header">
        <h1>Add New Employee</h1>
        <a href="<?php echo URLROOT ?>/Shopkeepers/displayEmployees"><button class="close-btn">&times;</button></a>
      </div>
      <div class="fabric-form-container">
        <form id="addEmployeeForm" action="<?php echo URLROOT; ?>/Shopkeepers/addNewEmployee" method="post" enctype="multipart/form-data">

          <div class="post-pic-wrapper">
            <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
          </div>
          <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
          <span class="error-message" id="image-error"></span>
          <div class="form-group">
            <label for="employee-name">Employee Name</label>
            <input type="text" id="employee-name" name="employee_name" placeholder="Enter Employee name" required>
            <span class="error-message" id="employee-name-error"></span>
          </div>
          <div class="form-group">
            <label for="phone-number">Phone Number</label>
            <input type="text" id="phone-number" name="phone_number" placeholder="Enter Phone Number" required>
            <span class="error-message" id="phone-number-error"></span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter Email" required>
            <span class="error-message" id="email-error"></span>
          </div>
          <div class="form-group">
            <label for="home-town">Home Town</label>
            <input type="text" id="home-town" name="home_town" placeholder="Enter Home Town" required>
            <span class="error-message" id="home-town-error"></span>
          </div>
          <button type="submit" class="submit-btn">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('post-preview').addEventListener('click', function() {
      document.getElementById('upload-photo').click();
    });

    document.getElementById('upload-photo').addEventListener('change', function(event) {
      const reader = new FileReader();
      reader.onload = function() {
        const output = document.getElementById('post-preview');
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    });
  </script>
</body>

</html>