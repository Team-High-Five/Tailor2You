<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Section</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .profile-container {
            position: relative;
            /* background-image: url('https://via.placeholder.com/1100x274'); Placeholder background */
            background-size: cover;
            background-position: center;
            height: 250px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid white;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: black;
        }

        .profile-stats-container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
            font-size: 14px;
            margin-left: 88px;
            column-gap: 60px;
        }

        .followers {
            display: flex;
            align-items: center;
            font-size: 16px;
            column-gap: 60px;
            text-align: center;
        }

        .followers div {
            margin-right: 10px;
            color: black;
        }

        .follow-button {
            padding: 8px 20px;
            background-color: black;
            color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .follow-button:hover {
            background-color: black;
            color: white;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            background-color: #333;
            padding: 10px 0;
        }

        .menu-button {
            color: white;
            background: transparent;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .menu-button:hover {
            color: #f5a623; /* Hover color */
        }

        .menu-button.active {
            border-bottom: 2px solid #f5a623;
        }
        .pic{
            justify-items: center;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="pic">
        <div class="profile-image">
            <img src="girls1.jpg" alt="Profile">
        </div>
        <div class="profile-name">Kumudu Liyanage</div>
    </div>
    <div class="profile-stats-container">
        <div class="followers">
            <div>12<br>Posts</div>
            <div>100<br>Followers</div>
        </div>
        <button class="follow-button">Follow</button>
    </div>
</div>

<div class="buttons-container"> 
    <button class="menu-button" onclick="loadContent('posts')">Posts</button> 
    <button class="menu-button" onclick="loadContent('designs')">Designs</button> 
</div>
<?php if (isset($_GET['content'])) { 
    $content = $_GET['content']; 
        if ($content == 'posts') { 
            include 'posts.php'; //add here
        } elseif ($content == 'designs') {
            include 'test.php'; 
        } 
    } else {
     include 'test.php'; 
    } 
    ?>

</body>
</html>

<script> 
function loadContent(content) { 
    window.location.href = '?content=' + content; 
s} 

</script>