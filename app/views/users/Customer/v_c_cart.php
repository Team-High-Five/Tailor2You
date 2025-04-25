<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
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
            <div class="product-details">
              <span class="fabric"><?php echo $item->fabric_name; ?></span>
              <span class="color-dot" style="background-color: <?php echo $item->color_name; ?>;" title="<?php echo $item->color_name; ?>"></span>
            </div>
            <p class="price">Rs. <?php echo number_format($item->base_price, 2); ?></p>
            <div class="buttons">
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
.empty-cart {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  text-align: center;
  background-color: var(--white-color);
  border-radius: 10px;
  box-shadow: var(--card-shadow);
  margin: 20px auto;
  max-width: 500px;
}

.empty-cart i {
  color: var(--primary-color);
  margin-bottom: 20px;
  opacity: 0.7;
}

.empty-cart p {
  font-size: 1.2rem;
  margin-bottom: 25px;
  color: var(--text-muted);
}

.empty-cart .btn {
  background: var(--primary-gradient);
  color: white;
  padding: 12px 25px;
  text-decoration: none;
  border-radius: 6px;
  font-weight: 500;
  transition: var(--transition);
}

.empty-cart .btn:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow);
}

.design-name {
  font-size: 1.1rem;
  margin: 12px 0 5px;
  color: var(--text-dark);
}

.product-details {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 5px 0 8px;
}

.fabric {
  font-size: 0.85rem;
  color: var(--text-muted);
}

.color-dot {
  display: inline-block;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  border: 1px solid rgba(0,0,0,0.1);
}

.buttons {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 10px;
}

.place-order-btn, .remove-btn {
  width: 100%;
  text-align: center;
  padding: 8px 0;
  border-radius: 5px;
  transition: var(--transition);
  font-size: 0.9rem;
}

.place-order-btn {
  background: var(--primary-gradient);
  color: white;
}

.place-order-btn:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow);
}

.remove-btn {
  background: rgba(244, 67, 54, 0.1);
  color: var(--error-color);
}

.remove-btn:hover {
  background: rgba(244, 67, 54, 0.2);
}

.cart-actions {
  display: flex;
  justify-content: flex-end;
  margin: 30px 0;
  padding-right: 20px;
}

.clear-cart-btn {
  background: var(--error-color);
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 0.9rem;
  transition: var(--transition);
}

.clear-cart-btn:hover {
  background: var(--danger-dark-color);
}

@media (max-width: 768px) {
  .product-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
}

@media (max-width: 480px) {
  .product-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  }
  
  .cart-actions {
    justify-content: center;
    padding-right: 0;
  }
}
</style>

<?php require_once APPROOT . '/views/pages/inc/footer.php'; ?>