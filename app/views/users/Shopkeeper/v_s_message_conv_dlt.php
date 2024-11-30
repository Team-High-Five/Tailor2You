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
      display: flex;
      width: 600px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    /* Sidebar Styling */
    .sidebar {
      width: 80px;
      background-color: #6C63FF; /* Purple */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-radius: 8px 0 0 8px;
      color: #fff;
    }

    .sidebar-icon {
      font-size: 24px;
      margin-bottom: 20px;
      cursor: pointer;
    }

    /* Content Section */
    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .header {
      padding: 16px;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      align-items: center;
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

    .message {
      padding: 20px;
      color: #555;
      font-size: 16px;
      text-align: center;
    }

    .footer {
      display: flex;
      justify-content: flex-end;
      padding: 16px;
      border-top: 1px solid #eee;
    }

    .delete-btn {
      padding: 10px 20px;
      background-color: #6C63FF;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
      background-color: #5a55cc;
    }
  </style>
</head>
<body>
  <div class="container">
    
    <!-- Main Content -->
    <div class="content">
      <!-- Header -->
      <div class="header">
        <div class="header-title">Delete message</div>
        <div class="close-icon">&times;</div>
      </div>

      <!-- Message -->
      <div class="message">
        Are you sure you want to delete this message? This cannot be undone.
      </div>

      <!-- Footer -->
      <div class="footer">
        <button class="delete-btn">Delete</button>
      </div>
    </div>
  </div>
</body>
</html>
