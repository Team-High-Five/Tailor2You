<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="design-page-container">
  <div class="design-details-container">
    <div class="measurement-content">
      <div class="measurement-header">
        <span>Enter Your Measurements</span>
      </div>

      <form action="<?php echo URLROOT; ?>/Orders/processMeasurements" method="post" id="measurementForm">
        <table class="measurement-table">
          <thead>
            <tr>
              <th>Measurement Type</th>
              <th>Value (inches)</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($data['measurements'])): ?>
              <?php foreach ($data['measurements'] as $measurement): ?>
                <tr>
                  <td>
                    <strong><?php echo $measurement->display_name; ?></strong>
                    <p><?php echo !empty($measurement->custom_description) ? $measurement->custom_description : $measurement->description; ?></p>
                  </td>
                  <td>
                    <div class="input-container">
                      <?php
                      // Get range for this measurement
                      $range = $data['ranges'][$measurement->name] ?? ['min' => 5, 'max' => 60, 'increment' => 0.5];
                      $min = $range['min'];
                      $max = $range['max'];

                      // Get user's existing measurement if available
                      $userValue = $data['userMeasurements'][$measurement->name] ?? null;
                      ?>
                      <input
                        type="number"
                        class="measurement-input"
                        name="measurement_<?php echo $measurement->measurement_id; ?>"
                        id="measurement_<?php echo $measurement->measurement_id; ?>"
                        value="<?php echo $userValue ?? ''; ?>"
                        min="<?php echo $min; ?>"
                        max="<?php echo $max; ?>"
                        step="0.1"
                        <?php echo $measurement->is_required ? 'required' : ''; ?>>
                      <span class="unit">in</span>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($data['customMeasurements'])): ?>
              <?php foreach ($data['customMeasurements'] as $measurement): ?>
                <tr>
                  <td>
                    <strong><?php echo $measurement->display_name; ?></strong>
                    <p><?php echo $measurement->description; ?></p>
                  </td>
                  <td>
                    <div class="input-container">
                      <input
                        type="number"
                        class="measurement-input"
                        name="custom_measurement_<?php echo $measurement->id; ?>"
                        id="custom_measurement_<?php echo $measurement->id; ?>"
                        min="5"
                        max="60"
                        step="0.1"
                        <?php echo $measurement->is_required ? 'required' : ''; ?>>
                      <span class="unit">in</span>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="button-group">
          <a href="<?php echo URLROOT; ?>/Orders/customizations" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
          </a>
          <button type="submit" class="continue-btn">
            Continue <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="design-image-container">
    <div class="design-image-wrapper">
      <?php if (isset($_SESSION['order_details']['design']) && !empty($_SESSION['order_details']['design']->main_image)) : ?>
        <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $_SESSION['order_details']['design']->main_image; ?>"
          alt="<?php echo $_SESSION['order_details']['design']->name; ?>"
          onerror="this.src='<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg'">
      <?php else : ?>
        <img src="<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg" alt="Design Image">
      <?php endif; ?>
    </div>

    <div class="design-details">
      <?php if (isset($_SESSION['order_details']['design'])): ?>
        <div class="design-name">
          <span><?php echo $_SESSION['order_details']['design']->name; ?></span>
        </div>
        <div class="design-description">
          <span><?php echo $_SESSION['order_details']['design']->description; ?></span>
        </div>
      <?php else: ?>
        <div class="design-name">
          <span>Design Name</span>
        </div>
        <div class="design-description">
          <span>Design Description</span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Add Order Summary Component -->
    <?php require_once APPROOT . '/views/designs/components/order-summary.php'; ?>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get all measurement inputs
    const inputs = document.querySelectorAll('.measurement-input');

    // Add input validation
    inputs.forEach(input => {
      input.addEventListener('input', function() {
        // Ensure value is within range
        const value = parseFloat(this.value);
        const min = parseFloat(this.getAttribute('min'));
        const max = parseFloat(this.getAttribute('max'));

        if (!isNaN(value)) {
          // Round to 1 decimal place for better UX
          this.value = Math.round(value * 10) / 10;

          if (value < min) {
            this.setCustomValidity(`Value must be at least ${min}`);
          } else if (value > max) {
            this.setCustomValidity(`Value cannot exceed ${max}`);
          } else {
            this.setCustomValidity('');
          }
        }
      });
    });

    // Form validation
    const form = document.getElementById('measurementForm');
    form.addEventListener('submit', function(event) {
      const invalidInputs = form.querySelectorAll(':invalid');
      if (invalidInputs.length > 0) {
        event.preventDefault();
        invalidInputs[0].focus();
      }
    });
  });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>