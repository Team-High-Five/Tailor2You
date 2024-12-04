<div class="new-collection">
  <div class="topic">New collection</div>
  <section class="product-grid">
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/designs/me6.jpeg" alt="White Shirt">
      <p class="tailor">Tailor - B.A.Bandara</p>
      <p class="price">Rs. 3500</p>
      <div class="buttons">
        <button class="add-to-cart" onclick="selectFabric()">Add to Cart</button>
        <button class="place-order" onclick="selectFabric()">Place Order</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/designs/design1.jpeg" alt="Patterned Shirt">
      <p class="tailor">Tailor - B.A.Bandara</p>
      <p class="price">Rs. 3500</p>
      <div class="buttons">
        <button class="add-to-cart" onclick="selectFabric()">Add to Cart</button>
        <button class="place-order" onclick="selectFabric()">Place Order</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/designs/desi2.jpeg" alt="Navy Shirt">
      <p class="tailor">Tailor - B.A.Bandara</p>
      <p class="price">Rs. 3500</p>
      <div class="buttons">
        <button class="add-to-cart" onclick="selectFabric()">Add to Cart</button>
        <button class="place-order" onclick="selectFabric()">Place Order</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/home/men4.jpeg" alt="Green Shirt">
      <p class="tailor">Tailor - B.A.Bandara</p>
      <p class="price">Rs. 3500</p>
      <div class="buttons">
        <button class="add-to-cart" onclick="selectFabric()">Add to Cart</button>
        <button class="place-order" onclick="selectFabric()">Place Order</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/designs/desi4.jpeg" alt="Beige Shirt">
      <p class="tailor">Tailor - B.A.Bandara</p>
      <p class="price">Rs. 3500</p>
      <div class="buttons">
        <button class="add-to-cart" onclick="selectFabric()">Add to Cart</button>
        <button class="place-order" onclick="selectFabric()">Place Order</button>
      </div>
    </div>
    <div class="product-card">
      <img src="<?php echo URLROOT; ?>/public/img/designs/me8.jpeg" alt="Dark Blue Shirt">
      <p class="tailor">Tailor - B.A.Bandara</p>
      <p class="price">Rs. 3500</p>
      <div class="buttons">
        <button class="add-to-cart" onclick="selectFabric()">Add to Cart</button>
        <button class="place-order" onclick="selectFabric()">Place Order</button>
      </div>
    </div>
  </section>
</div>

<script>
  function selectFabric() {
    window.location.href = '<?php echo URLROOT; ?>/designs/selectFabric';
  }
</script>