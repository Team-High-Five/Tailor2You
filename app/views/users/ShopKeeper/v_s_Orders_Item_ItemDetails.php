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
    /* Container for the modal */
.item-details-modal {
  width: 70%;
  margin: auto;
  background: white;
  border-radius: 10px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  padding: 20px;
  position: relative;
  font-family: Arial, sans-serif;
}

/* Header */
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
}

.modal-header h2 {
  margin: 0;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

/* Body */
.modal-body {
  display: flex;
  padding: 20px;
}

.item-details-content {
  display: flex;
  justify-content: space-between;
  gap: 20px;
}

/* Left Section */
.left-section {
  flex: 1;
  text-align: center;
}

.item-image {
  width: 80%;
  border-radius: 8px;
  margin-bottom: 15px;
}

.item-name {
  font-size: 20px;
  font-weight: bold;
  margin: 10px 0;
}

.item-price {
  color: #6c63ff;
  font-size: 18px;
  margin-bottom: 15px;
}

.colors {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 15px;
}

.color-dot {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 1px solid #ccc;
}

.customer-info {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 15px;
}

.customer-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

/* Right Section */
.right-section {
  flex: 2;
}

.item-specs {
  list-style-type: none;
  padding: 0;
  margin: 0 0 20px 0;
}

.item-specs li {
  margin: 5px 0;
}

.item-description {
  margin: 10px 0;
  font-size: 14px;
}

.disclaimer {
  font-size: 12px;
  color: #666;
}

/* Footer */
.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  border-top: 1px solid #ccc;
  padding-top: 10px;
  margin-top: 20px;
}

.btn {
  padding: 10px 20px;
  font-size: 14px;
  border-radius: 5px;
  cursor: pointer;
  border: none;
}

.accept-btn {
  background: #6c63ff;
  color: white;
}

.reject-btn {
  background: #f44336;
  color: white;
}

    .Back {
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

        .Back:hover {
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
    <div class="sidebar-icon  Active-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section Active-icon">Item Details</a></h1>
            <h1><a href="#" class="Section ">Measurements</a></h1>
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

    <div class="item-details-modal">
      <div class="modal-header">
        <h2>Item Details</h2>
        <button class="close-btn">&times;</button>
      </div>
    
      <div class="modal-body">
        <div class="item-details-content">
          <div class="left-section">
            <img src="Untitled design (23) 1.png" alt="Dotted Black Dress" class="item-image">
            <h3 class="item-name">Dotted Black Dress</h3>
            <p class="item-price">$20.00</p>
            <div class="colors">
              <span class="color-dot" style="background-color: black;"></span>
              <span class="color-dot" style="background-color: gray;"></span>
              <span class="color-dot" style="background-color: lightblue;"></span>
            </div>
            <div class="customer-info">
              <img src="woman avatar.png" alt="Customer Profile" class="customer-avatar">
              <p class="customer-name">Pieris M.P</p>
            </div>
          </div>
    
          <div class="right-section">
            <ul class="item-specs">
              <li><strong>Material:</strong> Printed Rayon</li>
              <li><strong>Style:</strong> Short Sleeves</li>
              <li><strong>Size L Measurements:</strong> Length 35.5" / Bust 37" / Waist 38"</li>
              <li><strong>Model Height:</strong> 5 Feet 8 Inches</li>
              <li><strong>Fit:</strong> Loose Fit</li>
            </ul>
            <p class="item-description">
              <strong>Wash & Care:</strong> Hand wash with cold water, wash inside out, 
              wash light colors separately & iron with care.
            </p>
            <p class="disclaimer">
              Despite every effort to provide accurate images of each product's color and design, 
              actual colors and design may vary slightly.
            </p>
          </div>
        </div>
      </div>
    
      <div class="modal-footer">
        <button class="btn accept-btn">Accept</button>
        <button class="btn reject-btn">Reject</button>
      </div>
    </div>
    
    <div class="container">

        <a href="#" class="Back">Back</a>
        
    
       
</body>
</html>
