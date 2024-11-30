<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
  <div class="design-details-container">
    <div class="cuff-form">
      <div class="cuff-header">
        <span>Select a Cuff Style</span>
      </div>
      <section class="cuff-grid">
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/cuff-type-1.png" alt="Cuff 1">
          <p class="cuff-name">Cuff 1</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/cuff-type-2.png" alt="Cuff 2">
          <p class="cuff-name">Cuff 2</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/cuff-type-3.png" alt="Cuff 3">
          <p class="cuff-name">Cuff 3</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/cuff-type-4.png" alt="Cuff 4">
          <p class="cuff-name">Cuff 4</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/cuff-type-5.png" alt="Cuff 5">
          <p class="cuff-name">Cuff 5</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
      </section>
      <div class="continue-button">
        <a href="<?php echo URLROOT ?>/Designs/enterMeasurement"><button class="continue-btn">Continue</button></a>
      </div>
    </div>
  </div>
  <div class="design-image-container">
    <img src="<?php echo URLROOT; ?>/public/img/designs/still-life-with-classic-shirts-hanger.jpg" alt="Shirt Image">
    <div class="design-details">
      <div class="design-name">
        <span>Design Name</span>
      </div>
      <div class="design-description">
        <span>Design Description</span>
      </div>
    </div>
  </div>
</div>
</body>

</html>