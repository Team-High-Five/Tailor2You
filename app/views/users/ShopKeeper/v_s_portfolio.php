<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="portfolio-container">
    <div class="portfolio-header">
      <h2>Portfolio</h2>
      <button class="btn-primary add-post-btn" id="openPostModalBtn">Add New Post</button>
    </div>

    <!-- Portfolio Grid -->
    <div class="portfolio-grid">
      <?php foreach ($data['posts'] as $post): ?>
        <div class="portfolio-item">
          <?php if (!empty($post->image)): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($post->image); ?>" alt="<?php echo $post->title; ?>">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/default_image.png" alt="<?php echo $post->title; ?>">
          <?php endif; ?>
          <h3><?php echo $post->title; ?></h3>
          <p><?php echo $post->description; ?></p>
          <p class="created-date"><?php echo date('F j, Y', strtotime($post->created_at)); ?></p>
          <div class="portfolio-actions">
            <button class="btn-primary edit-btn" data-post-id="<?php echo $post->id; ?>">Edit</button>
            <button class="btn-danger delete-btn" onclick="confirmDeletePost(<?php echo $post->id; ?>)">Delete</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="postModal" class="modal">
  <div id="modal-body">
    <!-- Content from v_t_add_new_post.php will be loaded here -->
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deletePostModal" class="modal">
  <div class="delete-modal-content">
    <div class="modal-header">
      <h1>Confirm Deletion</h1>
      <button class="close-btn" onclick="closeDeletePostModal()">&times;</button>
    </div>
    <div class="delete-modal-body">
      <p>Are you sure you want to delete this post?</p>
      <form id="deletePostForm" action="" method="post">
        <button type="submit" class="submit-btn">Yes, Delete</button>
        <button type="button" class="reset-btn" onclick="closeDeletePostModal()">Cancel</button>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const openPostModalBtn = document.getElementById('openPostModalBtn');
    const postModal = document.getElementById('postModal');
    const modalBody = document.getElementById('modal-body');

    openPostModalBtn.addEventListener('click', function() {
      postModal.style.display = 'block';
      // Load the content of v_t_add_new_post.php into the modal
      fetch('<?php echo URLROOT; ?>/tailors/addNewPost')
        .then(response => response.text())
        .then(html => {
          modalBody.innerHTML = html;
          attachEventListeners(); // Attach event listeners after content is loaded
        });
    });

    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('close-btn') || event.target.id === 'postModal') {
        postModal.style.display = 'none';
      }
    });

    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        postModal.style.display = 'block';
        // Load the content of the edit post view into the modal
        fetch('<?php echo URLROOT; ?>/shopkeepers/editPost/' + postId)
          .then(response => response.text())
          .then(html => {
            modalBody.innerHTML = html;
            attachEventListeners(); // Attach event listeners after content is loaded
          });
      });
    });

    function attachEventListeners() {
      const uploadPhotoInput = document.getElementById('upload-photo');
      const photoPreview = document.getElementById('post-preview');

      uploadPhotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            photoPreview.src = e.target.result;
          }
          reader.readAsDataURL(file);
        }
      });

      photoPreview.addEventListener('click', function() {
        uploadPhotoInput.click();
      });
    }
  });

  function confirmDeletePost(postId) {
    const deletePostModal = document.getElementById('deletePostModal');
    deletePostModal.style.display = 'block';
    document.getElementById('deletePostForm').action = '<?php echo URLROOT; ?>/shopkeepers/deletePost/' + postId;
  }

  function closeDeletePostModal() {
    document.getElementById('deletePostModal').style.display = 'none';
  }

  // Close modal when clicking on close button or outside
  window.addEventListener('click', function(event) {
    const deletePostModal = document.getElementById('deletePostModal');
    if (event.target == deletePostModal) {
      deletePostModal.style.display = 'none';
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>