<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
    <!-- Form container -->
    <div class="form-container">

      <!-- Profile Form -->
      <div class="form">
        <div class="profile-pic">
          <label for="upload-photo">
              <img src="../<?php APPROOT?>/public/img/Add_Image.png" alt="Profile Picture" id="profile-preview">
          </label>
          <input type="file" id="upload-photo" accept="image/*" style="display: none;">
          <div>
              <strong>User ID:</strong> XXX
          </div>
      </div>
      
          <div>
              <label>First Name</label>
              <input type="text" placeholder="First Name">
          </div>
          <div>
              <label>Last Name</label>
              <input type="text" placeholder="Last Name">
          </div>
          <div>
              <label>Email Address</label>
              <input type="email" placeholder="Email Address">
          </div>
          <div>
              <label>Phone Number</label>
              <input type="text" placeholder="Phone Number">
          </div>
          <div>
              <label>NIC Number</label>
              <input type="number" placeholder="NIC Number">
          </div>
          <div>
              <label>Birth Date</label>
              <input type="date">
          </div>
          <div>
              <label>Home Town</label>
              <input type="text" placeholder="Home Town">
          </div>
          <div>
              <label>Bio</label>
              <textarea placeholder="Bio"></textarea>
          </div>
          <div class="radio-group">
              <label>Category:</label>
              <label><input type="radio" name="category"> Gents</label>
              <label><input type="radio" name="category"> Ladies</label>
              <label><input type="radio" name="category"> Both</label>
          </div>
          <div class="buttons">
              <button class="submit-btn">Submit</button>
              <button class="reset-btn">Reset</button>
          </div>
      </div>
  </div>
</div>
    
</body>
</html>
