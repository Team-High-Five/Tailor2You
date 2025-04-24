<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="item-details-container">
    <div class="details-header">
      <h2>Order #<?php echo $data['order']->order_id; ?></h2>
      <a href="<?php echo URLROOT ?>/Tailors/displayOrders">
        <button class="close-button">&times;</button>
      </a>
    </div>
    <?php if (!empty($data['order']->items)): ?>
      <?php $item = $data['order']->items[0]; // Display first item details 
      ?>
      <div class="details-content">
        <div class="product-showcase">
          <?php
          $imagePath = !empty($item->design_image)
            ? URLROOT . '/public/img/uploads/designs/' . $item->design_image
            : URLROOT . '/public/img/default_design.png';
          ?>
          <img src="<?php echo $imagePath; ?>" alt="<?php echo $item->design_name; ?>" class="product-image">
          <h3 class="product-title"><?php echo $item->design_name; ?></h3>
          <p class="product-price">Rs. <?php echo number_format($item->total_price, 2); ?></p>

          <div class="color-options">
            <div class="color-option" style="background-color: <?php echo $item->color_name; ?>;" title="<?php echo $item->color_name; ?>"></div>
          </div>

          <div class="customer-details">
            <?php
            $profilePic = !empty($data['order']->profile_pic)
              ? 'data:image/jpeg;base64,' . base64_encode($data['order']->profile_pic)
              : URLROOT . '/public/img/user_avatar.png';
            ?>
            <img src="<?php echo $profilePic; ?>" alt="Customer Profile" class="customer-avatar">
            <div>
              <p class="customer-name"><?php echo $data['order']->first_name . ' ' . $data['order']->last_name; ?></p>
              <p class="customer-id">Customer ID: #<?php echo $data['order']->customer_id; ?></p>
            </div>
          </div>
        </div>

        <div class="specifications">
          <ul class="spec-list">
            <?php if (!empty($item->measurements)): ?>
              <?php foreach ($item->measurements as $measurement): ?>
                <li class="spec-item">
                  <span class="spec-label"><?php echo $measurement->display_name; ?>:</span>
                  <span><?php echo $measurement->value; ?> cm</span>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="spec-item">
                <span class="spec-label">No measurements provided</span>
              </li>
            <?php endif; ?>
          </ul>

          <div class="care-instructions">
            <h4>Order Details</h4>
            <p>• Ordered On: <?php echo $data['order']->formatted_date; ?></p>
            <p>• Fabric: <?php echo $item->fabric_name; ?></p>
            <p>• Color: <?php echo $item->color_name; ?></p>
            <p>• Expected Delivery: <?php echo date('d M Y', strtotime($data['order']->expected_delivery_date)); ?></p>

            <?php if (!empty($data['order']->notes)): ?>
              <p>• Notes: <?php echo $data['order']->notes; ?></p>
            <?php endif; ?>

            <small class="disclaimer">
              * Please ensure all measurements are correct before proceeding
            </small>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="no-items-found">
        <p>No items found for this order.</p>
      </div>
    <?php endif; ?>

    <?php if ($data['order']->status !== 'cancelled' && $data['order']->status !== 'delivered'): ?>
      <div class="status-update-section">
        <h4>Update Order Status</h4>
        <div class="current-status-display">
          <p>Current Status:
            <span class="status-badge <?php echo str_replace('_', '-', $data['order']->status); ?>">
              <?php echo $data['statusOptions'][$data['order']->status]; ?>
            </span>
          </p>
        </div>

        <form action="<?php echo URLROOT; ?>/Tailors/updateOrderStatus/<?php echo $data['order']->order_id; ?>" method="POST" class="status-form">
          <div class="form-group">
            <label for="status">Change Status To:</label>
            <select name="status" id="status" class="form-select">
              <?php
              // Get the current index in the status flow
              $statusKeys = array_keys($data['statusOptions']);
              $currentIndex = array_search($data['order']->status, $statusKeys);

              // Only show statuses that come after the current one
              for ($i = $currentIndex + 1; $i < count($statusKeys); $i++):
                $value = $statusKeys[$i];
                if ($value != 'cancelled'): // We'll add cancelled separately at the end
              ?>
                  <option value="<?php echo $value; ?>"><?php echo $data['statusOptions'][$value]; ?></option>
              <?php
                endif;
              endfor;
              ?>
              <option value="cancelled">Cancel Order</option>
            </select>
          </div>

          <div class="form-group">
            <label for="notes">Status Notes:</label>
            <textarea name="notes" id="notes" class="form-control" placeholder="Add optional notes about this status change"></textarea>
          </div>

          <button type="submit" class="action-button accept-button">Update Status</button>
        </form>
      </div>
    <?php endif; ?>

    
  </div>
</div>
<style>
  /* Main Layout and Container Styles */
  .item-details-container {
    max-width: 1100px;
    margin: 0 auto;
    background: var(--background-light, #f8f9fa);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }

  .details-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    background-color: var(--white-color, #fff);
    border-bottom: 1px solid var(--border-color, #eaeaea);
  }

  .details-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark, #333);
    margin: 0;
  }

  .close-button {
    background: transparent;
    border: none;
    font-size: 24px;
    color: var(--text-muted, #777);
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .close-button:hover {
    color: var(--danger-color, #dc3545);
  }

  /* Content Sections */
  .details-content {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    padding: 25px;
    background-color: var(--white-color, #fff);
  }

  .product-showcase {
    flex: 1;
    min-width: 300px;
  }

  .product-image {
    width: 100%;
    height: auto;
    max-height: 350px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
  }

  .product-title {
    margin: 15px 0 10px;
    font-size: 1.4rem;
    color: var(--text-dark, #333);
  }

  .product-price {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--accent-color, #c4a77d);
    margin-bottom: 15px;
  }

  /* Color Options */
  .color-options {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }

  .color-option {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #ddd;
    cursor: pointer;
  }

  /* Customer Details */
  .customer-details {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: var(--background-light, #f8f9fa);
    border-radius: 8px;
    margin-top: 20px;
  }

  .customer-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
  }

  .customer-name {
    font-weight: 500;
    margin: 0 0 5px;
    color: var(--text-dark, #333);
  }

  .customer-id {
    font-size: 0.85rem;
    color: var(--text-muted, #777);
    margin: 0;
  }

  /* Specifications Section */
  .specifications {
    flex: 1;
    min-width: 300px;
  }

  .spec-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px;
  }

  .spec-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed var(--border-color, #eaeaea);
  }

  .spec-label {
    font-weight: 500;
    color: var(--text-dark, #333);
  }

  /* Care Instructions */
  .care-instructions {
    background: var(--background-light, #f8f9fa);
    border-radius: 8px;
    padding: 20px;
  }

  .care-instructions h4 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--text-dark, #333);
    margin-bottom: 15px;
  }

  .care-instructions p {
    margin: 8px 0;
    color: var(--text-color, #444);
  }

  .disclaimer {
    display: block;
    margin-top: 15px;
    color: var(--text-muted, #777);
    font-style: italic;
  }

  /* Status Update Section */
  .status-update-section {
    background-color: var(--white-color, #fff);
    padding: 25px;
    border-radius: 8px;
    margin: 0 25px 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .status-update-section h4 {
    margin-top: 0;
    font-size: 1.2rem;
    color: var(--text-dark, #333);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color, #eaeaea);
  }

  .current-status-display {
    margin-bottom: 20px;
    background-color: var(--background-light, #f8f9fa);
    padding: 12px 15px;
    border-radius: 6px;
  }

  .current-status-display p {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  /* Status Badges */
  .status-badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 500;
    color: white;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .order-placed {
    background-color: #87CEEB;
    box-shadow: 0 2px 5px rgba(135, 206, 235, 0.3);
  }

  .fabric-cutting {
    background-color: #FF9800;
    box-shadow: 0 2px 5px rgba(255, 152, 0, 0.3);
  }

  .stitching {
    background-color: #673AB7;
    box-shadow: 0 2px 5px rgba(103, 58, 183, 0.3);
  }

  .ready-for-delivery {
    background-color: #2196F3;
    box-shadow: 0 2px 5px rgba(33, 150, 243, 0.3);
  }

  .delivered {
    background-color: #4CAF50;
    box-shadow: 0 2px 5px rgba(76, 175, 80, 0.3);
  }

  .cancelled {
    background-color: #F44336;
    box-shadow: 0 2px 5px rgba(244, 67, 54, 0.3);
  }

  /* Form Styling */
  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-dark, #333);
  }

  .form-select,
  .form-control {
    width: 100%;
    padding: 12px 15px;
    border-radius: 6px;
    border: 1px solid var(--border-color, #ddd);
    background-color: #fff;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .form-select:focus,
  .form-control:focus {
    outline: none;
    border-color: var(--primary-color, #6a5acd);
    box-shadow: 0 0 0 3px rgba(106, 90, 205, 0.1);
  }

  textarea.form-control {
    min-height: 100px;
    resize: vertical;
  }

  /* Action Buttons */
  .action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    padding: 0 25px 25px;
  }

  .action-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    color: white;
    transition: all 0.2s ease;
    min-width: 150px;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    text-align: center;
  }

  .action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .accept-button {
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
  }

  .measurements-button {
    background: linear-gradient(135deg, var(--primary-color, #6a5acd), var(--dark-primary-color, #483D8B));
  }

  .reject-button {
    background: linear-gradient(135deg, #F44336, #B71C1C);
  }

  /* No Items Message */
  .no-items-found {
    padding: 40px;
    text-align: center;
    color: var(--text-muted, #777);
    font-size: 1.1rem;
    background-color: var(--white-color, #fff);
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
    .details-content {
      flex-direction: column;
      gap: 20px;
    }

    .status-update-section,
    .action-buttons {
      margin: 0 15px 15px;
      padding: 15px;
    }

    .action-button {
      width: 100%;
    }
  }

  @media (max-width: 480px) {
    .details-header {
      padding: 15px;
    }

    .details-header h2 {
      font-size: 1.2rem;
    }

    .customer-details {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>