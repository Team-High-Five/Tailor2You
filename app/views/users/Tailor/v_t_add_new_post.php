<div class="add-new-post-container">
  <div class="add-new-post-content">
    <div class="modal-header">
      <h1>Add New Post</h1>
      <button class="close-btn">&times;</button>
    </div>
    <form id="add-post-form" action="<?php echo URLROOT; ?>/tailors/addPost" method="post" enctype="multipart/form-data">
      <div class="upload-section">
        <div class="post-pic-wrapper">
          <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
        </div>
        <label for="upload-photo" class="upload-text">Upload Photo</label>
        <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
      </div>
      <div class="post-form-container">
        <div class="form-group">
          <label for="post-title">Title</label>
          <input type="text" id="post-title" name="title" placeholder="Enter a Title" required>
        </div>
        <div class="form-group">
          <label for="post-description">Description</label>
          <textarea id="post-description" name="description" placeholder="Enter a Description" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>
</div>