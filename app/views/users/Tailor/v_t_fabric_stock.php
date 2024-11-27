<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <button class="add-fabric-btn" id="openFabricModalBtn">Add New Fabric</button>

  <div class="table-container">
    <table class="product-table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Fabric Name</th>
          <th>Fabric Id</th>
          <th>Price</th>
          <th>Stock(m)</th>
          <th>Available Color</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><img src="https://via.placeholder.com/50" alt="Linen" class="product-image"></td>
          <td>Linen</td>
          <td>001</td>
          <td>$690.00</td>
          <td>63</td>
          <td>
            <span class="color-dot" style="background-color: black;"></span>
            <span class="color-dot" style="background-color: pink;"></span>
            <span class="color-dot" style="background-color: #D4A373;"></span>
          </td>
          <td>
            <button class="action-btn edit-btn">✎</button>
            <button class="action-btn delete-btn">🗑</button>
          </td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Structure -->
<div id="fabricModal" class="modal">
    <div id="modal-body">
      <!-- Content from v_t_add_new_fabric.php will be loaded here -->
    </div>
  </div>
</div>

<script>
  document.getElementById('openFabricModalBtn').addEventListener('click', function() {
    document.getElementById('fabricModal').style.display = 'block';
    // Load the content of v_t_add_new_fabric.php into the modal
    fetch('<?php echo URLROOT; ?>/tailors/addNewFabric')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;
      });
  });

  document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('fabricModal').style.display = 'none';
  });

  window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('fabricModal')) {
      document.getElementById('fabricModal').style.display = 'none';
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>