<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
  <div class="design-details-container">
    <div class="cuff-form">
      <div class="cuff-header">
        <span>Select a Collar Style</span>
      </div>
      <section class="cuff-grid">
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar1.png" alt="Cuff 1">
          <p class="cuff-name">Collar 1</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar2.png" alt="Cuff 2">
          <p class="cuff-name">Collar 2</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar3.png" alt="Cuff 3">
          <p class="cuff-name">Collar 3</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar4.png" alt="Cuff 4">
          <p class="cuff-name">Collar 4</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar5.png" alt="Cuff 5">
          <p class="cuff-name">Collar 5</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar6.png" alt="Cuff 5">
          <p class="cuff-name">Collar 6</p>
          <div class="buttons">
            <button>Select</button>
          </div>
        </div>
        <div class="cuff-card">
          <img src="<?php echo URLROOT; ?>/public/img/designs/collar7.png" alt="Cuff 5">
          <p class="cuff-name">Collar 7</p>
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