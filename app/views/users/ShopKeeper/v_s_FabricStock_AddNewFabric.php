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
      background-image: url('scissors-1008908_1280 1.png'); /* Replace with actual background URL */
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
    
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: url('background-image.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.fabric-stock-container {
    text-align: center;
    padding: 30px;
}

.fabric-stock-container h2 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 20px;
    background: rgba(0, 0, 0, 0.5);
    padding: 10px;
    border-radius: 5px;
    display: inline-block;
}

.form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    width: 350px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.upload-section {
    margin-bottom: 20px;
    text-align: center;
}

.upload-icon {
    font-size: 40px;
    color: #666;
}

.upload-text {
    display: block;
    margin-top: 10px;
    color: #6c63ff;
    text-decoration: none;
    font-weight: bold;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
}

.color-options {
    display: flex;
    gap: 10px;
    margin-top: 8px;
}

.color-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
}

.color-circle.black { background-color: #000; }
.color-circle.red { background-color: #ff4d4d; }
.color-circle.blue { background-color: #4d79ff; }
.color-circle.purple { background-color: #cc66ff; }
.color-circle.orange { background-color: #ffb84d; }
.color-circle.yellow { background-color: #ffff66; }

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #6c63ff;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.submit-btn:hover {
    background-color: #5a53cc;
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
    <div class="sidebar-icon "><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon Active-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section Active-icon">Fabrics</a></h1>
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
          <label for="fabric-name">Fabric Name</label>
          <input type="text" id="fabric-name" placeholder="Enter Fabric name">
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="text" id="price" placeholder="Enter Price">
        </div>
        <div class="form-group">
          <label for="color">Color</label>
          <div class="color-options">
            <span class="color-circle black"></span>
            <span class="color-circle red"></span>
            <span class="color-circle blue"></span>
            <span class="color-circle purple"></span>
            <span class="color-circle orange"></span>
            <span class="color-circle yellow"></span>
          </div>
        </div>
        <div class="form-group">
          <label for="stock">Stock</label>
          <input type="text" id="stock" placeholder="Enter Quantity">
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
    
           
</body>
</html>
