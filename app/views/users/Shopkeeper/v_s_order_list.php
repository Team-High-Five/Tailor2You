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
            <td><a href="<?php echo URLROOT; ?>/tailors/displayOrderMeasurements" class="order-link">Pieris M.P</a></td>
            <td>Dotted Black Dress</td>
            <td>14 Feb 2019</td>
            <td>Rs.10,000</td>
            <td><span class="status processing">Processing</span></td>
          </tr>
          <tr>
            <td>00002</td>
            <td>De Silva N.G</td>
            <td>Rockstar Jacket</td>
            <td>14 Feb 2019</td>
            <td>Rs.12,000</td>
            <td><span class="status completed">Completed</span></td>
          </tr>
          <tr>
            <td>00003</td>
            <td>Darrell Caldwell</td>
            <td>Long Sleeve Shirt</td>
            <td>14 Feb 2019</td>
            <td>Rs.5,000</td>
            <td><span class="status rejected">Rejected</span></td>
          </tr>
          <tr>
            <td>00004</td>
            <td>Gilbert Johnston</td>
            <td>Casual Dress</td>
            <td>14 Feb 2019</td>
            <td>Rs.4,000</td>
            <td><span class="status pending">Pending</span></td>
          </tr>
          <!-- Add more rows as needed -->
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>