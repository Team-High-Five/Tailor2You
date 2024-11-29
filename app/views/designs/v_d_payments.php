<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

  <div class="payment-modal">
    <span class="close-btn">&times;</span>
    <h2>Provide further information</h2>
    <p>✅ Your payment information is safe with us</p>

    <div class="card-icons">
      <img src="<?php echo URLROOT; ?>/public/img/designs/visa.png" alt="Visa">
      <img src="<?php echo URLROOT; ?>/public/img/designs/mastercard.png" alt="MasterCard">
      <img src="<?php echo URLROOT; ?>/public/img/designs/amex.jpg" alt="American Express">
      <img src="<?php echo URLROOT; ?>/public/img/designs/discover.png" alt="Discover">
    </div>

    <form>
      <div class="form-group">
        <label for="card-number">Card Number</label>
        <input type="text" id="card-number" placeholder="Enter card number">
      </div>

      <div class="form-group">
        <label for="cardholder-name">Cardholder Name</label>
        <input type="text" id="cardholder-name" placeholder="Enter your name">
      </div>

      <div class="form-group">
        <label for="expiry-date">Expiry Date</label>
        <div style="display: flex; gap: 10px;">
          <select id="expiry-month">
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
          <select id="expiry-year">
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
        <input type="text" id="cvv" placeholder="CVV">
      </div>

      <div class="save-card">
        <input type="checkbox" id="save-card">
        <label for="save-card">Save card details</label>
      </div>

      <p class="warning-text">⚠️ Your order will be processed in USD</p>

      <button type="button" class="btn-save">Save & confirm</button>
    </form>
  </div>
</body>
</html>
