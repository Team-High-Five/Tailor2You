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
      background-image: url('antique-1838324_1280 1.png'); /* Replace with actual background URL */
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

   /* Container Styling */
   .portfolio-container {
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .portfolio-header {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            background: #ece7f8;
            padding: 20px;
        }

        .portfolio-header h2 {
            font-size: 24px;
            color: #333;
        }

        /* Grid for Portfolio Items */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .portfolio-item {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s;
    width: 200px; /* Set the fixed width */
    height: 300px; /* Set the fixed height */
}

.portfolio-item img {
    width: 100%;
    height: 200px; /* Set a fixed height for the image */
    object-fit: cover; /* Ensures the image fills the space without distortion */
}


        .portfolio-item h3 {
            font-size: 18px;
            margin: 10px 0 5px;
            color: #333;
        }

        .portfolio-item p {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .portfolio-item .delete-btn {
            background-color: #ff4c4c;
            border: none;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            transition: background 0.3s;
        }

        .portfolio-item .delete-btn:hover {
            background-color: #e04343;
        }

        /* Add New Post Button */
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
  </style>
</head>
<body>
  <div class="sidebar">
    <a href="#">
      <img src="tailor house (3) 2.png" alt="Logo" />
    </a>
    <div class="sidebar-icon "> <img src="Home.png"></div>
    <div class="sidebar-icon Active-icon"><img src="Customer.png"></div>
    <div class="sidebar-icon"><img src="Purchase Order.png"></div>
    <div class="sidebar-icon"><img src="Calendar.png"></div>
    <div class="sidebar-icon"><img src="Adjust.png"></div>
    <div class="sidebar-icon"><img src="Shopping bag.png"></div>
  </div>

  <div class="Section-content">
    <div class="header">
        <div  class="actions">
            <h1><a href="#" class="Section ">Profile</a></h1>
            <h1><a href="#" class="Section Active-icon">Portfolio</a></h1>
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

    <div class="portfolio-container">
       
        <!-- Portfolio Grid -->
        <div class="portfolio-grid">
            <!-- Portfolio Item 1 -->
            <div class="portfolio-item">
                <img src="Untitled design (24) 1.png" alt="Rounded Red Hat">
                <h3>Rounded Red Hat</h3>
                <p>Description</p>
                <button class="delete-btn">Delete</button>
            </div>
            <!-- Portfolio Item 2 -->
            <div class="portfolio-item">
                <img src="Untitled design (22) 1.png" alt="Fork">
                <h3>Fork</h3>
                <p>Description</p>
                <button class="delete-btn">Delete</button>
            </div>
            <!-- Portfolio Item 3 -->
            <div class="portfolio-item">
                <img src="Untitled design (25) 1.png" alt="Rounded Red Hat">
                <h3>Rounded Red Hat</h3>
                <p>Description</p>
                <button class="delete-btn">Delete</button>
            </div>
            <!-- Portfolio Item 4 -->
            <div class="portfolio-item">
                <img src="Untitled design (23) 1.png" alt="Blue Dress">
                <h3>Blue Dress</h3>
                <p>Description</p>
                <button class="delete-btn">Delete</button>
            </div>
            <!-- Portfolio Item 5 -->
            <div class="portfolio-item">
                <img src="images.jpeg" alt="Tuxedo">
                <h3>Tuxedo</h3>
                <p>Description</p>
                <button class="delete-btn">Delete</button>
            </div>
            <!-- Portfolio Item 6 -->
            <div class="portfolio-item">
                <img src="61vm9lXHF7L._AC_SX569_.jpg" alt="Tuxedo">
                <h3>Tuxedo</h3>
                <p>Description</p>
                <button class="delete-btn">Delete</button>
            </div>
        </div>

        <!-- Add New Post Button -->
        <a href="#" class="add-post-btn">Add New Post</a>
    </div>
    
</body>
</html>
