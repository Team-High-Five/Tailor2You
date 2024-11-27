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
   
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.appointment-list-container {
    max-width: 900px;
    margin: auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 24px;
    color: #333;
}

.tabs {
    display: flex;
    gap: 10px;
}

.tab {
    background-color: #f3f3f3;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.tab.active {
    background-color: #6c63ff;
    color: #fff;
}

.search-box {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 200px;
}

.filter-bar {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 20px;
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

.appointment-table {
    width: 100%;
    border-collapse: collapse;
}

.appointment-table th, .appointment-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.appointment-table th {
    background-color: #f3f3f3;
    font-weight: bold;
}

.status {
    padding: 4px 8px;
    border-radius: 4px;
    color: #fff;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
}

.status.accepted {
    background-color: #a5e8c3;
    color: #0d7a48;
}

.status.processing {
    background-color: #e4d8ff;
    color: #6c63ff;
}

.status.rejected {
    background-color: #ffc8c8;
    color: #ff4d4d;
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
    <div class="sidebar-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon Active-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section Active-icon">Appointment List</a></h1>
            <h1><a href="#" class="Section ">Calendar</a></h1>
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
    <div class="appointment-list-container">
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
    
        <table class="appointment-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th></th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>00001</td>
                    <td>Christine Brooks</td>
                    <td>
                        <select class="assign-tailor">
                            <option>Assign a Tailor</option>
                            <option>Tailor 1</option>
                            <option>Tailor 2</option>
                        </select>
                    </td>
                    <td>14 Feb 2019</td>
                    <td>4:00 p.m.</td>
                    <td><span class="status accepted">Accepted</span></td>
                </tr>
                <tr>
                    <td>00002</td>
                    <td>Rosie Pearson</td>
                    <td>
                        <select class="assign-tailor">
                            <option>Assign a Tailor</option>
                            <option>Tailor 1</option>
                            <option>Tailor 2</option>
                        </select>
                    </td>
                    <td>14 Feb 2019</td>
                    <td>3:00 p.m.</td>
                    <td><span class="status processing">Processing</span></td>
                </tr>
                <tr>
                    <td>00003</td>
                    <td>Darrell Caldwell</td>
                    <td>
                        <select class="assign-tailor">
                            <option>Assign a Tailor</option>
                            <option>Tailor 1</option>
                            <option>Tailor 2</option>
                        </select>
                    </td>
                    <td>14 Feb 2019</td>
                    <td>10:30 a.m.</td>
                    <td><span class="status rejected">Rejected</span></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
    

        
        
    
       
</body>
</html>
