<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<section>
  <div class="tailor-section">
    <div class="tailor-section__header">
      <h1 class="tailor-section__title">My Cart</h1>
      <?php flash('cart_message'); ?>
      <?php flash('cart_error'); ?>
    </div>
    
    <?php if (empty($data['cart_items'])) : ?>
      <div class="empty-cart">
        <i class="fas fa-shopping-cart fa-3x"></i>
        <p>Your cart is empty</p>
        <a href="<?php echo URLROOT; ?>/pages" class="btn">Explore Designs</a>
      </div>
    <?php else : ?>
      <section class="product-grid">
        <?php foreach ($data['cart_items'] as $item) : ?>
          <div class="product-card">
            <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $item->design_image; ?>" alt="<?php echo $item->design_name; ?>">
            <h3 class="design-name"><?php echo $item->design_name; ?></h3>
            <p class="tailor">Tailor - <?php echo $item->tailor_name; ?></p>
            
            <p class="price">Rs. <?php echo number_format($item->base_price, 2); ?></p>
            <div class="cart-buttons">
              <a href="<?php echo URLROOT; ?>/Orders/selectFabric/<?php echo $item->design_id; ?>?cart_id=<?php echo $item->id; ?>" class="btn place-order-btn">
                <i class="fas fa-shopping-bag"></i> Place Order
              </a>
              <a href="<?php echo URLROOT; ?>/cart/remove/<?php echo $item->id; ?>" class="btn remove-btn">
                <i class="fas fa-trash"></i> Remove
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
      
      <div class="cart-actions">
        <a href="<?php echo URLROOT; ?>/cart/clear" class="clear-cart-btn" onclick="return confirm('Are you sure you want to clear your cart?')">
          <i class="fas fa-trash-alt"></i> Clear Cart
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<style>

</style>

<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>