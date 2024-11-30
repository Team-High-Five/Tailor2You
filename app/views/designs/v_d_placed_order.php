<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

  <div class="body">
  <div class="order-container">

    <div><img src="<?php echo URLROOT; ?>/public/img/designs/design1.jpeg" alt="Shirt Preview"></div>
    
    <div class="rightpart">
      <div class="text">
      <div class="order-header">Order Placed!</div>
      <div class="order-details">
        <p><strong>Order #1067907</strong></p>
        <p>Fabric - Thin cotton</p>
        <p>Color - Black Green</p>
        <p>Rs.2750</p>
        <p>Placed on 02/09/2024</p>       
        <div class="tailor-info">
          <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor">
          <p><strong>Tailor</strong> - Pieris M.P</p>
        </div>
      </div>
    </div>
    <br>
      <div class="order-buttons">
      <button class="view_order">View Order</button>
        <div class="hover-button">
            <a href="#"><button class="payment">Go to Payments</button></a>
            <div class="hover-buttons">
              <div class="hover-buttons_in">
                <a href="<?php echo URLROOT ?>/Designs/payments"><button class="button1">Online Payments</button></a>
                <a href="<?php echo URLROOT ?>/Designs/appointment"><button class="button2">Cash on Delivery</button></a>
              </div>
            </div>
          </div>
      </div>
      </div>
  </div>
</div>
</body>

