<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="tailor-container">
    <div class="order-list-container">
      <div class="order-header">
        <h2><i class="fas fa-clipboard-list"></i> Order Management</h2>
        <a href="<?php echo URLROOT; ?>/Tailors/displayOrderProgress" class="progress-btn">
          <i class="fas fa-tasks"></i> Order Progress
        </a>
      </div>

      <div class="filter-bar">
        <div class="filter-label">
          <i class="fas fa-filter"></i> Filter Orders
        </div>

        <form method="GET" action="<?php echo URLROOT; ?>/Tailors/displayOrders" id="filterForm">
          <select id="filter-date-range" class="filter-select" name="date_range" onchange="updateDateFilter(this.value)">
            <option value="">All Time</option>
            <option value="7" <?php echo (isset($_GET['date_range']) && $_GET['date_range'] == '7') ? 'selected' : ''; ?>>Last 7 Days</option>
            <option value="30" <?php echo (isset($_GET['date_range']) && $_GET['date_range'] == '30') ? 'selected' : ''; ?>>Last 30 Days</option>
            <option value="90" <?php echo (isset($_GET['date_range']) && $_GET['date_range'] == '90') ? 'selected' : ''; ?>>Last 3 Months</option>
            <option value="180" <?php echo (isset($_GET['date_range']) && $_GET['date_range'] == '180') ? 'selected' : ''; ?>>Last 6 Months</option>
          </select>

          <input type="hidden" name="date" id="date-filter" value="<?php echo isset($data['filters']['date']) ? $data['filters']['date'] : ''; ?>">

          <select name="status" class="filter-select">
            <option value="">All Statuses</option>
            <?php foreach ($data['statusOptions'] as $value => $label): ?>
              <option value="<?php echo $value; ?>" <?php echo (isset($data['filters']['status']) && $data['filters']['status'] === $value) ? 'selected' : ''; ?>>
                <?php echo $label; ?>
              </option>
            <?php endforeach; ?>
          </select>

          <button type="submit" class="apply-btn">
            <i class="fas fa-search"></i> Apply
          </button>

          <button type="button" id="reset-filters" class="rst-btn" onclick="window.location='<?php echo URLROOT; ?>/Tailors/displayOrders'">
            <i class="fas fa-undo"></i> Reset
          </button>
        </form>
      </div>

      <div class="table-container">
        <table class="order-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Design</th>
              <th>Date</th>
              <th>Price</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($data['orders'])): ?>
              <?php foreach ($data['orders'] as $order): ?>
                <tr>
                  <td><?php echo $order->order_id; ?></td>
                  <td>
                    <a href="<?php echo URLROOT; ?>/Tailors/displayOrderDetails/<?php echo $order->order_id; ?>" class="order-link">
                      <?php echo $order->first_name . ' ' . $order->last_name; ?>
                    </a>
                  </td>
                  <td><?php echo $order->design_name; ?></td>
                  <td><?php echo $order->formatted_date; ?></td>
                  <td>Rs. <?php echo number_format($order->total_amount, 2); ?></td>
                  <td>
                    <div class="status-indicator">
                      <div class="status-icon <?php echo strtolower(str_replace('_', '-', $order->status)); ?>">
                        <?php
                        $status_icons = [
                          'order_placed' => '<i class="fas fa-check"></i>',
                          'fabric_cutting' => '<i class="fas fa-cut"></i>',
                          'stitching' => '<i class="fas fa-tshirt"></i>',
                          'ready_for_delivery' => '<i class="fas fa-shipping-fast"></i>',
                          'delivered' => '<i class="fas fa-home"></i>',
                          'cancelled' => '<i class="fas fa-times"></i>'
                        ];
                        echo $status_icons[$order->status] ?? '<i class="fas fa-question"></i>';
                        ?>
                      </div>
                      <span class="status-text">
                        <?php
                        $status_labels = [
                          'order_placed' => 'Order Placed',
                          'fabric_cutting' => 'Fabric Cutting',
                          'stitching' => 'Stitching',
                          'ready_for_delivery' => 'Ready for Delivery',
                          'delivered' => 'Delivered',
                          'cancelled' => 'Cancelled'
                        ];
                        echo $status_labels[$order->status] ?? ucfirst($order->status);
                        ?>
                      </span>
                    </div>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <a href="<?php echo URLROOT; ?>/Tailors/displayOrderDetails/<?php echo $order->order_id; ?>" class="btn-view" title="View Details">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="<?php echo URLROOT; ?>/Tailors/updateOrderStatus/<?php echo $order->order_id; ?>" class="btn-update" title="Update Status">
                        <i class="fas fa-edit"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="no-orders">
                  <p>No orders found</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips for status icons if needed
    const statusIcons = document.querySelectorAll('.status-icon');

    statusIcons.forEach(icon => {
      // You could add a tooltip library here if you want
      // or just use the built-in title attribute
      const statusText = icon.nextElementSibling.textContent;
      icon.setAttribute('title', statusText);
    });
  });
    document.addEventListener('DOMContentLoaded', function() {
      // Status icon tooltips
      const statusIcons = document.querySelectorAll('.status-icon');
      statusIcons.forEach(icon => {
        const statusText = icon.nextElementSibling.textContent;
        icon.setAttribute('title', statusText);
      });

      // Check if there's a date range selected on page load
      const dateRangeSelect = document.getElementById('filter-date-range');
      if (dateRangeSelect.value) {
        updateDateFilter(dateRangeSelect.value);
      }
    });

  // Function to update the hidden date field based on the selected range
  function updateDateFilter(days) {
    if (!days) {
      document.getElementById('date-filter').value = '';
      return;
    }

    const today = new Date();
    const pastDate = new Date();
    pastDate.setDate(today.getDate() - parseInt(days));

    // Format date as YYYY-MM-DD
    const formattedDate = pastDate.toISOString().split('T')[0];
    document.getElementById('date-filter').value = formattedDate;
  }
</script>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>