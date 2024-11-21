<div class="add-new-customization-container">
  <div class="add-new-customization-content">
    <div class="modal-header">
      <h1>Add New Customization</h1>
      <a href="<?php echo URLROOT ?>/Tailors/displayCustomizeItems"><button class="close-btn">&times;</button></a> 
    </div>
    <div class="customization-form-container">
      <form>
        <div class="form-group">
          <label class="title">Gender</label>
          <div class="radio-group">
            <label><input type="radio" name="gender" value="gents"> Gents</label>
            <label><input type="radio" name="gender" value="ladies"> Ladies</label>
          </div>
        </div>
        <div class="form-group">
          <label for="category">Category</label>
          <select id="category">
            <option>Category</option>
            <option>Shirts</option>
            <option>Trousers</option>
          </select>
        </div>
        <div class="form-group">
          <label for="sub-category">Sub Category</label>
          <select id="sub-category">
            <option>Sub Category</option>
            <option>Formal</option>
            <option>Casual</option>
          </select>
        </div>
        <button type="submit" class="submit-btn">Continue</button>
      </form>
    </div>
  </div>
</div>