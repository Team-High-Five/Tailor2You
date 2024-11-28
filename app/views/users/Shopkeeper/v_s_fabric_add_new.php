<div class="add-new-fabric-container">
  <div class="add-new-fabric-content">
    <div class="modal-header">
      <h1>Add New Fabric</h1>
      <a href="<?php echo URLROOT ?>/Shopkeepers/displayFabricStock"><button class="close-btn">&times;</button></a>
    </div>
    <div class="upload-section">
      <div class="upload-icon">📷</div>
      <a href="#" class="upload-text">Upload Photo</a>
    </div>
    <div class="fabric-form-container">
      <form>
        <div class="form-group">
          <label for="fabric-name">Fabric Name</label>
          <input type="text" id="fabric-name" placeholder="Enter Fabric name">
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="text" id="price" placeholder="Enter Price">
        </div>
        <div class="form-group">
          <label for="color">Color</label>
          <div class="color-options">
            <span class="color-circle black"></span>
            <span class="color-circle red"></span>
            <span class="color-circle blue"></span>
            <span class="color-circle purple"></span>
            <span class="color-circle orange"></span>
            <span class="color-circle yellow"></span>
          </div>
        </div>
        <div class="form-group">
          <label for="stock">Stock</label>
          <input type="text" id="stock" placeholder="Enter Quantity">
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
  </div>
</div>