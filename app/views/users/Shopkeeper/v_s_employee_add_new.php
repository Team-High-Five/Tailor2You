<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Employee</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color: #f0f0f0;
      color: #333;
    }

    .sidebar {
      width: 80px;
      min-height: 100vh;
      background-color: #7a57d1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0;
      color: white;
      justify-content: space-around;
    }

    .sidebar img {
      width: 40px;
      margin-bottom: 5px;
      cursor: pointer;
    }

    .sidebar-icon {
      font-size: 24px;
      margin: 20px 0;
      cursor: pointer;
      color: #ffffff;
      padding: 10px;
      border-radius: 8px;
      transition: background-color 0.3s, color 0.3s;
    }
    
    .sidebar-icon:hover {
      background-color: rgba(255, 255, 255, 0.2);
      color: #fff;
      cursor: pointer;
    }

    .Active-icon {
      background-color: black;
      padding: 10px;
      border-radius: 8px;
    }

    .Section-content {
      flex: 1;
      padding: 30px;
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(8px);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }

    .header h2 {
      font-size: 2rem;
    }

    .header .search-bar {
      position: relative;
      width: 250px;
      display: flex;
    }

    .header .search-bar input {
      width: 100%;
      padding: 8px 10px;
      border-radius: 20px;
      border: 1px solid #ccc;
      outline: none;
    }

    .header .search-bar button {
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      font-size: 18px;
      color: #888;
    }

    .header .actions {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .header .actions button {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 18px;
      color: #555;
    }

    .header .actions .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .header .actions .user-info img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }

    .form-container {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 0 auto;
    }

    .upload-section {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .upload-icon {
      font-size: 24px;
    }

    .upload-text {
      color: #6a1b9a;
      text-decoration: none;
      font-weight: bold;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
    }

    .submit-btn {
      background-color: #6a1b9a;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      display: block;
      width: 100%;
      font-size: 16px;
    }

    .Section {
      font-size: 24px;
      font-weight: bold;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      transition: background-color 0.3s;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <a href="#">
      <img src="tailor house (3) 2.png" alt="Logo" />
    </a>
    <div class="sidebar-icon"><img src="Home.png"></div>
    <div class="sidebar-icon"><img src="Customer.png"></div>
    <div class="sidebar-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
    <div class="sidebar-icon Active-icon"><img src="Untitled design.png"></div>
  </div>
  <div class="Section-content">
    <div class="header">
      <div class="actions">
        <h1><a href="#" class="Section Active-icon">Employee</a></h1>
      </div>
      <div class="actions">
        <div class="search-bar">
          <input type="text" placeholder="Type to search">
          <button><i><img src="Search.png"></i></button>
        </div>
        <button><i><img src="Icon.png"></i></button>
        <button><i><img src="Icon-1.png"></i></button>
        <div class="user-info">
          <span>Title</span>
          <img src="Avatar.png" alt="User Avatar">
        </div>
      </div>
    </div>
    
    <div class="form-container">
      <div class="upload-section">
        <div class="upload-icon">📷</div>
        <a href="#" class="upload-text">Upload Photo</a>
      </div>
      <form>
        <div class="form-group">
          <label for="employee-name">Employee Name</label>
          <input type="text" id="employee-name" placeholder="Enter Employee name">
        </div>
        <div class="form-group">
          <label for="phone-number">Phone Number</label>
          <input type="text" id="phone-number" placeholder="Enter Phone Number">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" id="email" placeholder="Enter Email">
        </div>
        <div class="form-group">
          <label for="home-town">Home Town</label>
          <input type="text" id="home-town" placeholder="Enter Home Town">
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>