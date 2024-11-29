<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

  <div class="container">
    <!-- Shirt Section -->
    <div class="shirt-image">
      <img src="<?php echo URLROOT; ?>/public/img/designs/man.jpg" alt="Shirt Image">
    </div>

    <!-- Collar Selection Section -->
    <div class="collar-section">
      <h3>Select a Collar Style:</h3>
      <div class="dropdown">
        <select id="collar-select" onchange="updateCollarImage()">
          <option value="1">Style 1</option>
          <option value="2">Style 2</option>
          <option value="3">Style 3</option>
          <option value="4">Style 4</option>
          <option value="5">Style 5</option>
          <option value="6">Style 6</option>
          <option value="7">Style 7</option>
          <option value="8">Style 8</option>
          <option value="4">Style 9</option>
          <option value="5">Style 10</option>
          <option value="6">Style 11</option>
          <option value="7">Style 12</option>
          <option value="8">Style 13</option>
          <option value="7">Style 14</option>
          <option value="8">Style 15</option>
        </select>
      </div>
      <img id="collar-image" src="<?php echo URLROOT; ?>/public/img/designs/collar1.jpg" alt="Collar Style">
    </div>
  </div>

  <script>
    function updateCollarImage() {
      const collarSelect = document.getElementById('collar-select');
      const collarImage = document.getElementById('collar-image');
      const selectedValue = collarSelect.value;

      // Update the collar image based on the selected value
      collarImage.src = `collar-${selectedValue}.jpg`; // Assumes filenames like collar-1.jpg, collar-2.jpg, etc.
    }
  </script>
</body>
</html>
