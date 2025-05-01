<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="profile-container">
    <div class="pic">
        <div class="profile-image">
            <?php if (isset($data['tailor']->profile_pic) && !empty($data['tailor']->profile_pic)): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($data['tailor']->profile_pic); ?>" alt="Profile">
            <?php else: ?>
                <img src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="Profile">
            <?php endif; ?>
        </div>
        <div class="profile-name"><?php echo $data['tailor']->name; ?></div>
    </div>
    <div class="profile-stats-container">
        <div class="followers">
            <div><?php echo $data['postCount']; ?><br>Posts</div>
            <div><?php echo $data['likeCount']; ?><br>Likes</div>
            <div><?php echo $data['exp'] ; ?> yrs<br>Experience</div>
        </div>
        <?php if (isLoggedIn()): ?>
            <form action="<?php echo URLROOT; ?>/Pages/likeTailor/<?php echo $data['tailor']->user_id; ?>" method="post">
                <button type="submit" class="follow-button <?php echo ($data['hasLiked']) ? 'liked' : ''; ?>">
                    <?php if ($data['hasLiked']): ?>
                        Liked <i class="fas fa-thumbs-up"></i>
                    <?php else: ?>
                        Like <i class="fas fa-thumbs-up"></i>
                    <?php endif; ?>
                </button>
            </form>
        <?php else: ?>
            <a href="<?php echo URLROOT; ?>/users/login" class="follow-button">
                Login to Like <i class="fas fa-thumbs-up"></i>
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="buttons-container">
    <button class="menu-button" onclick="loadContent('posts', this)">Posts</button>
    <button class="menu-button" onclick="loadContent('designs', this)">Designs</button>
</div>

<div class="content-container">
    <?php
    // Store tailor ID in a variable to be accessible in included files
    $tailorId = $data['tailor']->user_id;

    if (isset($_GET['content'])) {
        $content = $_GET['content'];
        if ($content == 'posts') {
            include 'inc/components/tailor_posts.php';
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