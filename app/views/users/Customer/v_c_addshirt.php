<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>
<div class="passcontainer">
    <main class="main-content">
      <section class="content">
        <h2>Shirt Measurement</h2>
        <form class="change-form">
          <label for="Length">Length</label>
          <input type="text" id="Length" placeholder="C104">

          <label for="Calf">Calf</label>
          <input type="text" id="Calf">

          <label for="Waist">Waist</label>
          <input type="text" id="Waist">

          <label for="Seat">Seat</label>
          <input type="text" id="Seat">

          <label for="Shoulder">Shoulder</label>
          <input type="text" id="Shoulder">

          <label for="Neck">Neck</label>
          <input type="text" id="Neck">

          <label for="Sleeve">Sleeve</label>
          <input type="text" id="Sleeve">

          <label for="Sleeve Circumstance">Sleeve Circumstance</label>
          <input type="text" id="Sleeve Circumstance">

          <button type="submit" class="btn-save">Save Changes</button>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
