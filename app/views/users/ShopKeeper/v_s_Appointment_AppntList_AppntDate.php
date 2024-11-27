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
    font-family: Arial, sans-serif;
}

.appointment-details-container {
    max-width: 400px;
    margin: 40px auto;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    padding: 20px;
    text-align: center;
    position: relative;
}

.appointment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.close-btn {
    background: none;
    border: none;
    font-size: 20px;
    color: #333;
    cursor: pointer;
}

.appointment-info {
    margin-bottom: 20px;
}

.appointment-date {
    font-size: 16px;
    color: #666;
    margin-bottom: 10px;
}

.user-info {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.user-name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.calendar-icon {
    display: inline-block;
    text-align: center;
    border: 2px solid #000;
    border-radius: 8px;
    padding: 10px 15px;
    margin-bottom: 20px;
}

.calendar-icon .month {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.calendar-icon .date {
    font-size: 36px;
    font-weight: bold;
    color: #000;
}

.calendar-icon .day {
    font-size: 14px;
    color: #333;
}

.status {
    display: inline-block;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: bold;
    border-radius: 4px;
    color: #fff;
    margin-top: 10px;
}

.status.accepted {
    background-color: #a5e8c3;
}

.tailor-info {
    margin-top: 20px;
    font-size: 14px;
    color: #333;
}

.reschedule-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #6c63ff;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    margin-top: 20px;
}

.reschedule-btn:hover {
    background-color: #5a53cc;
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
            <h1><a href="#" class="Section Active-icon">Appointment Date</a></h1>
            
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
    <div class="appointment-details-container">
        <div class="appointment-header">
            <p>Appointment #1067907</p>
            <button class="close-btn">✕</button>
        </div>
        <div class="appointment-info">
            <p class="appointment-date">22/09/2024 - 4:00 p.m.</p>
            <div class="user-info">
                <img src="woman avatar.png" alt="User profile" class="user-avatar">
                <span class="user-name">Sanduni T.P</span>
            </div>
            <div class="calendar-icon">
                <div class="month">September</div>
                <div class="date">22</div>
                <div class="day">Sunday</div>
            </div>
        </div>
            <div class="status accepted">Accepted</div>

        <div class="tailor-info">
            <p><strong>Assigned Tailor</strong> Sudarshani P.H.</p>
        </div>
        <button class="reschedule-btn">Request For Rescheduling</button>
    </div>
    
        <a href="#" class="Back">Back</a>
        
    
       
</body>
</html>
