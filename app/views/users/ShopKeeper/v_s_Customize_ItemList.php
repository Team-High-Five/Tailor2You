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


    .header .btn-add-product {
            background-color: #6f4ca0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
       
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .product-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
        }
        .product-card img {
    width: 50px; /* Set the desired width */
    height: 50px; /* Set the desired height */
    object-fit: cover; /* Ensures the image fits within the set dimensions */
    border-radius: 5px;
}
        .product-card h3 {
            margin: 10px 0 5px;
            font-size: 18px;
        }
        .product-card p {
            margin: 5px 0;
            color: #555;
        }
        .product-card .price {
            font-weight: bold;
            color: #333;
        }
        .product-card .actions {
            margin-top: 10px;
        }
        .product-card .actions button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            margin: 0 5px;
            font-size: 16px;
            color: #6f4ca0;
        }

        .add-post-btn {
            display: inline-block;
            background-color: #6f42c1;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .add-post-btn:hover {
            background-color: #59359a;
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
    
   
        <div class="product-grid">
            <div class="product-card">
                <img src="shirt.png" alt="Long Sleeves">
                <h3>Long Sleeves</h3>
                <p>Shirts</p>
                <p class="price">Rs:3000</p>
                <p>Men</p>
                <div class="actions">
                    <button>📝</button>
                    <button>🗑️</button>
                </div>
            </div>
            <div class="product-card">
                <img src="trouser.png" alt="Trousers">
                <h3>Trousers</h3>
                <p>Pants</p>
                <p class="price">Rs:4000</p>
                <p>Men</p>
                <div class="actions">
                    <button>📝</button>
                    <button>🗑️</button>
                </div>
            </div>
            <div class="product-card">
                <img src="shirt.png" alt="Jacket">
                <h3>Jacket</h3>
                <p>Shirts</p>
                <p class="price">Rs:10000</p>
                <p>Men</p>
                <div class="actions">
                    <button>📝</button>
                    <button>🗑️</button>
                </div>
            </div>
            <div class="product-card">
                <img src="trouser.png" alt="Trousers">
                <h3>Trousers</h3>
                <p>Pants</p>
                <p class="price">Rs:4000</p>
                <p>Men</p>
                <div class="actions">
                    <button>📝</button>
                    <button>🗑️</button>
                </div>
            </div>
    </div>
    <a href="#" class="add-post-btn">Add New Post</a>
   
        
    
       
</body>
</html>
