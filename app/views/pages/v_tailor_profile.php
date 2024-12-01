<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
 
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
