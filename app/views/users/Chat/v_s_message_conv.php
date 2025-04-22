<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tailor2You</title>

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
