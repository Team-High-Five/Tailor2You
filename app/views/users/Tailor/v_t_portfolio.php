<?php if ($_SESSION['user_type'] == 'shopkeeper') {
  require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] == 'tailor') {
  require_once APPROOT . '/views/users/Tailor/inc/Header.php';
  require_once APPROOT . '/views/users/Tailor/inc/sideBar.php';
  require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} ?>
<!-- Add link to the external CSS file -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/shopkeeper/portfolio.css">

<div class="main-content">
  <?php flash('post_message'); ?>
  <!-- Add New Post button moved outside portfolio-container like in fabric page -->
  <button class="btn-primary add-post-btn" id="openPostModalBtn">Add New Post</button>

  <!-- Add vertical space between button and filter bar -->
  <div style="margin: 20px 0;"></div>

  <div class="portfolio-container">
    <div class="filter-bar">
      <div class="filter-label">
        <i class="fas fa-filter"></i> Filter Portfolio
      </div>
      <select id="filter-gender" class="filter-select">
        <option value="">All Gender</option>
        <option value="men">Men</option>
        <option value="women">Women</option>
        <option value="unisex">Unisex</option>
      </select>
      <select id="filter-item-type" class="filter-select">
        <option value="">All Items</option>
        <option value="shirt">Shirt</option>
        <option value="pant">Pant</option>
        <option value="frock">Frock</option>
        <option value="skirt">Skirt</option>
        <option value="blouse">Blouse</option>
      </select>
      <select id="filter-date" class="filter-select">
        <option value="">All Time</option>
        <option value="today">Today</option>
        <option value="week">This Week</option>
        <option value="month">This Month</option>
        <option value="year">This Year</option>
      </select>
      <button id="reset-filters" class="rst-btn">Reset</button>
    </div>

    <!-- Portfolio Grid -->
    <div class="portfolio-grid">
      <?php foreach ($data['posts'] as $post):
        // Get timestamp for date filtering
        $dateTimestamp = strtotime($post->created_at);
        $dateFormatted = date('Y-m-d', $dateTimestamp);

        // Default values for gender and item_type if not set
        $gender = isset($post->gender) ? $post->gender : 'unisex';
        $itemType = isset($post->item_type) ? $post->item_type : '';
      ?>
        <div class="portfolio-item"
          data-gender="<?php echo strtolower($gender); ?>"
          data-item-type="<?php echo strtolower($itemType); ?>"
          data-date="<?php echo $dateFormatted; ?>"
          data-timestamp="<?php echo $dateTimestamp; ?>">
          <?php if (!empty($post->image)): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($post->image); ?>" alt="<?php echo $post->title; ?>">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/default_image.png" alt="<?php echo $post->title; ?>">
          <?php endif; ?>

          <h3><?php echo $post->title; ?></h3>

          <div class="post-metadata">
            <div class="created-date">
              <i class="far fa-calendar-alt"></i> <?php echo date('F j, Y', strtotime($post->created_at)); ?>
            </div>
            <!-- Adding like count display -->
            <div class="like-count">
              <i class="fas fa-heart"></i> <?php echo isset($post->like_count) ? $post->like_count : 0; ?> likes
            </div>
          </div>

          <div class="item-meta-info">
            <div class="meta-item">
              <span class="meta-label">Gender:</span>
              <span class="gender-tag"><?php echo ucfirst($gender); ?></span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Item:</span>
              <span class="item-type-tag"><?php echo ucfirst($itemType); ?></span>
            </div>
          </div>

          <div class="description-container">
            <p><?php echo $post->description; ?></p>
          </div>

          <div class="item-footer">
            <div class="portfolio-actions">
              <button class="edit-btn" data-post-id="<?php echo $post->id; ?>"><i class="fas fa-edit"></i></button>
              <button class="delete-btn" onclick="confirmDeletePost(<?php echo $post->id; ?>)"><i class="fas fa-trash-alt"></i></button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="no-results" style="display: none;">No portfolio items match your filter criteria</div>
  </div>
</div>
<!-- Modal Structure with Proper Animation Classes -->
<div id="postModal" class="modal">
  <div class="modal-body">
    <div class="post-modal-content">
      <!-- Content from v_t_portfolio_add_new.php will be loaded here -->
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal with Modern Structure -->
<div id="deletePostModal" class="modal">
  <div class="modal-body">
    <div class="delete-modal-content">
      <div class="modal-header">
        <h1>Confirm Deletion</h1>
        <button class="close-btn">&times;</button>
      </div>
      <div class="modal-content">
        <p>Are you sure you want to delete this post?</p>
        <form id="deletePostForm" action="" method="post">
          <div class="button-rows">
            <button type="submit" class="submit-btn">Yes, Delete</button>
            <button type="button" class="reset-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const openPostModalBtn = document.getElementById('openPostModalBtn');
    const postModal = document.getElementById('postModal');

    // Handle opening the Add New Post modal with animation
    openPostModalBtn.addEventListener('click', function() {
      // First set display to flex
      postModal.style.display = 'flex';

      // Force browser reflow to enable transition
      void postModal.offsetWidth;

      // Then add the show class for animation
      setTimeout(() => {
        postModal.classList.add('show');
      }, 10);

      // Load the tailor's add new post view
      fetch('<?php echo URLROOT; ?>/Shopkeepers/addNewPost')
        .then(response => response.text())
        .then(html => {
          document.querySelector('#postModal .modal-body .post-modal-content').innerHTML = html;
          attachEventListeners(); // Attach event listeners after content is loaded
        })
        .catch(error => {
          console.error('Error loading form:', error);
          closeModal(postModal);
        });
    });

    // Handle edit post buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
      button.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');

        // First set display to flex
        postModal.style.display = 'flex';

        // Force browser reflow
        void postModal.offsetWidth;

        // Then add the show class
        setTimeout(() => {
          postModal.classList.add('show');
        }, 10);

        // Load the edit form
        fetch('<?php echo URLROOT; ?>/Shopkeepers/editPost/' + postId)
          .then(response => response.text())
          .then(html => {
            document.querySelector('#postModal .modal-body .post-modal-content').innerHTML = html;
            attachEventListeners();
          })
          .catch(error => {
            console.error('Error loading edit form:', error);
            closeModal(postModal);
          });
      });
    });

    // Generic close modal function
    function closeModal(modal) {
      modal.classList.remove('show');
      setTimeout(() => {
        modal.style.display = 'none';
      }, 300); // Match your CSS transition time
    }

    // Confirm delete function
    window.confirmDeletePost = function(postId) {
      const deleteModal = document.getElementById('deletePostModal');
      document.getElementById('deletePostForm').action =
        '<?php echo URLROOT; ?>/Shopkeepers/deletePost/' + postId;

      // First set display to flex
      deleteModal.style.display = 'flex';

      // Force browser reflow
      void deleteModal.offsetWidth;

      // Then add the show class
      setTimeout(() => {
        deleteModal.classList.add('show');
      }, 10);
    };

    // Close on clicking close button or outside the modal
    document.addEventListener('click', function(event) {
      // Close button handling
      if (event.target.classList.contains('close-btn')) {
        const modal = event.target.closest('.modal');
        if (modal) closeModal(modal);
      }

      // Reset button in delete modal
      if (event.target.classList.contains('reset-btn')) {
        const modal = event.target.closest('.modal');
        if (modal) closeModal(modal);
      }

      // Click outside modal
      if (event.target.classList.contains('modal')) {
        closeModal(event.target);
      }
    });

    // Image preview functionality
    function attachEventListeners() {
      const uploadPhotoInput = document.getElementById('upload-photo');
      const photoPreview = document.getElementById('post-preview');

      if (uploadPhotoInput && photoPreview) {
        // Preview image on select
        uploadPhotoInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              photoPreview.src = e.target.result;
              photoPreview.classList.add('has-image');
            };
            reader.readAsDataURL(file);
          }
        });

        // Trigger file input when clicking on preview area
        photoPreview.addEventListener('click', function() {
          uploadPhotoInput.click();
        });
      }

      // Add form validation if needed
      const postForm = document.getElementById('addPostForm') || document.getElementById('editPostForm');
      if (postForm) {
        postForm.addEventListener('submit', function(e) {
          // Add validation logic here if needed
        });
      }
    }
  });
</script>

<script src="<?php echo URLROOT; ?>/public/js/shopkeeper/portfolio-filters.js"></script>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>