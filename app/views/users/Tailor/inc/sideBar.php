<div class="sidebar">
  <a href="#">
    <img src="../<?php APPROOT?>/public/img/logo.png" alt="Logo" />
  </a>
  <div id="home" class="sidebar-icon <?php echo ($currentPage == 'home') ? 'active' : ''; ?>">
  <a href="<?php echo URLROOT ?>/Tailors/index">
    <img src="../<?php APPROOT?>/public/img/Home.png">
  </a>
</div>
  <div id="customer" class="sidebar-icon"><a href="<?php echo URLROOT ?>/Tailors/profileUpdate"><img src="../<?php APPROOT?>/public/img/Customer.png"></a></div>
  <div id="purchase-order" class="sidebar-icon"><a href="<?php echo URLROOT ?>/Tailors/displayOrders"><img src="../<?php APPROOT?>/public/img/Purchase_Order.png"></a></div>
  <div id="calendar" class="sidebar-icon"><img src="../<?php APPROOT?>/public/img/Calendar.png"></div>
  <div id="adjust" class="sidebar-icon"><img src="../<?php APPROOT?>/public/img/Adjust.png"></div>
  <div id="shopping-bag" class="sidebar-icon"><a href="<?php echo URLROOT ?>/Tailors/displayFabricStock"><img src="../<?php APPROOT?>/public/img/Shopping_bag.png"></a></div>
  </div>

<script>
document.querySelectorAll('.sidebar-icon').forEach((icon) => {
  icon.addEventListener('click', function () {
    // Remove active class from all icons
    document.querySelectorAll('.sidebar-icon').forEach((icon) => {
      icon.classList.remove('active');
    });

    // Add active class to the clicked icon
    this.classList.add('active');
  });
});
</script>
