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

    /* General reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f0f4f8;
  color: #333;
}

.container {
  width: 80%;
  margin: 2rem auto;
  background: white;
  border-radius: 10px;
  padding: 1.5rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.filter-bar {
  display: flex;
  gap: 1rem;
  align-items: center;
  margin-bottom: 1rem;
}

.filter-btn,
.reset-filter-btn,
select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}
.reset-filter-btn {
    color: #ff4d4d;
    border-color: #ff4d4d;
}


select {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.tabs {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.order-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.order-table th, .order-table td {
  padding: 0.75rem 1rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.order-table th {
  background-color: #f9fafc;
  font-weight: bold;
  color: #555;
}

.order-table td {
  background-color: #fff;
}

.order-table tr:hover {
  background-color: #f1f5f9;
}

.status {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.875rem;
  font-weight: bold;
  color: white;
  text-align: center;
}

.status.processing {
  background-color: #87CEEB;
}

.status.completed {
  background-color: #a2e8cd;
}

.status.rejected {
  background-color: #f38c8c;
}

.status.pending {
  background-color: #fbd687;
}


  </style>
</head>
<body>
  <div class="sidebar">
    <a href="#">
      <img src="tailor house (3) 2.png" alt="Logo" />
    </a>
    <div class="sidebar-icon "> <img src="Home.png"></div>
    <div class="sidebar-icon "><img src="Customer.png"></div>
    <div class="sidebar-icon  Active-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section  Active-icon">Order List</a></h1>
            <h1><a href="#" class="Section">Order Progress</a></h1>
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
    <div class="container">
        <div class="filter-bar">
          <button class="filter-btn">Filter By</button>
          <select>
            <option>14 Feb 2019</option>
            <!-- Additional dates can go here -->
          </select>
          <select>
            <option>Order Type</option>
            <!-- Additional order types can go here -->
          </select>
          <select>
            <option>Order Status</option>
            <!-- Additional status options can go here -->
          </select>
          <button class="reset-filter-btn">Reset Filter</button>
        </div>
    
        
    
        <table class="order-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Order</th>
              <th>Date</th>
              <th>Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>00001</td>
              <td>Pieris M.P</td>
              <td>Dotted Black Dress</td>
              <td>14 Feb 2019</td>
              <td>Rs.10,000</td>
              <td><span class="status processing">Processing</span></td>
            </tr>
            <tr>
              <td>00002</td>
              <td>De Silva N.G</td>
              <td>Rockstar Jacket</td>
              <td>14 Feb 2019</td>
              <td>Rs.12,000</td>
              <td><span class="status completed">Completed</span></td>
            </tr>
            <tr>
              <td>00003</td>
              <td>Darrell Caldwell</td>
              <td>Long Sleeve Shirt</td>
              <td>14 Feb 2019</td>
              <td>Rs.5,000</td>
              <td><span class="status rejected">Rejected</span></td>
            </tr>
            <tr>
              <td>00004</td>
              <td>Gilbert Johnston</td>
              <td>Casual Dress</td>
              <td>14 Feb 2019</td>
              <td>Rs.4,000</td>
              <td><span class="status pending">Pending</span></td>
            </tr>
            <!-- Add more rows as needed -->
          </tbody>
        </table>
      </div>
    
</body>
</html>