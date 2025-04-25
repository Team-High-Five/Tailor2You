<div class="new-collection">
<?php if($data['gender']=='gents') : ?>
  <div class="topic">Gents Collection</div>
<?php elseif($data['gender']=='ladies'): ?>  
  <div class="topic">Ladies Collection</div>
  <?php else: ?>
  <div class="topic">New Collection</div>
<?php endif; ?>
  <section class="product-grid">
    <?php if (!empty($data['designs'])) : ?>
      <?php foreach ($data['designs'] as $design) : ?>
        <div class="product-card">
          <?php if (!empty($design->main_image)) : ?>
            <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $design->main_image; ?>" alt="<?php echo $design->name; ?>"
              onerror="this.src='<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg'">
          <?php else : ?>
            <img src="<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg" alt="Design Image">
          <?php endif; ?>

          <p class="design-name"><?php echo $design->name; ?></p>
          <p class="tailor">Tailor - <?php echo $design->tailor_name; ?></p>
          <p class="price">Rs. <?php echo number_format($design->base_price, 2); ?></p>

          <div class="buttons">
            <button class="add-to-cart" onclick="selectFabric(<?php echo $design->design_id; ?>)">Add to Cart</button>
            <button class="place-order" onclick="selectFabric(<?php echo $design->design_id; ?>)">Design Customize</button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="no-designs">
        <p>No designs available at the moment.</p>
      </div>
    <?php endif; ?>
  </section>
</div>

<script>
  function selectFabric(designId) {
    window.location.href = '<?php echo URLROOT; ?>/Orders/selectFabric/' + designId;
  }
</script>