<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>
<div class="passcontainer">
    <main class="main-content">
      <section class="content">
        <h2>Pant Measurement</h2>
        <form class="change-form">
          <label for="Length">Length</label>
          <input type="text" id="Length" placeholder="cm">

          <label for="Calf">Calf</label>
          <input type="text" id="Calf" placeholder="cm">

          <label for="Waist">Waist</label>
          <input type="text" id="Waist" placeholder="cm">

          <label for="Seat">Seat</label>
          <input type="text" id="Seat" placeholder="cm">

          <label for="Bottom">Bottom</label>
          <input type="text" id="Bottom" placeholder="cm">

          <label for="Fly">Fly</label>
          <input type="text" id="Fly" placeholder="cm">

          <button type="submit" class="btn-save">Save Changes</button>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
