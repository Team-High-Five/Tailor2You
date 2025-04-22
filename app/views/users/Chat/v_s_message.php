<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="messages-container">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/chat/message.css">
  <!-- Sidebar -->
  <div class="message-sidebar">
    <div class="message-sidebar-header">
      <i class="fas fa-envelope message-icon"></i>
      <span class="message-title">Messages</span>
    </div>
    <a href="<?php echo URLROOT ?>/Chat/messageGroup" class="message-link">
      <ul class="conversation-list">
        <li class="conversation-item">
          <img class="user-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="User Profile Picture">
          <span class="user-details">
            <span class="user-name">Customer 1</span>
            <span class="message-date">11/23</span>
          </span>
          <span class="unread-badge">2</span>
        </li>
    </a>
    <li class="conversation-item">
      <img class="user-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="User Profile Picture">
      <span class="user-details">
        <span class="user-name">Tailor 1</span>
        <span class="message-date">08/05</span>
      </span>
    </li>
    <li class="conversation-item">
      <img class="user-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="User Profile Picture">
      <span class="user-details">
        <span class="user-name">Group 1</span>
        <span class="message-date">2023/08/05</span>
      </span>
    </li>
    <li class="conversation-item">
      <img class="user-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="User Profile Picture">
      <span class="user-details">
        <span class="user-name">Customer 2</span>
        <span class="message-date">2021/06/08</span>
      </span>
    </li>
    </ul>
  </div>

  <!-- Message Display Section -->
  <div class="message-display">
    <div class="empty-message">
      <span><i class="fas fa-envelope message-icon"></i></span>
      <p>Once you start a new conversation, you'll see it listed here</p>
    </div>
  </div>
</div>