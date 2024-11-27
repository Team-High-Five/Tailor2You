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
    /* Modal Container */
.measurement-modal {
  width: 60%;
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

/* Customer Information */
.customer-info {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 20px 0;
}

.customer-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.customer-name {
  font-size: 18px;
  font-weight: bold;
}

/* Measurement Table */
.measurement-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

.measurement-table th, .measurement-table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

.measurement-table th {
  background-color: #f4f4f4;
  font-weight: bold;
}

.measurement-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.measurement-table tr:hover {
  background-color: #f1f1f1;
}

/* Footer */
.modal-footer {
  display: flex;
  justify-content: center;
  padding-top: 10px;
  margin-top: 20px;
  border-top: 1px solid #ccc;
}

.btn {
  padding: 10px 20px;
  font-size: 14px;
  border-radius: 5px;
  cursor: pointer;
  border: none;
  background: #6c63ff;
  color: white;
}

.btn:hover {
  background: #5548c8;
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
    <div class="sidebar-icon Active-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section ">Item Details</a></h1>
            <h1><a href="#" class="Section Active-icon">Measurements</a></h1>
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
      <div class="measurement-modal">
        <div class="modal-header">
          <h2>Measurements</h2>
          <button class="close-btn">&times;</button>
        </div>
      
        <div class="modal-body">
          <div class="customer-info">
            <img src="woman avatar.png" alt="Customer Profile" class="customer-avatar">
            <p class="customer-name">Pieris M.P</p>
          </div>
      
          <table class="measurement-table">
            <thead>
              <tr>
                <th>Measurement</th>
                <th>Description</th>
                <th>Measurement</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Neck Circumference</td>
                <td>Around the base of the neck</td>
                <td>14 - 18</td>
              </tr>
              <tr>
                <td>Chest</td>
                <td>Fullest part of the chest</td>
                <td>34 - 48</td>
              </tr>
              <tr>
                <td>Waist</td>
                <td>Narrowest part of the waist</td>
                <td>28 - 44</td>
              </tr>
              <tr>
                <td>Hip</td>
                <td>Fullest part of the hips</td>
                <td>36 - 50</td>
              </tr>
              <tr>
                <td>Shoulder Width</td>
                <td>Distance between shoulder seams</td>
                <td>16 - 22</td>
              </tr>
              <tr>
                <td>Sleeve Length</td>
                <td>From shoulder seam to wrist</td>
                <td>24 - 36</td>
              </tr>
              <tr>
                <td>Armhole</td>
                <td>Circumference of the armhole</td>
                <td>16 - 22</td>
              </tr>
              <tr>
                <td>Shirt Length</td>
                <td>From the base of the neck to the hem</td>
                <td>28 - 36</td>
              </tr>
              <tr>
                <td>Cuff Circumference</td>
                <td>Around the wrist</td>
                <td>7 - 10</td>
              </tr>
            </tbody>
          </table>
        </div>
      
        <div class="modal-footer">
          <button class="btn request-edit-btn">Request Edit</button>
        </div>
      </div>
      

        
        
    
       
</body>
</html>
