<div class="add-new-post-container">
  <div class="add-new-post-content">
    <div class="modal-header">
      <h1>Edit Post</h1>
      <button class="close-btn">&times;</button>
    </div>
    <form id="edit-post-form" action="<?php echo URLROOT; ?>/tailors/editPost/<?php echo $data['post_id']; ?>" method="post" enctype="multipart/form-data">
      <div class="upload-section">
        <div class="post-pic-wrapper">
          <?php if (!empty($data['image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($data['image']); ?>" alt="Post Picture" id="post-preview">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
          <?php endif; ?>
        </div>
       
        <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
      </div>
      <div class="post-form-container">
        <div class="form-group">
          <label for="post-title">Title</label>
          <input type="text" id="post-title" name="title" placeholder="Enter a Title" value="<?php echo $data['title']; ?>" required>
        </div>
        <div class="form-group">
          <label for="post-description">Description</label>
          <textarea id="post-description" name="description" placeholder="Enter a Description" required><?php echo $data['description']; ?></textarea>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
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
  });
</script>