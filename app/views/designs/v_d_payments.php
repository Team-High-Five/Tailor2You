<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="payment-container">
  <div class="payment-content">
    <div class="payment-header">
      <span>Payment</span>
      <p>Complete your payment to finalize your order</p>
    </div>

    <!-- Order Summary -->
    <div class="payment-summary">
      <div class="summary-row">
        <span class="summary-label">Subtotal:</span>
        <span class="summary-value">Rs. <?php echo number_format($_SESSION['order_details']['subtotal'], 2); ?></span>
      </div>

      <div class="summary-row">
        <span class="summary-label">Platform Fee (12%):</span>
        <span class="summary-value">Rs. <?php echo number_format($_SESSION['order_details']['platform_fee'], 2); ?></span>
      </div>

      <div class="summary-row total">
        <span class="summary-label">Total Amount:</span>
        <span class="summary-value">Rs. <?php echo number_format($_SESSION['order_details']['total_price'], 2); ?></span>
      </div>
    </div>

    <!-- Payment Form -->
    <form action="<?php echo URLROOT; ?>/Orders/processPayment" method="post" id="paymentForm">
      <!-- Payment Method Selector -->
      <div class="payment-methods">
        <h3>Select Payment Method</h3>

        <div class="payment-method-options">
          <div class="payment-option">
            <input type="radio" name="payment_method" id="card_payment" value="card" checked>
            <label for="card_payment">
              <span class="payment-icon"><i class="fas fa-credit-card"></i></span>
              <span class="payment-name">Credit/Debit Card</span>
            </label>
          </div>

          <div class="payment-option">
            <input type="radio" name="payment_method" id="cash_delivery" value="cod">
            <label for="cash_delivery">
              <span class="payment-icon"><i class="fas fa-money-bill-wave"></i></span>
              <span class="payment-name">Cash on Delivery</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Card Payment Form (shown/hidden based on selection) -->
      <div class="card-payment-form" id="cardPaymentSection">
        <div class="form-group">
          <label for="card_number">Card Number</label>
          <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
        </div>

        <div class="card-details">
          <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" maxlength="5">
          </div>

          <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
          </div>
        </div>

        <div class="form-group">
          <label for="card_name">Name on Card</label>
          <input type="text" id="card_name" name="card_name" placeholder="John Smith">
        </div>
      </div>

      <!-- Simulated Processing Message -->
      <div class="simulated-message">
        <p><i class="fas fa-info-circle"></i> This is a demonstration project. No real payment will be processed.</p>
      </div>

      <div class="action-buttons">
        <a href="<?php echo URLROOT; ?>/Orders/reviewOrder" class="back-btn">Back to Review</a>
        <button type="submit" class="pay-btn">Complete Order</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Format card number with spaces
    document.getElementById('card_number').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\s+/g, '');
      if (value.length > 0) {
        value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
      }
      e.target.value = value;
    });

    // Format expiry date with slash
    document.getElementById('expiry_date').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length > 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
      }
      e.target.value = value;
    });

    // Show/hide card payment form based on payment method selection
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const cardSection = document.getElementById('cardPaymentSection');

    paymentMethods.forEach(method => {
      method.addEventListener('change', function() {
        if (this.value === 'card') {
          cardSection.style.display = 'block';
        } else {
          cardSection.style.display = 'none';
        }
      });
    });

    // Form validation
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
      const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

      if (paymentMethod === 'card') {
        const cardNumber = document.getElementById('card_number').value.replace(/\s+/g, '');
        const expiryDate = document.getElementById('expiry_date').value;
        const cvv = document.getElementById('cvv').value;
        const cardName = document.getElementById('card_name').value;

        let isValid = true;

        // Simple validation
        if (cardNumber.length !== 16) {
          alert('Please enter a valid 16-digit card number');
          isValid = false;
        }

        if (!expiryDate.match(/^\d{2}\/\d{2}$/)) {
          alert('Please enter a valid expiry date (MM/YY)');
          isValid = false;
        }

        if (cvv.length < 3) {
          alert('Please enter a valid CVV');
          isValid = false;
        }

        if (cardName.trim() === '') {
          alert('Please enter the name on your card');
          isValid = false;
        }

        if (!isValid) {
          e.preventDefault();
        }
      }
    });
  });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>