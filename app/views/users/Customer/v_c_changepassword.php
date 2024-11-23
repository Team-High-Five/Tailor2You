<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>
  <div class="passcontainer">
    <main class="main-content">
      <section class="content">
        <h2>Change Password</h2>
        <form class="change-form">

          <label for="current-password">Current Password</label>
          <input type="password" id="current-password">

          <label for="new-password">New Password</label>
          <input type="password" id="new-password">

          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirm-password">

          <button type="submit" class="btn-save">Save Changes</button>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
