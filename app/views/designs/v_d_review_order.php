<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="order-review-container">
  <div class="order-details-card">
    <div class="review-header">
      <span>Review Your Order</span>
      <p>Please verify all details before proceeding to payment</p>
    </div>

    <?php if (isset($_SESSION['order_details'])) : ?>
      <div class="order-sections">
        <?php if (
          !isset($_SESSION['order_details']['design']) ||
          !isset($_SESSION['order_details']['fabric']) ||
          !isset($_SESSION['order_details']['color'])
        ) : ?>
          <div class="alert alert-warning">
            <p><i class="fas fa-exclamation-triangle"></i> Some order information is missing.
              <a href="<?php echo URLROOT; ?>/Orders">Please start the ordering process again</a>.
            </p>
          </div>
        <?php endif; ?>
        <!-- Design Section -->
        <div class="order-section">
          <h3>Design Details</h3>
          <div class="section-content">
            <div class="detail-row">
              <span class="detail-label">Design Name:</span>
              <span class="detail-value"><?php echo $_SESSION['order_details']['design']->name; ?></span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Category:</span>
              <span class="detail-value"><?php echo $_SESSION['order_details']['design']->category_name; ?></span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Base Price:</span>
              <span class="detail-value">Rs. <?php echo number_format($_SESSION['order_details']['design']->base_price, 2); ?></span>
            </div>
          </div>
        </div>

        <!-- Fabric Section -->
        <div class="order-section">
          <h3>Fabric Details</h3>
          <div class="section-content">
            <div class="detail-row">
              <span class="detail-label">Fabric:</span>
              <span class="detail-value"><?php echo $_SESSION['order_details']['fabric']->fabric_name; ?></span>
            </div>

            <?php if ($_SESSION['order_details']['fabric']->price_adjustment != 0) : ?>
              <div class="detail-row">
                <span class="detail-label">Price Adjustment:</span>
                <span class="detail-value <?php echo $_SESSION['order_details']['fabric']->price_adjustment > 0 ? 'price-increase' : 'price-decrease'; ?>">
                  <?php echo $_SESSION['order_details']['fabric']->price_adjustment > 0 ? '+' : ''; ?>Rs. <?php echo number_format($_SESSION['order_details']['fabric']->price_adjustment, 2); ?>
                </span>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Color Section -->
        <div class="order-section">
          <h3>Color Selection</h3>
          <div class="section-content">
            <div class="detail-row">
              <span class="detail-label">Color:</span>
              <span class="detail-value">
                <?php echo $_SESSION['order_details']['color']->color_name; ?>
                <div class="summary-color-swatch"
                  data-color="<?php echo $_SESSION['order_details']['color']->color_name; ?>"
                  style="background-color: <?php echo $_SESSION['order_details']['color']->color_code ?? '#000'; ?>">
                </div>
              </span>
            </div>
          </div>
        </div>

        <!-- Customizations Section -->
        <?php if (!empty($_SESSION['order_details']['customizations'])) : ?>
          <div class="order-section">
            <h3>Customizations</h3>
            <div class="section-content">
              <?php foreach ($_SESSION['order_details']['customizations'] as $typeId => $choice) : ?>
                <div class="detail-row">
                  <span class="detail-label"><?php echo $choice->name; ?>:</span>
                  <span class="detail-value">
                    <?php if ($choice->price_adjustment != 0) : ?>
                      <span class="item-price">
                        <?php if ($choice->price_adjustment != 0): ?>
                          <p class="fabric-price-impact <?php echo $choice->price_adjustment > 0 ? 'price-increase' : 'price-decrease'; ?>">
                            <?php echo $choice->price_adjustment > 0 ? '+' : ''; ?>Rs. <?php echo number_format($choice->price_adjustment, 2); ?>
                          </p>
                        <?php endif; ?>
                      </span>
                    <?php endif; ?>
                  </span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Measurements Section -->
        <?php if (!empty($_SESSION['order_details']['measurements'])) : ?>
          <div class="order-section">
            <h3>Measurements</h3>
            <div class="section-content">
              <div class="measurements-table">
                <?php
                // Extract only the actual measurements (exclude form tokens etc)
                $measurements = [];
                $measurementNames = $_SESSION['order_details']['measurement_names'] ?? [];

                foreach ($_SESSION['order_details']['measurements'] as $key => $value) {
                  if (strpos($key, 'measurement_') === 0) {
                    $measurementId = substr($key, 12); // Remove 'measurement_'
                    $name = isset($measurementNames[$measurementId]) ?
                      $measurementNames[$measurementId] :
                      "Measurement #$measurementId";

                    if (!empty($value)) { // Only display if measurement has a value
                      $measurements[$measurementId] = [
                        'name' => $name,
                        'value' => $value
                      ];
                    }
                  }
                }

                if (!empty($measurements)) :
                  foreach ($measurements as $id => $data) :
                ?>
                    <div class="measurement-row">
                      <span class="measurement-name"><?php echo $data['name']; ?></span>
                      <span class="measurement-value"><?php echo $data['value']; ?> in</span>
                    </div>
                  <?php
                  endforeach;
                else:
                  ?>
                  <p>No measurements provided</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- Appointment Section -->
        <?php if (!empty($_SESSION['order_details']['appointment'])) : ?>
          <div class="order-section">
            <h3>Appointment Details</h3>
            <div class="section-content">
              <?php if (isset($_SESSION['order_details']['appointment']['skipped']) && $_SESSION['order_details']['appointment']['skipped']) : ?>
                <div class="skipped-appointment">
                  <p>No appointment scheduled. You can schedule one later.</p>
                </div>
              <?php else : ?>
                <div class="detail-row">
                  <span class="detail-label">Date:</span>
                  <span class="detail-value">
                    <?php echo date('F j, Y', strtotime($_SESSION['order_details']['appointment']['date'])); ?>
                  </span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Time:</span>
                  <span class="detail-value">
                    <?php
                    $time = $_SESSION['order_details']['appointment']['time'];
                    echo date('g:i A', strtotime($time));
                    ?>
                  </span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Location:</span>
                  <span class="detail-value">
                    <?php echo $_SESSION['order_details']['appointment']['location_type'] === 'shop' ? 'Tailor\'s Shop' : 'Your Location'; ?>
                  </span>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Price Summary Section -->
        <div class="order-section price-summary">
          <h3>Price Summary</h3>
          <div class="section-content">
            <?php
            // Verify total price exists
            if (!isset($_SESSION['order_details']['total_price'])) {
              $basePrice = $_SESSION['order_details']['design']->base_price ?? 0;
              $fabricAdjustment = $_SESSION['order_details']['fabric']->price_adjustment ?? 0;
              $_SESSION['order_details']['total_price'] = $basePrice + $fabricAdjustment;
            }
            ?>
            <div class="detail-row total-price">
              <span class="detail-label">Total Price:</span>
              <span class="detail-value">Rs. <?php echo number_format($_SESSION['order_details']['total_price'], 2); ?></span>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="action-group">
          <a href="<?php echo URLROOT; ?>/Orders/bookAppointment" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
          </a>
          <a href="<?php echo URLROOT; ?>/Orders/placeOrder" class="skip-btn">
            Proceed to Payment <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      <?php else : ?>
        <div class="no-order">
          <p>No order details found. <a href="<?php echo URLROOT; ?>">Start shopping</a></p>
        </div>
      <?php endif; ?>
      </div>
  </div>
  <!-- Right side panel with design image -->
  <div class="design-preview">
    <?php if (isset($_SESSION['order_details']['design'])) : ?>
      <div class="design-image">
        <?php if (!empty($_SESSION['order_details']['design']->main_image)) : ?>
          <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $_SESSION['order_details']['design']->main_image; ?>"
            alt="<?php echo $_SESSION['order_details']['design']->name; ?>"
            onerror="this.src='<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg'">
        <?php else : ?>
          <img src="<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg" alt="Design Image">
        <?php endif; ?>
      </div>

      <div class="tailor-info">
        <h4>Your Tailor</h4>
        <div class="tailor-profile">
          <span class="tailor-name"><?php echo $_SESSION['order_details']['design']->first_name . ' ' . $_SESSION['order_details']['design']->last_name; ?></span>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>


<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>