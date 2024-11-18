<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="stats">
  <div class="card orders-card">
    <div><img src="../<?php APPROOT ?>/public/img/order.png" alt="order"></div>
    <h3>Total Orders</h3>
    <p>10,293</p>
    <span>1.3% Up from past week</span>
  </div>
  <div class="card sales-card">
    <div><img src="../<?php APPROOT ?>/public/img/Sales.png" alt="sales"></div>
    <h3>Total Sales</h3>
    <p>$89,000</p>
    <span>4.3% Down from yesterday</span>
  </div>
  <div class="card appointments-card">
    <div><img src="../<?php APPROOT ?>/public/img/appointment.png" alt="appointment"></div>
    <h3>Total Appointments</h3>
    <p>2,040</p>
    <span>1.8% Up from yesterday</span>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>