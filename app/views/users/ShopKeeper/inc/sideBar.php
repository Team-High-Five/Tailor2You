<?php

function isCurrentPage($page)
{
  // Get the current URL path
  $currentUrl = $_SERVER['REQUEST_URI'];
  // Check if the page name exists in the current URL
  return strpos($currentUrl, $page) !== false;
}
?>

<div class="sidebar">
  <a href="#">
    <img src="../<?php APPROOT ?>/public/img/logo.png" alt="Logo" />
  </a>
  <div id="Dashboard" class="sidebar-icon <?php echo isCurrentPage('index') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/index">
      <img src="../<?php APPROOT ?>/public/img/Home.png">
    </a>
  </div>
  <div id="Profile" class="sidebar-icon <?php echo isCurrentPage('profileUpdate') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/profileUpdate">
      <img src="../<?php APPROOT ?>/public/img/Customer.png">
    </a>
  </div>
  <div id="Orders" class="sidebar-icon <?php echo isCurrentPage('displayOrders') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/displayOrders">
      <img src="../<?php APPROOT ?>/public/img/Purchase_Order.png">
    </a>
  </div>
  <div id="Appointments" class="sidebar-icon <?php echo isCurrentPage('displayAppointments') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/displayAppointments">
      <img src="../<?php APPROOT ?>/public/img/Calendar.png">
    </a>
  </div>
  <div id="Customizations" class="sidebar-icon">
    <a href="<?php echo URLROOT ?>/Tailors/displayCustomizeItems">
      <img src="../<?php APPROOT ?>/public/img/Adjust.png">
    </a>
  </div>
  <div id="Inventory" class="sidebar-icon <?php echo isCurrentPage('displayFabricStock') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/displayFabricStock">
      <img src="../<?php APPROOT ?>/public/img/Shopping_bag.png">
    </a>
  </div>
  <div id="Employee" class="sidebar-icon <?php echo isCurrentPage('displayEmployee') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/displayEmployee">
      <img src="../<?php APPROOT ?>/public/img/employee.png">
    </a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarIcons = document.querySelectorAll('.sidebar-icon');

    // Handle click events
    sidebarIcons.forEach(icon => {
      icon.addEventListener('click', function(e) {
        // Only handle clicks if there's no link or if the click wasn't on the link
        if (!e.target.closest('a')) {
          // Remove active class from all icons
          sidebarIcons.forEach(icon => icon.classList.remove('active'));
          // Add active class to clicked icon
          this.classList.add('active');
        }
      });
    });

    // Store the last active icon in localStorage when clicking a link
    sidebarIcons.forEach(icon => {
      const link = icon.querySelector('a');
      if (link) {
        link.addEventListener('click', function() {
          localStorage.setItem('lastActiveSidebarIcon', icon.id);
        });
      }
    });

    // Check if we should restore the active state from localStorage
    const lastActiveIcon = localStorage.getItem('lastActiveSidebarIcon');
    if (lastActiveIcon && !document.querySelector('.sidebar-icon.active')) {
      const icon = document.getElementById(lastActiveIcon);
      if (icon) {
        icon.classList.add('active');
      }
    }
  });
</script>