<section class="posts-grid">
  <?php if (!empty($data['posts'])): ?>
    <?php foreach ($data['posts'] as $post): ?>
      <div class="post-card">
        <?php if (!empty($post->image)): ?>
          <img src="data:image/jpeg;base64,<?php echo base64_encode($post->image); ?>" alt="<?php echo $post->title; ?>">
        <?php else: ?>
          <img src="<?php echo URLROOT; ?>/public/img/no-image.jpg" alt="No Image Available">
        <?php endif; ?>

        <div class="post-content">
          <h3 class="post-title"><?php echo $post->title; ?></h3>
          <p class="post-description"><?php echo substr($post->description, 0, 100) . (strlen($post->description) > 100 ? '...' : ''); ?></p>

          <?php if (!empty($post->gender) && $post->gender != 'unisex'): ?>
            <span class="post-tag"><?php echo ucfirst($post->gender); ?></span>
          <?php endif; ?>

          <?php if (!empty($post->item_type)): ?>
            <span class="post-tag"><?php echo ucfirst($post->item_type); ?></span>
          <?php endif; ?>

          <div class="post-meta">
            <span class="post-date"><?php echo date('M j, Y', strtotime($post->created_at)); ?></span>

            <?php if (isLoggedIn()): ?>
              <form action="<?php echo URLROOT; ?>/pages/likePost/<?php echo $post->id; ?>" method="post" class="like-form">
                <button type="submit" class="like-button <?php echo (isset($data['liked_posts']) && in_array($post->id, $data['liked_posts'])) ? 'liked' : ''; ?>">
                  <i class="<?php echo (isset($data['liked_posts']) && in_array($post->id, $data['liked_posts'])) ? 'fas fa-heart' : 'far fa-heart'; ?>"></i>
                  <?php echo (isset($data['liked_posts']) && in_array($post->id, $data['liked_posts'])) ? 'Liked' : 'Like'; ?>
                  (<?php echo isset($post->like_count) ? $post->like_count : 0; ?>)
                </button>
              </form>
            <?php else: ?>
              <s<a href="<?php echo URLROOT; ?>/users/login" class="like-button">
                <i class="far fa-heart"></i> Login to Like
                (<?php echo isset($post->like_count) ? $post->like_count : 0; ?>)
                </a>
              <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="no-posts">
      <p>This tailor hasn't added any posts yet.</p>
    </div>
  <?php endif; ?>
</section>

<style>
  .posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
  }

  .post-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  .post-card:hover {
    transform: translateY(-5px);
  }

  .post-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .post-content {
    padding: 15px;
  }

  .post-title {
    margin-top: 0;
    font-size: 1.2rem;
    color: var(--primary-color);
  }

  .post-description {
    color: #555;
    font-size: 0.9rem;
    margin-bottom: 10px;
  }

  .post-tag {
    display: inline-block;
    padding: 3px 8px;
    background: var(--accent-color);
    color: white;
    border-radius: 4px;
    font-size: 0.8rem;
    margin-right: 5px;
  }

  .post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    font-size: 0.85rem;
    color: #777;
  }

  .like-form {
    display: inline;
  }



  .like-button {
    background: transparent;
    border: 1px solid #ddd;
    border-radius: 20px;
    cursor: pointer;
    color: #777;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .like-button:hover {
    background-color: #f8f8f8;
  }

  .like-button.liked {
    color: #e74c3c;
    border-color: #e74c3c;
    background-color: rgba(231, 76, 60, 0.05);
  }

  .like-button.liked i {
    color: #e74c3c;
  }

  a.like-button {
    text-decoration: none;
  }

  .no-posts {
    grid-column: 1 / -1;
    text-align: center;
    padding: 50px 0;
    color: #777;
  }
</style>