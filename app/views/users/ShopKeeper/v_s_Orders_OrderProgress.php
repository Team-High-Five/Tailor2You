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
}


select {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 5px;
}


.order-card {
  display: flex;
  background-color: #ffffff;
  border-radius: 10px;
  padding: 1rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 1rem;
  gap: 1rem;
}

.order-details {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.product-image {
  width: 80px;
  height: 80px;
  border-radius: 10px;
  object-fit: cover;
}

.product-name {
  font-weight: bold;
  font-size: 1rem;
}

.product-price {
  color: #666;
}

.order-info {
  flex-grow: 1;
}

.order-id {
  font-weight: bold;
  font-size: 1.1rem;
}

.order-date {
  color: #888;
  margin-bottom: 0.5rem;
}

.customer-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.customer-avatar {
  width: 32px;
  height: 32px;
  background-color: #eee;
  border-radius: 50%;
}

.customer-name {
  font-weight: bold;
}

.status {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.875rem;
  font-weight: bold;
  color: white;
}

.status.processing {
  background-color: #a1a9fe;
}

.status.completed {
  background-color: #a2e8cd;
}

.progress-bar {
  position: relative;
  height: 8px;
  background-color: #e1e4f0;
  border-radius: 4px;
  overflow: hidden;
  margin: 0.5rem 0;
}

.progress {
  height: 100%;
  background-color: #5f75ee;
}

.progress-text {
  font-size: 0.85rem;
  color: #555;
  margin-top: 0.5rem;
}

.action-buttons {
  display: flex;
  gap: 0.5rem;
  margin-top: 1rem;
}

.assign-button, .status-button, .view-order {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.assign-button, .status-button {
  background-color: #f4f6fc;
  color: #333;
}

.view-order {
  background-color: #5f75ee;
  color: white;
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
            <h1><a href="#" class="Section ">Order List</a></h1>
            <h1><a href="#" class="Section Active-icon">Order Progress</a></h1>
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
                <!-- Add more date options as needed -->
            </select>
            <select>
                <option>Order Type</option>
                <!-- Add more order types as needed -->
            </select>
            <select>
                <option>Order Status</option>
                <!-- Add more statuses as needed -->
            </select>
            <button class="reset-filter-btn">Reset Filter</button>
        </div>
    
    
        <div class="order-card">
          <div class="order-details">
            <img src="Untitled design (23) 1.png" alt="Dotted Black Dress" class="product-image">
            <div>
              <p class="product-name">Dotted Black Dress</p>
              <p class="product-price">$20.00 x1</p>
            </div>
          </div>
          <div class="order-info">
            <p class="order-id">Order #1067907</p>
            <p class="order-date">Placed on 02/09/2024</p>
            <div class="customer-info">
                <img src="woman avatar.png" alt="Customer Image" class="customer-avatar">
              <p class="customer-name">Pieris M.P</p>
              <span class="status processing">Processing</span>
            </div>
            <div class="progress-bar">
              <div class="progress" style="width: 60%;"></div>
              <p class="progress-text">Status 60%</p>
            </div>
            <div class="action-buttons">
              <button class="assign-button">Assign a Tailor ▼</button>
              <button class="status-button">Order Status ▼</button>
              <button class="view-order">View Order</button>
            </div>
          </div>
        </div>
    
        <!-- Add another order-card for the next item -->
        <div class="order-card">
          <div class="order-details">
            <img src="Untitled design (26) 1.png" alt="Rockstar Jacket" class="product-image">
            <div>
              <p class="product-name">Rockstar Jacket</p>
              <p class="product-price">$22.00 x1</p>
            </div>
          </div>
          <div class="order-info">
            <p class="order-id">Order #1067908</p>
            <p class="order-date">Placed on 04/07/2024</p>
            <div class="customer-info">
              <img src="woman showing v sign avatar.png" alt="Customer Image" class="customer-avatar">
              <p class="customer-name">De Silva N.G</p>
              <span class="status completed">Completed</span>
            </div>
            <div class="progress-bar">
              <div class="progress" style="width: 100%;"></div>
              <p class="progress-text">Status 100%</p>
            </div>
            <div class="action-buttons">
              <button class="assign-button">Assign a Tailor ▼</button>
              <button class="status-button">Order Status ▼</button>
              <button class="view-order">View Order</button>
            </div>
          </div>
        </div>
      </div>    
</body>
</html>
