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
    .container {
    display: flex;
    flex-direction: column;
    padding: 20px;
}

.top-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.category-section, .subcategory-section {
    flex: 1;
}

.photo-section .photo-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 20px;
}

.photo-container img {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Circular image */
    margin-bottom: 10px;
}

.option-section .option-group {
    margin-bottom: 20px;
}

.option-photo {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.name-input {
    margin-top: 5px;
    width: 100%; /* Adjust the width as needed */
}

.upload-photo {
    padding: 5px 10px;
    background-color: #6a0dad;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.fabric-section table {
    width: 100%;
    border-collapse: collapse;
}

.fabric-section th, .fabric-section td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.color-dot {
    display: inline-block;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    margin-right: 5px;
}

.add-new {
    display: inline-block;
    padding: 10px 20px;
    margin-top: 10px;
    background-color: #6a0dad;
    color: #fff;
    border: none;
    cursor: pointer;
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
    <div class="top-row">
        <div class="category-section">
            <h2>Category</h2>
            <p>Shirt</p>
        </div>
        <div class="subcategory-section">
            <h2>Sub Category</h2>
            <p>Long Sleeve</p>
        </div>
    </div>
    
    <div class="photo-section">
        <div class="photo-container">
            <img src="Add Image.png" alt="Product Photo">
            <button>Change Photo</button>
        </div>
    </div>

    <div class="option-section">
        <div class="top-row">
        <div class="option-group">
            <h3>Button Type</h3>
            <div class="option-photo">
               <div> <button class="upload-photo">Upload Photo</button>
                <input type="text" placeholder="Enter Name" class="name-input"></div>
               <div> <button class="upload-photo">Upload Photo</button>
                <input type="text" placeholder="Enter Name" class="name-input"></div>
               <div> <button class="upload-photo">Upload Photo</button>
                <input type="text" placeholder="Enter Name" class="name-input"></div>
            </div>
        </div>
        <div class="option-group">
            <h3>Collar Type</h3>
            <div class="option-photo">
                <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
            </div>
        </div>
        <div class="option-group">
            <h3>Pocket Type</h3>
            <div class="option-photo">
                <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
            </div>
        </div>
    </div>
</div>
    

    <div class="fabric-section">
        <h2>Fabric</h2>
        <table>
            <tr>
                <th>Fabric</th>
                <th>Available</th>
                <th>Act</th>
            </tr>
            <tr>
                <td>Linen</td>
                <td>
                    <span class="color-dot" style="background-color: black;"></span>
                    <span class="color-dot" style="background-color: grey;"></span>
                    <span class="color-dot" style="background-color: pink;"></span>
                </td>
                <td><button>📝</button> <button>🗑️</button></td>
            </tr>
            <tr>
                <td>Silk</td>
                <td>
                    <span class="color-dot" style="background-color: black;"></span>
                    <span class="color-dot" style="background-color: red;"></span>
                    <span class="color-dot" style="background-color: blue;"></span>
                    <span class="color-dot" style="background-color: yellow;"></span>
                </td>
                <td><button>📝</button> <button>🗑️</button></td>
            </tr>
            <tr>
                <td>Cotton</td>
                <td>
                    <span class="color-dot" style="background-color: maroon;"></span>
                    <span class="color-dot" style="background-color: navy;"></span>
                    <span class="color-dot" style="background-color: purple;"></span>
                </td>
                <td><button>📝</button> <button>🗑️</button></td>
            </tr>
        </table>
        <button class="add-new">+ Add New</button>
    </div>
</div>


    
     
    
       
</body>
</html>
