<div class="customization-form-container">
  <form action="<?php echo URLROOT; ?>/tailors/addNewCustomizeItem" method="POST">
    <div class="form-group">
      <label>Gender</label>
      <div class="radio-group">
        <label><input type="radio" name="gender" value="gents"> Gents</label>
        <label><input type="radio" name="gender" value="ladies"> Ladies</label>
      </div>
    </div>
    <div class="form-group">
      <label for="category">Category</label>
      <select id="category" name="category">
        <option>Category</option>
        <option>Shirts</option>
        <option>Trousers</option>
      </select>
    </div>
    <div class="form-group">
      <label for="sub-category">Sub Category</label>
      <select id="sub-category" name="sub_category">
        <option>Sub Category</option>
        <option>Formal</option>
        <option>Casual</option>
      </select>
    </div>
    <button type="submit" class="submit-btn">Continue</button>
  </form>
</div>