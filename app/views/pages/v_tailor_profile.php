<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="profile-container">
    <div class="pic">
        <div class="profile-image">
            <img src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="Profile">
        </div>
        <div class="profile-name">Saduni Perera</div>
    </div>
    <div class="profile-stats-container">
        <div class="followers">
            <div>12<br>Posts</div>
            <div>100<br>Likes</div>
        </div>
        <button class="follow-button">Like <i class="fas fa-thumbs-up"></i></button>
    </div>
</div>

<div class="buttons-container">
    <button class="menu-button" onclick="loadContent('posts', this)">Posts</button>
    <button class="menu-button" onclick="loadContent('designs', this)">Designs</button>
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
    function loadContent(content, button) {
        window.location.href = '?content=' + content;
        document.querySelectorAll('.menu-button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
    }

    // Set the active button based on the current content
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        const content = params.get('content') || 'posts';
        document.querySelectorAll('.menu-button').forEach(btn => {
            if (btn.textContent.toLowerCase() === content) {
                btn.classList.add('active');
            }
        });
    });
</script>

<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>