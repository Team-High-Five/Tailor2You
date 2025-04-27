<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div class="Section-content">
  <div class="header">
    <h1 class="main-title"><?php echo $data['title']; ?></h1>
    <div class="navbar-right-section">
      <div class="actions">
        <div class="search-bar">
          <input type="text" placeholder="Type to search">
          <button><i><img src="<?php echo URLROOT; ?>/public/img/Search.png"></i></button>
        </div>
        <a href="<?php echo URLROOT; ?>/Chat/index">
          <button class="icon-button">
            <i class="fas fa-envelope"></i>
          </button>
        </a>
        <div class="notification-dropdown">
          <button id="notificationBtn" class="icon-button">
            <i class="fas fa-bell"></i>
            <span id="notificationBadge" class="notification-badge"></span>
          </button>
          <div id="notificationDropdown" class="notification-dropdown-content">
            <div class="notification-header">
              <h3>Notifications</h3>
              <button id="markAllReadBtn" class="mark-all-read">Mark all as read</button>
            </div>
            <div id="notificationList" class="notification-list">
              <div class="notification-loading">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Loading notifications...</p>
              </div>
            </div>
            <div class="notification-footer">
              <a href="<?php echo URLROOT; ?>/Tailors/displayAppointments">View All Appointments</a>
            </div>
          </div>
        </div>
        <div class="dropdown">
          <button class="tailor-drop-down"><i class="fas fa-sign-out-alt"></i></button>
          <div class="dropdown-content">
            <a href="<?php echo URLROOT; ?>/Users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
        </div>
      </div>
      <a href="<?php echo URLROOT ?>/Tailors/profileUpdate">
        <div class="user-info">
          <span>
            <?php if (isset($_SESSION['user_first_name'])): ?>
              <?php echo $_SESSION['user_first_name']; ?>
            <?php else: ?>
              Guest
            <?php endif; ?>
          </span>
          <?php if (!empty($_SESSION['user_profile_pic'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['user_profile_pic']); ?>"
              alt="User Avatar">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/Avatar.png" alt="User Avatar">
          <?php endif; ?>
        </div>
      </a>
    </div>
  </div>
  <script>
    const URLROOT = '<?php echo URLROOT; ?>';
  </script>
  <script src='<?php echo URLROOT; ?>/public/js/tailor/tailor-notification.js'></script>
  <script src='<?php echo URLROOT; ?>/public/js/tailor/flash-msg.js'></script>