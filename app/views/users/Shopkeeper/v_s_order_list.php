<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="tailor-container">
    <div class="order-list-container">
      <div class="filter-bar">
        <button class="filter-btn">Filter By</button>
        <select>
          <option>14 Feb 2019</option>
          <!-- Additional dates can go here -->
        </select>
        <select>
          <option>Order Type</option>
          <!-- Additional order types can go here -->
        </select>
        <select>
          <option>Order Status</option>
          <!-- Additional status options can go here -->
        </select>
        <button class="reset-filter-btn">Reset Filter</button>
        <a href="<?php echo URLROOT; ?>/Shopkeepers/displayOrderProgress" class="progress-btn">Order Progress</a>
      </div>

      <div class="table-container">
        <table class="order-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Order</th>
              <th>Date</th>
              <th>Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>00001</td>
              <td><a href="<?php echo URLROOT; ?>/Shopkeepers/displayOrderMeasurements" class="order-link">Pieris M.P</a></td>
              <td>Dotted Black Dress</td>
              <td>14 Feb 2019</td>
              <td>Rs.10,000</td>
              <td>
                <select class="status-dropdown">
                  <option value="processing" class="status-processing" selected>Processing</option>
                  <option value="completed" class="status-completed">Completed</option>
                  <option value="rejected" class="status-rejected">Rejected</option>
                  <option value="pending" class="status-pending">Pending</option>
                </select>
              </td>
            </tr>
            
            <!-- Add more rows as needed -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<style>
  .status-dropdown option.status-processing {
    background-color: #f0ad4e; /* Orange */
    color: white;
  }
  .status-dropdown option.status-completed {
    background-color: #5cb85c; /* Green */
    color: white;
  }
  .status-dropdown option.status-rejected {
    background-color: #d9534f; /* Red */
    color: white;
  }
  .status-dropdown option.status-pending {
    background-color: #5bc0de; /* Blue */
    color: white;
  }
</style>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>