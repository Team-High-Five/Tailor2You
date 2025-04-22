<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="messages-container">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/chat/message.css">
  
  <!-- Sidebar -->
  <div class="message-sidebar">
    <div class="message-sidebar-header">
      <i class="fas fa-envelope message-icon" id="messageIcon"></i>
      <span class="message-title">Messages</span>
    </div>
    <ul class="conversation-list">
      <li class="conversation-item">
        <img class="user-icon" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="User Profile Picture">
        <div class="user-details">
          <span class="user-name">Customer 1</span>
          <span class="message-date">11/23</span>
        </div>
        <span class="unread-badge">2</span>
      </li>
      <!-- Add more conversation items dynamically -->
    </ul>
  </div>

  <!-- Chat Box -->
  <div class="message-display">
    <div class="messages" id="chatMessages">
      <!-- Messages will be dynamically loaded here -->
    </div>
    <div class="message-input">
      <input type="text" id="messageText" placeholder="Type a message..." />
      <button id="sendMessageBtn">Send</button>
    </div>
  </div>
</div>
<!-- Create Group Button -->
<button class="create-group-btn" id="openGroupModal">
      <i class="fas fa-users"></i> Create Group
    </button>

<!-- Group Creation Modal -->
<div class="modal" id="groupModal" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Create a Group</h3>
      <span class="close-modal" id="closeGroupModal">&times;</span>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label for="groupName">Group Name</label>
        <input type="text" id="groupName" placeholder="Enter group name">
      </div>
      <div class="form-group">
        <label for="groupDescription">Description</label>
        <textarea id="groupDescription" placeholder="Enter group description"></textarea>
      </div>
      <div class="form-group">
        <label for="groupPrivacy">Privacy</label>
        <select id="groupPrivacy">
          <option value="public">Public</option>
          <option value="private">Private</option>
        </select>
      </div>
    </div>
    <div class="modal-footer">
      <button class="create-btn">Create Group</button>
    </div>
  </div>
</div>

<script>
  // Open and Close Modal
  const openGroupModal = document.getElementById('openGroupModal');
  const closeGroupModal = document.getElementById('closeGroupModal');
  const groupModal = document.getElementById('groupModal');

  // Show the modal when the "Create Group" button is clicked
  openGroupModal.addEventListener('click', () => {
    groupModal.style.display = 'block';
  });

  // Hide the modal when the close button is clicked
  closeGroupModal.addEventListener('click', () => {
    groupModal.style.display = 'none';
  });

  // Hide the modal when clicking outside the modal content
  window.addEventListener('click', (event) => {
    if (event.target === groupModal) {
      groupModal.style.display = 'none';
    }
  });

  // Chat Functionality
  const sendMessageBtn = document.getElementById('sendMessageBtn');
  const messageText = document.getElementById('messageText');
  const messagesContainer = document.getElementById('chatMessages');

  // Send a message
  sendMessageBtn.addEventListener('click', () => {
    const message = messageText.value.trim();
    if (message) {
      // Append the message to the chat display
      const messageElement = document.createElement('div');
      messageElement.classList.add('message');
      messageElement.textContent = message;
      messagesContainer.appendChild(messageElement);

      // Clear the input field
      messageText.value = '';

      // Send the message to the server (AJAX request)
      fetch('<?php echo URLROOT; ?>/chat/sendMessage', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message }),
      })
        .then(response => response.json())
        .then(data => {
          console.log('Message sent:', data);
        })
        .catch(error => {
          console.error('Error sending message:', error);
        });
    }
  });

  // Load messages dynamically
  function loadMessages() {
    fetch('<?php echo URLROOT; ?>/chat/getMessages')
      .then(response => response.json())
      .then(data => {
        messagesContainer.innerHTML = ''; // Clear existing messages
        data.messages.forEach(msg => {
          const messageElement = document.createElement('div');
          messageElement.classList.add('message');
          messageElement.textContent = msg.text;
          messagesContainer.appendChild(messageElement);
        });
      })
      .catch(error => {
        console.error('Error loading messages:', error);
      });
  }

  // Load messages on page load
  loadMessages();

  const messageIcon = document.getElementById('messageIcon');
  const chatBox = document.querySelector('.message-display');

  // Toggle the chat box visibility
  messageIcon.addEventListener('click', () => {
    if (chatBox.style.display === 'none' || chatBox.style.display === '') {
      chatBox.style.display = 'block'; // Show the chat box
    } else {
      chatBox.style.display = 'none'; // Hide the chat box
    }
  });
</script>

<div class="messages-container" id="chatBox" style="display: none;">
  <?php require_once APPROOT . '/views/users/Chat/v_s_message_group.php'; ?>
</div>

<div class="chat-container">
  <!-- Sidebar -->
  <div class="chat-sidebar">
    <div class="sidebar-header">
      <h2>Chats</h2>
      <input type="text" placeholder="Search messages..." class="search-bar">
    </div>
  </div>
</div>
