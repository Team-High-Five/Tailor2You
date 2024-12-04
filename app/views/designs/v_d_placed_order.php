<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="order-confirmation-container">
  <div class="order-details-card">
    <div class="success-header">
      <span>Order Created!</span>
    </div>

    <div class="order-info">
      <p><strong>Order #1067907</strong></p>
      <p>Fabric - <strong>Thin cotton</strong></p>
      <p>Color - <strong>Black Green</strong></p>
      <p>Rs.<strong>2750</strong></p>
      <p>Placed on <strong>02/09/2024</strong></p>
    </div>

    <div class="tailor-profile">
      <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor Profile">
      <p><strong>Tailor</strong> - Pieris M.P</p>
    </div>

    <div class="action-group">
      <a href="#" class="primary-btn">View Order</a>
      <a href="<?php echo URLROOT ?>/Customers/cart" class="secondary-btn">Add to Cart</a>
    </div>

    <div class="payment-options">
      <a href="<?php echo URLROOT ?>/Designs/payments" class="payment-option">
        Online Payments
      </a>
      <a href="<?php echo URLROOT ?>/Designs/appointment" class="payment-option">
        Cash on Delivery
      </a>
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