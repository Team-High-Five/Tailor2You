<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<!-- slider -->
<?php require_once APPROOT . '/views/pages/inc/components/slidebar.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/pages/genderSelect.css">

  <!-- First UI Section -->
  <div id="section1" class="ui-section">
    <div class="main-banner">
      <div class="banner-item">
        <img src="<?php echo URLROOT; ?>/public/img/home/men222.jpg" alt="Men" class="banner-image">
        <button id="mensButton" class="category-button">Men</button>
      </div>
      <div class="banner-item">
        <img src="<?php echo URLROOT; ?>/public/img/home/womene222.jpg" alt="Women" class="banner-image">
        <button class="category-button">Women</button>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
