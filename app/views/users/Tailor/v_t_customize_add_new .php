<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="card">
  <button class="close-btn">&times;</button>
  <h2>Customize</h2>
  <div class="form-group">
    <label>Gender</label>
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
  <button class="continue-btn">Continue</button>
</div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>