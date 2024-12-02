<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section>
  <div class="tailor-section">
    <div class="tailor-section__header">
      <h1 class="tailor-section__title">My Cart</h1>
    </div>
    <section class="product-grid">
      <div class="product-card">
        <img src="<?php echo URLROOT; ?>/public/img/designs/desi2.jpeg" alt="White Shirt">
        <p class="tailor">Tailor - B.A.Bandara</p>
        <p class="price">Rs. 3500</p>
        <div class="buttons">

          <button>Place Order</button>
        </div>
      </div>
      <div class="product-card">
        <img src="<?php echo URLROOT; ?>/public/img/designs/still-life-with-classic-shirts-hanger.jpg" alt="White Shirt">
        <p class="tailor">Tailor - B.A.Bandara</p>
        <p class="price">Rs. 3500</p>
        <a href="<?php echo URLROOT; ?> /designs/placedOrder">
          <div class="buttons">
            <button>Place Order</button>
          </div>
        </a>
      </div>
      <div class="product-card">
        <img src="<?php echo URLROOT; ?>/public/img/designs/desi3.jpeg" alt="Patterned Shirt">
        <p class="tailor">Tailor - B.A.Bandara</p>
        <p class="price">Rs. 3500</p>
        <div class="buttons">

          <button>Place Order</button>
        </div>
      </div>
      <div class="product-card">
        <img src="<?php echo URLROOT; ?>/public/img/designs/desi4.jpeg" alt="Patterned Shirt">
        <p class="tailor">Tailor - B.A.Bandara</p>
        <p class="price">Rs. 3500</p>
        <div class="buttons">

          <button>Place Order</button>
        </div>
      </div>
    </section>
  </div>
</section>
<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>