
  <div class="modal-content">
    <div class="modal-header">
      <h1>Add New Design</h1>
      <a href="<?php echo URLROOT; ?>/Tailors/displayCustomizeItems"><button class="close-btn">&times;</button></a>
    </div>
    <form action="<?php echo URLROOT; ?>/Designs/addNewCustomizeItem" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Gender</label>
        <div class="radio-group">
          <label><input type="radio" name="gender" value="gents" required> Gents</label>
          <label><input type="radio" name="gender" value="ladies"> Ladies</label>
          <label><input type="radio" name="gender" value="unisex"> Unisex </label>
        </div>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category_id" required>
          <option value="">Select Category</option>
          <?php foreach ($data['categories'] as $category): ?>
            <option value="<?php echo $category->category_id; ?>" data-gender="<?php echo $category->gender_specific; ?>">
              <?php echo $category->name; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="sub-category">Sub Category</label>
        <select id="sub-category" name="subcategory_id" required>
          <option value="">Select Sub Category</option>
        </select>
      </div>
      <div class="form-group">
        <label for="design-name">Design Name</label>
        <input type="text" id="design-name" name="design_name" required>
      </div>
      <div class="form-group">
        <label for="base-price">Base Price (Rs)</label>
        <input type="number" id="base-price" name="base_price" step="10" value="0.00" min="0" required>
      </div>
      <button type="submit" class="submit-btn">Continue</button>
    </form>
  </div>
