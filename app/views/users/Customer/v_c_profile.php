<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profile_style.css'>

<div class="container">
    <!-- Main Content -->
    <div class="main-content">
      <div class="profile-container">
        <!-- Profile Photo Section -->
        <div class="profile-photo-section">
          <div class="profile-photo"><img src="cus.webp" alt=""></div>
          <div class="input_file_container">
            <label for="update_prof" class="update_prof">Update Profile Photo</label>
          <input type="file" class="input_file">
          </div>
          <div class="upload-button">
            <button>Upload</button>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
   
    <a href="<?php echo URLROOT ?>/Customer/v_c_updateDetails"><button>Update My Details</button></a>
    <button>Delete Account</button>
    <a href="<?php echo URLROOT ?>/Customer/v_c_changepassword"><button>Change Password</button></a>
    <div class="dropdown">
        <button class="dropdown-toggle">Add Measurements</button>
        <div class="dropdown-menu">
            <a href="<?php echo URLROOT ?>/Customer/v_c_addpant">Pant</a>
            <a href="<?php echo URLROOT ?>/Customer/v_c_addshirt">Shirt</a>
        </div>
    </div>
</div>

        <!-- User Details Form -->
        <div class="details-container">
          <!-- Left Section -->
          <div class="left-section">
            <div class="input-group">
              <label for="firstName">First Name</label>
              <input type="text" id="firstName" placeholder="Enter First Name" />
            </div>

            <div class="input-group">
              <label for="email">Email</label>
              <input type="email" id="email" placeholder="Enter Email" />
            </div>
        
            <div class="input-group">
              <label for="nic">NIC</label>
              <input type="text" id="nic" placeholder="Enter NIC" />
            </div>

            <div class="input-group">
              <label for="location">Home Town</label>
              <input type="text" id="location" placeholder="Enter Home Town" />
            </div>
           
          </div>

          <!-- Right Section -->
          <div class="right-section">
            <div class="input-group">
              <label for="lastName">Last Name</label>
              <input type="text" id="lastName" placeholder="Enter Last Name" />
            </div>
            
            <div class="input-group">
              <label for="phoneNumber">Phone Number</label>
              <input type="text" id="phoneNumber" placeholder="Enter Phone Number" />
            </div>
            
            <div class="input-group">
              <label for="dob">DOB</label>
              <input type="date" id="dob" />
            </div>

            <div class="input-group">
              <label for="dob">Address</label>
              <input type="text" id="Address" placeholder="Enter Address" />
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
    
</body>
</html>
