<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="profile-container">
    <div class="pic">
        <div class="profile-image">
            <img src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="Profile">
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

<div class="content-container">
    <?php if (isset($_GET['content'])) {
        $content = $_GET['content'];
        if ($content == 'posts') {
            include 'inc/components/tailor_posts.php'; //add here
        } elseif ($content == 'designs') {
            include 'inc/components/tailor_selling_items.php';
        }
    } else {
        include 'inc/components/tailor_posts.php';
    }
    ?>
</div>

<script>
    function loadContent(content) {
        window.location.href = '?content=' + content;
    }
</script>

<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>