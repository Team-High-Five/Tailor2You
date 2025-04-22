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
        <!-- Updated message icon -->
        <button class="icon-button" id="messageIcon"><i class="fas fa-envelope"></i></button>
        <button class="icon-button"><i class="fas fa-bell"></i></button>
        <div class="dropdown">
          <button class="tailor-drop-down"><i class="fas fa-sign-out-alt"></i></button>
          <div class="dropdown-content">
            <a href="<?php echo URLROOT; ?>/Users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
        </div>
      </div>
      <a href="<?php echo URLROOT ?>/Customers/profileUpdate">
        <div class="user-info">
          <span>
            <?php if (isset($_SESSION['user_first_name'])): ?>
              <?php echo $_SESSION['user_first_name']; ?>
            <?php else: ?>
              Guest
            <?php endif; ?>
          </span>
          <?php if (!empty($_SESSION['user_profile_pic'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['user_profile_pic']); ?>" alt="User Avatar">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/Avatar.png" alt="User Avatar">
          <?php endif; ?>
        </div>
      </a>
    </div>
  </div>
</div>

<!-- Include the chat box -->
<div class="messages-container" id="chatBox" style="display: none;">
  <?php require_once APPROOT . '/views/users/Chat/v_s_message_group.php'; ?>
</div>
