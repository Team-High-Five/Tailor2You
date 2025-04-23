<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="measurement-page-container">
  <div class="measurement-form-container">
    <div class="success-header">
      <span>Payment Information</span>
    </div>
    <form>
      <div class="card-icons">
        <img src="<?php echo URLROOT; ?>/public/img/designs/visa.png" alt="Visa">
        <img src="<?php echo URLROOT; ?>/public/img/designs/mastercard.png" alt="MasterCard">
        <img src="<?php echo URLROOT; ?>/public/img/designs/amex.jpg" alt="American Express">
        <img src="<?php echo URLROOT; ?>/public/img/designs/discover.png" alt="Discover">
      </div>

      <div class="form-group">
        <label for="card-number">Card Number</label>
        <input type="text" id="card-number" class="select" placeholder="Enter card number">
      </div>

      <div class="form-group">
        <label for="cardholder-name">Cardholder Name</label>
        <input type="text" id="cardholder-name" class="select" placeholder="Enter your name">
      </div>

      <div class="form-group">
        <label for="expiry-date">Expiry Date</label>
        <div style="display: flex; gap: 10px;">
          <select id="expiry-month" class="select">
            <option value="">MM</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
          <select id="expiry-year" class="select">
            <option value="">YY</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" class="select" placeholder="CVV">
      </div>

      <div class="save-card">
        <input type="checkbox" id="save-card">
        <label for="save-card">Save card details</label>
      </div>

      <p class="warning-text">⚠️ Your order will be processed in USD</p>

      <div class="action-buttons">
        <a href="<?php echo URLROOT ?>/Designs/placedOrder" class="request-button">Save & Confirm</a>
        <a href="<?php echo URLROOT ?>/Designs/placedOrder" class="skip-button">Cancel</a>
      </div>
    </form>
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