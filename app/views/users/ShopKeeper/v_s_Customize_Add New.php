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
      background-image: url('needle-932344_12804 1.png'); /* Replace with actual background URL */
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
    .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            position: relative;
        }
        .card h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        select, input[type="radio"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .radio-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .continue-btn {
            background-color: #6a0dad;
            color: #fff;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .continue-btn:hover {
            background-color: #5a0dac;
        }

  </style>
</head>
<body>
  <div class="sidebar">
    <a href="#">
      <img src="tailor house (3) 2.png" alt="Logo" />
    </a>
    <div class="sidebar-icon "> <img src="Home.png"></div>
    <div class="sidebar-icon"><img src="Customer.png"></div>
    <div class="sidebar-icon  "><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon Active-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section Active-icon">Customize</a></h1>
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
    
     <div class="card">
        <button class="close-btn">&times;</button>
        <h2>Customize</h2>
        <div class="form-group">
            <label>Gender</label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="gents"> Gents</label>
                <label><input type="radio" name="gender" value="ladies"> Ladies</label>
            </div>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category">
                <option>Category</option>
                <option>Shirts</option>
                <option>Trousers</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sub-category">Sub Category</label>
            <select id="sub-category">
                <option>Sub Category</option>
                <option>Formal</option>
                <option>Casual</option>
            </select>
        </div>
        <button class="continue-btn">Continue</button>
    </div></div>
    
        
    
       
</body>
</html>
