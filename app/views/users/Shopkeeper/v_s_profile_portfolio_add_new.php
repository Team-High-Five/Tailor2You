<div class="add-new-post-container">
  <div class="add-new-post-content">
    <div class="modal-header">
      <h1>Add New Post</h1>
      <button class="close-btn">&times;</button>
    </div>
    <form id="add-post-form" action="<?php echo URLROOT; ?>/shopkeepers/addPost" method="post" enctype="multipart/form-data">
      <div class="upload-section">
        <div class="post-pic-wrapper">
          <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Picture" id="post-preview">
        </div>
        
        <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;" required>
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
        
        <!-- Gender selection -->
        <div class="form-group">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="men">Men</option>
            <option value="women">Women</option>
            <option value="unisex">Unisex</option>
          </select>
        </div>
        
        <!-- Item Type selection -->
        <div class="form-group">
          <label for="item-type">Item Type</label>
          <select id="item-type" name="item_type" required>
            <option value="">Select Item Type</option>
            <option value="shirt">Shirt</option>
            <option value="pant">Pant</option>
            <option value="frock">Frock</option>
            <option value="skirt">Skirt</option>
            <option value="blouse">Blouse</option>
          </select>
        </div>
        
        <button type="submit" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>
</div>

