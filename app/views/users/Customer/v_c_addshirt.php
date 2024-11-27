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
          <input type="text" id="Length" placeholder="cm">

          <label for="Calf">Calf</label>
          <input type="text" id="Calf" placeholder="cm">

          <label for="Waist">Waist</label>
          <input type="text" id="Waist" placeholder="cm">

          <label for="Seat">Seat</label>
          <input type="text" id="Seat" placeholder="cm">

          <label for="Shoulder">Shoulder</label>
          <input type="text" id="Shoulder" placeholder="cm">

          <label for="Neck">Neck</label>
          <input type="text" id="Neck" placeholder="cm">

          <label for="Sleeve">Sleeve</label>
          <input type="text" id="Sleeve" placeholder="cm">

          <label for="Sleeve Circumstance">Sleeve Circumstance</label>
          <input type="text" id="Sleeve Circumstance" placeholder="cm">

          <button type="submit" class="btn-save">Save Changes</button>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
