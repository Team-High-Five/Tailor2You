<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="messages-container">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/actions/message.css">
  <!-- Sidebar -->
  <div class="message-sidebar">
    <div class="message-sidebar-header">
      <i class="fas fa-envelope message-icon"></i>
      <span class="message-title">Messages</span>
    </div>
    <ul class="conversation-list" id="conversation-list">
      <!-- Conversations will be dynamically loaded here -->
      <li class="conversation-item">
        <img class="user-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="User Profile Picture">
        <span class="user-details">
          <span class="user-name">Customer 1</span>
          <span class="message-date">11/23</span>
        </span>
        <span class="unread-badge">2</span>
      </li>
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
    <div class="chat-messages" id="chat-messages">
      <!-- Messages will be dynamically loaded here -->
    </div>
    <div class="chat-input">
      <input type="text" id="message-input" placeholder="Type a message">
      <button id="send-button">Send</button>
    </div>
  </div>
</div>

<script>
  const ws = new WebSocket('ws://localhost:8080');

  ws.onmessage = function(event) {
    const chatMessages = document.getElementById('chat-messages');
    const messageElement = document.createElement('div');
    messageElement.classList.add('message');
    messageElement.innerHTML = `
      <span class="user-details">
        <div class="message-content">${event.data}</div>
      </span>
    `;
    chatMessages.appendChild(messageElement);
  };

  document.getElementById('send-button').addEventListener('click', function() {
    const messageInput = document.getElementById('message-input');
    ws.send(messageInput.value);
    messageInput.value = '';
  });
</script>