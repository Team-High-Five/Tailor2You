<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="portfolio-container">
    <div class="portfolio-header">
      <h2>My Portfolio</h2>
      <a href="#" class="btn-primary add-post-btn">Add New Post</a>
    </div>

    <!-- Portfolio Grid -->
    <div class="portfolio-grid">
      <!-- Portfolio Item 1 -->
      <div class="portfolio-item">
        <img src="<?php echo URLROOT; ?>/public/img/black_coat.png" alt="Rounded Red Hat">
        <h3>Rounded Red Hat</h3>
        <p>Description</p>
        <div class="portfolio-actions">
          <button class="btn-primary edit-btn">Edit</button>
          <button class="btn-danger delete-btn">Delete</button>
        </div>
      </div>
      <!-- Portfolio Item 2 -->
      <div class="portfolio-item">
        <img src="<?php echo URLROOT; ?>/public/img/woman_dress_cream.png" alt="Fork">
        <h3>Fork</h3>
        <p>Description</p>
        <div class="portfolio-actions">
          <button class="btn-primary edit-btn">Edit</button>
          <button class="btn-danger delete-btn">Delete</button>
        </div>
      </div>
      <!-- Portfolio Item 3 -->
      <div class="portfolio-item">
        <img src="<?php echo URLROOT; ?>/public/img/navy_blue_suit.png" alt="Rounded Red Hat">
        <h3>Rounded Red Hat</h3>
        <p>Description</p>
        <div class="portfolio-actions">
          <button class="btn-primary edit-btn">Edit</button>
          <button class="btn-danger delete-btn">Delete</button>
        </div>
      </div>
      <!-- Portfolio Item 4 -->
      <div class="portfolio-item">
        <img src="<?php echo URLROOT; ?>/public/img/blue_dress.png" alt="Blue Dress">
        <h3>Blue Dress</h3>
        <p>Description</p>
        <div class="portfolio-actions">
          <button class="btn-primary edit-btn">Edit</button>
          <button class="btn-danger delete-btn">Delete</button>
        </div>
      </div>
      <!-- Portfolio Item 5 -->
      <div class="portfolio-item">
        <img src="<?php echo URLROOT; ?>/public/img/tuxedo.jpeg" alt="Tuxedo">
        <h3>Tuxedo</h3>
        <p>Description</p>
        <div class="portfolio-actions">
          <button class="btn-primary edit-btn">Edit</button>
          <button class="btn-danger delete-btn">Delete</button>
        </div>
      </div>
      <!-- Portfolio Item 6 -->
      <div class="portfolio-item">
        <img src="<?php echo URLROOT; ?>/public/img/black_full_suit.jpg" alt="Rounded Red Hat">
        <h3>Rounded Red Hat</h3>
        <p>Description</p>
        <div class="portfolio-actions">
          <button class="btn-primary edit-btn">Edit</button>
          <button class="btn-danger delete-btn">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>