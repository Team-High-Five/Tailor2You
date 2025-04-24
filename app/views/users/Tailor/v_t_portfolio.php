<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="portfolio-container">
    <div class="portfolio-header">
      <h2>My Portfolio</h2>
      <button class="btn-primary add-post-btn" id="openPostModalBtn">Add New Post</button>
    </div>

    <div class="portfolio-grid">
      <?php foreach ($data['posts'] as $post): ?>
        <div class="portfolio-item">
          <?php if (!empty($post->image)): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($post->image); ?>" alt="<?php echo $post->title; ?>">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/default_image.png" alt="<?php echo $post->title; ?>">
          <?php endif; ?>
          <h3><?php echo $post->title; ?></h3>
          <div class="portfolio-description">
            <p><?php echo $post->description; ?></p>
            <p class="created-date"><?php echo date('F j, Y', strtotime($post->created_at)); ?></p>
          </div>

          <div class="portfolio-actions">
            <button class="edit-btn" onclick="openEditPostModal(<?php echo $post->id; ?>)"><i class="fas fa-edit"></i></button>
            <button class="delete-btn" onclick="openDeletePostModal(<?php echo $post->id; ?>)"><i class="fas fa-trash-alt"></i></button>
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

<!-- Edit Post Modal -->
<div id="editPostModal" class="modal">
  <div id="edit-modal-body">
    <!-- Content from v_t_edit_post.php will be loaded here -->
  </div>
</div>

<!-- Delete Post Modal -->
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
      fetch('<?php echo URLROOT; ?>/tailors/addNewPost')
        .then(response => response.text())
        .then(html => {
          modalBody.innerHTML = html;
          attachEventListeners();
        });
    });

    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('close-btn') || event.target.id === 'postModal') {
        postModal.style.display = 'none';
      }
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

  function openEditPostModal(postId) {
    const editPostModal = document.getElementById('editPostModal');
    const editModalBody = document.getElementById('edit-modal-body');
    editPostModal.style.display = 'block';
    fetch('<?php echo URLROOT; ?>/tailors/editPost/' + postId)
      .then(response => response.text())
      .then(html => {
        editModalBody.innerHTML = html;
        attachEditEventListeners();
      });
  }

  function attachEditEventListeners() {
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

  function openDeletePostModal(postId) {
    const deletePostModal = document.getElementById('deletePostModal');
    const deletePostForm = document.getElementById('deletePostForm');
    deletePostForm.action = '<?php echo URLROOT; ?>/tailors/deletePost/' + postId;
    deletePostModal.style.display = 'block';
  }

  function closeDeletePostModal() {
    document.getElementById('deletePostModal').style.display = 'none';
  }

  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('close-btn') || event.target.id === 'editPostModal') {
      document.getElementById('editPostModal').style.display = 'none';
    }
    if (event.target.classList.contains('close-btn') || event.target.id === 'deletePostModal') {
      document.getElementById('deletePostModal').style.display = 'none';
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>