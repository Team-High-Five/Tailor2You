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
            <button class="btn-primary edit-btn">Edit</button>
            <button class="btn-danger delete-btn">Delete</button>
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
</script>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>