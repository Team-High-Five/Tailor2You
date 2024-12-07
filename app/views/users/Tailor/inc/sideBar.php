<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.15.3/css/all.min.css">
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
  <div id="Protfolio" class="sidebar-icon <?php echo isCurrentPage('displayPortfolio') ? 'active' : ''; ?>">
    <a href="<?php echo URLROOT ?>/Tailors/displayPortfolio">
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
  <div id="DarkModeToggle" class="sidebar-icon">
    <button id="darkModeButton" onclick="toggleDarkMode()" style="background: none; border: none; cursor: pointer; color: var(--white-color); font-size: 16px;">
      Dark Mode
    </button>
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

    // Load saved theme on page load
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      document.documentElement.setAttribute('data-theme', savedTheme);
      document.getElementById('darkModeButton').textContent = savedTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
    }
  });

  // Toggle dark mode
  function toggleDarkMode() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    document.getElementById('darkModeButton').textContent = newTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
    localStorage.setItem('theme', newTheme);
  }
</script>