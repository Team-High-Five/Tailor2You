<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

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
        <?php foreach ($data['fabrics'] as $fabric): ?>
          <tr>
            <td>
              <?php if ($fabric->image): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($fabric->image); ?>" alt="<?php echo $fabric->fabric_name; ?>" class="product-image">
              <?php else: ?>
                <img src="https://via.placeholder.com/50" alt="<?php echo $fabric->fabric_name; ?>" class="product-image">
              <?php endif; ?>
            </td>
            <td><?php echo $fabric->fabric_name; ?></td>
            <td><?php echo $fabric->fabric_id; ?></td>
            <td>$<?php echo number_format($fabric->price_per_meter, 2); ?></td>
            <td><?php echo $fabric->stock; ?></td>
            <td>
              <?php
              $colors = explode(', ', $fabric->colors);
              foreach ($colors as $color):
              ?>
                <span class="color-dot" style="background-color: <?php echo strtolower($color); ?>;"></span>
              <?php endforeach; ?>
            </td>
            <td>
              <button class="action-btn edit-btn" onclick="openEditFabricModal(<?php echo $fabric->fabric_id; ?>)">✎</button>
              <button class="action-btn delete-btn" onclick="confirmDelete(<?php echo $fabric->fabric_id; ?>)">🗑</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add New Fabric Modal -->
<div id="fabricModal" class="modal">
  <div id="modal-body">
    <!-- Content from v_s_add_new_fabric.php will be loaded here -->
  </div>
</div>

<!-- Edit Fabric Modal -->
<div id="editFabricModal" class="modal">
  <div id="edit-modal-body">
    <!-- Content from v_s_edit_fabric.php will be loaded here -->
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteFabricModal" class="modal">
  <div class="delete-modal-content">
    <div class="modal-header">
      <h1>Confirm Deletion</h1>
      <button class="close-btn" onclick="closeDeleteFabricModal()">&times;</button>
    </div>
    <div class="delete-modal-body">
      <p>Are you sure you want to delete this fabric?</p>
      <form id="deleteFabricForm" action="" method="post">
        <button type="submit" class="submit-btn">Yes, Delete</button>
        <button type="button" class="cancel-btn" onclick="closeDeleteFabricModal()">Cancel</button>
      </form>
    </div>
  </div>
</div>

<script>
 document.getElementById('openFabricModalBtn').addEventListener('click', function() {
    document.getElementById('fabricModal').style.display = 'block';
    fetch('<?php echo URLROOT; ?>/shopkeepers/addNewFabric')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;

        // Add event listeners for image preview
        document.getElementById('post-preview').addEventListener('click', function() {
          document.getElementById('upload-photo').click();
        });

        document.getElementById('upload-photo').addEventListener('change', function(event) {
          const reader = new FileReader();
          reader.onload = function() {
            const output = document.getElementById('post-preview');
            output.src = reader.result;
          };
          reader.readAsDataURL(event.target.files[0]);
        });
      });
  });

  function openEditFabricModal(fabricId) {
    document.getElementById('editFabricModal').style.display = 'block';
    fetch('<?php echo URLROOT; ?>/shopkeepers/editFabric/' + fabricId)
      .then(response => response.text())
      .then(html => {
        document.getElementById('edit-modal-body').innerHTML = html;

        // Add event listeners for image preview
        document.getElementById('post-preview').addEventListener('click', function() {
          document.getElementById('upload-photo').click();
        });

        document.getElementById('upload-photo').addEventListener('change', function(event) {
          const reader = new FileReader();
          reader.onload = function() {
            const output = document.getElementById('post-preview');
            output.src = reader.result;
          };
          reader.readAsDataURL(event.target.files[0]);
        });
      });
  }

  function confirmDelete(fabricId) {
    document.getElementById('deleteFabricModal').style.display = 'block';
    document.getElementById('deleteFabricForm').action = '<?php echo URLROOT; ?>/shopkeepers/deleteFabric/' + fabricId;
  }

  function closeDeleteFabricModal() {
    document.getElementById('deleteFabricModal').style.display = 'none';
  }

  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('fabricModal').style.display = 'none';
      document.getElementById('editFabricModal').style.display = 'none';
      document.getElementById('deleteFabricModal').style.display = 'none';
    });
  });

  window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('fabricModal')) {
      document.getElementById('fabricModal').style.display = 'none';
    }
    if (event.target == document.getElementById('editFabricModal')) {
      document.getElementById('editFabricModal').style.display = 'none';
    }
    if (event.target == document.getElementById('deleteFabricModal')) {
      document.getElementById('deleteFabricModal').style.display = 'none';
    }
  });
</script>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>