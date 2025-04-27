<?php if ($_SESSION['user_type'] == 'shopkeeper') {
  require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] == 'tailor') {
  require_once APPROOT . '/views/users/Tailor/inc/Header.php';
  require_once APPROOT . '/views/users/Tailor/inc/sideBar.php';
  require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} ?>
<div class="main-content">
  <?php flash('order_message'); ?>
  <?php flash('order_error'); ?>
  <?php flash('order_success'); ?>

  <div class="tailor-container">

    <div class="filter-bar">
      <div class="filter-label">
        <i class="fas fa-filter"></i> Filter Orders
      </div>
      <select id="filter-date" class="filter-select">
        <option value="">All Dates</option>
        <option value="today">Today</option>
        <option value="tomorrow">Tomorrow</option>
        <option value="week">Next 7 Days</option>
        <option value="month">Next 30 Days</option>
      </select>
      <select id="filter-time" class="filter-select">
        <option value="">All Price Ranges</option>
        <option value="morning">Under Rs. 1,000</option>
        <option value="afternoon">Rs. 1,000 - 3,000</option>
        <option value="evening">Over Rs. 3,000</option>
      </select>
      <select id="filter-status" class="filter-select">
        <option value="">All Statuses</option>
        <option value="order_placed">Order Placed</option>
        <option value="fabric_cutting">Fabric Cutting</option>
        <option value="stitching">Stitching</option>
        <option value="ready_for_delivery">Ready for Delivery</option>
        <option value="delivered">Delivered</option>
        <option value="cancelled">Cancelled</option>
      </select>
      <button id="reset-filters" class="rst-btn">Reset</button>
      <a href="<?php echo URLROOT; ?>/Tailors/displayCalendar" class="calendar-btn">
        <i class="fas fa-calendar-alt"></i> Calendar
      </a>
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
            <th>Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($data['orders'])): ?>
            <?php foreach ($data['orders'] as $order):
              // Calculate timestamp for JS filtering
              $orderTimestamp = strtotime($order->order_date);
              $priceNumeric = floatval($order->total_amount);
            ?>
              <tr data-timestamp="<?php echo $orderTimestamp; ?>"
                data-price="<?php echo $priceNumeric; ?>"
                data-status="<?php echo $order->status; ?>">
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
                  <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $order->design_image ?> " alt="<?php echo $order->design_name; ?>" class="fabric-image">
                </td>
                <td>
                  <div class="order-view-btn">

                    <a href="<?php echo URLROOT; ?>/Tailors/displayOrderDetails/<?php echo $order->order_id; ?>" class="view-order-btn"> <i class="fas fa-eye"></i>View Order</a>
                  </div>
                </td>

                <?php if ($_SESSION['user_type'] == 'shopkeeper'): ?>
                  <td>
                    <form action="<?php echo URLROOT; ?>/shopkeepers/assignTailor/<?php echo $order->order_id ?>" method="post">
                      <select name="tailor_id" required>
                        <option value="">Select Tailor</option>
                        <?php foreach ($data['employees'] as $tailor) : ?>
                          <option value="<?php echo $tailor->employee_id; ?>"><?php echo $tailor->last_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <button type="submit" class="assign-btn">Assign</button>
                    </form>
                  </td>
                <?php endif; ?>

              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr class="no-orders">
              <td colspan="7">
                <p>No orders found</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- Include the order filter script -->
<script src="<?php echo URLROOT; ?>/public/js/tailor/order-filter.js"></script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>