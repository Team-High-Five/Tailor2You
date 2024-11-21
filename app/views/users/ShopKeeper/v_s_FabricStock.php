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
    
    /* Content Area */
.content {
  padding: 20px;
}

h1 {
  font-size: 24px;
  color: #333;
  margin-bottom: 10px;
}

.add-fabric-btn {
  background-color: #6a1b9a;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px;
}

/* Table Styling */
.table-container {
  overflow-x: auto;
}

.product-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

.product-table th, .product-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.product-table thead th {
  background-color: #f8f8f8;
  font-weight: bold;
  color: #333;
}

.product-table tbody tr:hover {
  background-color: #f9f9f9;
}

.product-image {
  width: 50px;
  height: 50px;
  border-radius: 8px;
  object-fit: cover;
}

.color-dot {
  display: inline-block;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-right: 5px;
}

.action-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 16px;
  padding: 6px;
}

.edit-btn {
  color: #4CAF50; /* Green for edit */
}

.delete-btn {
  color: #E74C3C; /* Red for delete */
}

.action-btn:hover {
  opacity: 0.7;
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
    <div class="sidebar-icon  Active-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
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
    <div class="content">
        <h1>Fabric Stock</h1>
        <button class="add-fabric-btn">Add New Fabric</button>
  
        <div class="table-container">
          <table class="product-table">
            <thead>
              <tr>
                <th>Image</th>
                <th>Fabric Name</th>
                <th>Fabric Id</th>
                <th>Price</th>
                <th>Stock(m)</th>
                <th>Available Color</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><img src="Image.png" alt="Linen" class="product-image"></td>
                <td>Linen</td>
                <td>001</td>
                <td>$690.00</td>
                <td>63</td>
                <td>
                  <span class="color-dot" style="background-color: black;"></span>
                  <span class="color-dot" style="background-color: pink;"></span>
                  <span class="color-dot" style="background-color: #D4A373;"></span>
                </td>
                <td>
                  <button class="action-btn edit-btn">✎</button>
                  <button class="action-btn delete-btn">🗑</button>
                </td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    
       
</body>
</html>
