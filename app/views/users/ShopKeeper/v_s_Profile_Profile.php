<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tailor2You</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh; /* Ensures full viewport height */
      background-image: url('antique-1838324_1280 1.png'); /* Replace with actual background URL */
      background-size: cover; /* Covers full viewport */
      background-position: center;
      background-repeat: no-repeat;
      color: #333;
    }

    /* Sidebar */
    .sidebar {
      width: 80px;
      min-height: 100vh; /* Full viewport height, ensuring it doesn’t fall short */
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

    /* Dashboard Content */
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

     /* Form container styles */
     .form-container {
        flex: 1;
        padding: 20px 40px;
        position: relative;
    }
    .tabs {
        display: flex;
        margin-bottom: 20px;
    }
    
    /* Form styles */
    .form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .form label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }
    .form input[type="text"], .form input[type="email"], .form input[type="date"], .form input[type="number"], .form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }
    .form .profile-pic {
        grid-column: span 2;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .form .profile-pic img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #7f6ca0;
    }
    .form .radio-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .form .radio-group label {
        font-size: 14px;
        color: #333;
    }

    /* Buttons */
    .buttons {
        grid-column: span 2;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    .buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        color: #fff;
    }
    .submit-btn {
        background-color: #7f6ca0;
    }
    .reset-btn {
        background-color: #ccc;
        color: #333;
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

    .Section:hover {
      background-color: rgba(0, 0, 0, 0.6);
    }

    .Active-icon {
      background-color: black;
      padding: 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <a href="#">
      <img src="tailor house (3) 2.png" alt="Logo" />
    </a>
    <div class="sidebar-icon "> <img src="Home.png"></div>
    <div class="sidebar-icon Active-icon"><img src="Customer.png"></div>
    <div class="sidebar-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section Active-icon ">Profile</a></h1>
            <h1><a href="#" class="Section ">Portfolio</a></h1>
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
    <!-- Form container -->
    <div class="form-container">

      <!-- Profile Form -->
      <div class="form">
        <div class="profile-pic">
          <label for="upload-photo">
              <img src="Add Image.png" alt="Profile Picture" id="profile-preview">
          </label>
          <input type="file" id="upload-photo" accept="image/*" style="display: none;">
          <div>
              <strong>User ID:</strong> XXX
          </div>
      </div>
      
          <div>
              <label>First Name</label>
              <input type="text" placeholder="First Name">
          </div>
          <div>
              <label>Last Name</label>
              <input type="text" placeholder="Last Name">
          </div>
          <div>
              <label>Email Address</label>
              <input type="email" placeholder="Email Address">
          </div>
          <div>
              <label>Phone Number</label>
              <input type="text" placeholder="Phone Number">
          </div>
          <div>
              <label>NIC Number</label>
              <input type="number" placeholder="NIC Number">
          </div>
          <div>
              <label>Birth Date</label>
              <input type="date">
          </div>
          <div>
              <label>Home Town</label>
              <input type="text" placeholder="Home Town">
          </div>
          <div>
              <label>Bio</label>
              <textarea placeholder="Bio"></textarea>
          </div>
          <div class="radio-group">
              <label>Category:</label>
              <label><input type="radio" name="category"> Gents</label>
              <label><input type="radio" name="category"> Ladies</label>
              <label><input type="radio" name="category"> Both</label>
          </div>
          <div class="buttons">
              <button class="submit-btn">Submit</button>
              <button class="reset-btn">Reset</button>
          </div>
      </div>
  </div>
</div>
    
</body>
</html>
