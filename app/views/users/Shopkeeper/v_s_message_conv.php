<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tailor2You</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    /* Messages Container */
    .messages-container {
      display: flex;
      width: 100vw;
      height: 100vh;
      background-color: #f8f9fc;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 30%;
      background: #ffffff;
      border-right: 1px solid #ddd;
      padding: 1rem;
    }

    .sidebar-header {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .conversation-list {
      list-style: none;
    }

    .conversation-item {
      display: flex;
      align-items: center;
      padding: 0.8rem;
      border-bottom: 1px solid #f0f0f0;
      cursor: pointer;
    }

    .conversation-item:hover {
      background-color: #f5f5f5;
    }

    /* User Icon */
    .user-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
      background-color: #ccc;
    }

    .user1 { background-color: #6c5ce7; }
    .user2 { background-color: #e17055; }
    .user3 { background-color: #00cec9; }
    .user4 { background-color: #fdcb6e; }

    /* User Details */
    .user-details {
      flex-grow: 1;
    }

    .user-name {
      font-size: 1rem;
      font-weight: 500;
    }

    .message-date {
      font-size: 0.85rem;
      color: #888;
    }

    /* Unread Badge */
    .unread-badge {
      background-color: #6c5ce7;
      color: #fff;
      font-size: 0.8rem;
      padding: 3px 8px;
      border-radius: 50%;
    }

    /* Message Display Section */
    .message-display {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .empty-message {
      text-align: center;
      color: #bbb;
    }
    .message-header {
      display: flex;
      align-items: center;
      gap: 8px; /* Adjust spacing between icon and text */
    }

    .message-icon {
      width: 20px; /* Set desired size */
      height: 20px;
    }
    .message-title {
    font-size: 16px;
    font-weight: bold;
    }
    .chat-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: #fff;
    }
    .chat-header {
  padding: 15px;
  background: #f1f1f1;
  border-bottom: 1px solid #ddd;
    }
    .chat-messages {
  flex: 1;
  padding: 15px;
  overflow-y: auto;
}

.message {
  margin-bottom: 15px;
}

.message-user {
  font-weight: bold;
  margin-bottom: 5px;
}

.message-content {
  background: #f8f9fa;
  padding: 10px;
  border-radius: 5px;
}

.chat-input {
  display: flex;
  padding: 10px;
  border-top: 1px solid #ddd;
}

.chat-input input {
  flex: 1;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
}

.chat-input button {
  background: #007bff;
  color: white;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
}

.chat-input button:hover {
  background: #0056b3;
}
  </style>
</head>
<body>
  <div class="messages-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="message-header">
        <img src="message.png" alt="Message Icon" class="message-icon">
        <span class="message-title">Messages</span>
      </div>
      <ul class="conversation-list">
        <li class="conversation-item">
            <img class="user-icon" src="young man thinking.png" alt="User Profile Picture">
        <span class="user-details">
            <span class="user-name">Customer 1</span>
            <span class="message-date">11/23</span>
          </span>
          <span class="unread-badge">2</span>
        </li>
        <li class="conversation-item">
            <img class="user-icon" src="thinking man torso.png" alt="User Profile Picture">
          <span class="user-details">
            <span class="user-name">Tailor 1</span>
            <span class="message-date">08/05</span>
          </span>
        </li>
        <li class="conversation-item">
            <img class="user-icon" src="Group 263.png" alt="User Profile Picture">
          <span class="user-details">
            <span class="user-name">Group 1</span>
            <span class="message-date">2023/08/05</span>
          </span>
        </li>
        <li class="conversation-item">
            <img class="user-icon" src="man in red shirt torso.png" alt="User Profile Picture">
          <span class="user-details">
            <span class="user-name">Customer 2</span>
            <span class="message-date">2021/06/08</span>
          </span>
        </li>
      </ul>
    </div>

    <!-- Message Display Section -->
    <div class="chat-main">
        
        <div class="chat-header">
            <img src="Group 263.png" >
            <span class="message-title">Group 1</span>
          </div>
        <div class="chat-messages">
          <div class="message">
            <img class="user-icon" src="thinking man torso.png" alt="User Profile Picture">
            <span class="user-details">
                <span class="message-user">Tailor 1</span>
            <div class="message-content">
              <audio controls>
                <source src="audio.mp3" type="audio/mpeg">
              </audio>
              <div></div>
              We are available every weekday from 8 AM to 5 PM
            </div>
          </div>
          <div class="message">
            <img class="user-icon" src="young woman talking.png" alt="User Profile Picture">
            <span class="user-details">
                <span class="message-user">Shopkeeper 1</span>
            <div class="message-content">
              What color would you like to have?
              <form>
                <label><input type="radio" name="color"> Green</label><br>
                <label><input type="radio" name="color"> Ash</label><br>
                <label><input type="radio" name="color"> Red</label>
              </form>
            </div>
          </div>
          <div class="message">
            <img class="user-icon" src="young man thinking.png" alt="User Profile Picture">
            <span class="user-details">
                <span class="message-user">Customer 1</span>

            <div class="message-content">
              My favorite color is Ash. <br> I found this color attractive.
            </div>
          </div>
        </div>
        <div class="chat-input">
          <input type="text" placeholder="Message #team-chat">
          <button>Send</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>