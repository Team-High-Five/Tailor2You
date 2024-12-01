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

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f5f5f5;
    }

    .container {
      width: 400px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      padding: 20px;
    }

    /* Header Section */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .header-title {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .close-icon {
      font-size: 18px;
      cursor: pointer;
    }

    /* Description */
    .description {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }

    /* Form Fields */
    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      font-size: 14px;
      color: #333;
      display: block;
      margin-bottom: 5px;
    }

    .form-group input[type="text"] {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    /* Toggle Section */
    .toggle-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .toggle-section label {
      font-size: 14px;
      color: #555;
    }

    .toggle-switch {
      position: relative;
      width: 40px;
      height: 20px;
      background-color: #ccc;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .toggle-switch::before {
      content: '';
      position: absolute;
      top: 2px;
      left: 2px;
      width: 16px;
      height: 16px;
      background-color: #fff;
      border-radius: 50%;
      transition: transform 0.3s ease;
    }

    .toggle-switch.active {
      background-color: #6C63FF;
    }

    .toggle-switch.active::before {
      transform: translateX(20px);
    }

    /* Button */
    .button-container {
      text-align: right;
    }

    .create-btn {
      padding: 10px 20px;
      background-color: #6C63FF;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .create-btn:hover {
      background-color: #5a55cc;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="header">
      <div class="header-title">Create a Group</div>
      <div class="close-icon">&times;</div>
    </div>

    <!-- Description -->
    <div class="description">
      # team-chat
    </div>

    <!-- Form -->
    <div class="form-group">
      
    </div>

    <div class="form-group">
      <label for="description">Only admins</label>
      <input type="text" id="description" placeholder="Enter a name or email">
    </div>

    <!-- Toggle Section -->
    <div class="toggle-section">
      <label for="make-private">Automatically add anyone who joins</label>
      <div class="toggle-switch" id="toggle"></div>
    </div>

    <!-- Button -->
    <div class="button-container">
      <button class="create-btn">Done</button>
    </div>
  </div>

  <script>
    // Toggle Switch Functionality
    const toggle = document.getElementById('toggle');
    toggle.addEventListener('click', () => {
      toggle.classList.toggle('active');
    });
  </script>
</body>
</html>
