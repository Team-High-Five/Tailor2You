<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>
<div class="passcontainer">
    <main class="main-content">
      <section class="content">
        <h2>Shirt Measurement</h2>
         <form name="addShirts" class="change-form" action="<?php echo URLROOT?>/Customers/addShirts" method="post">
          <input type="hidden" name="is_create" value="<?php echo empty($data['shirt']) ? '1' : '0'; ?>">
          <label for="measure">Measurement type</label>
            <div class="radiobtn">
                <input type="radio" id="cm" name="measurement_unit" value="1" <?php echo isset($data['shirt']->measure) && $data['shirt']->measure == '1' ? 'checked' : ''; ?>>
                <label for="cm">cm</label>
                <input type="radio" id="inch" name="measurement_unit" value="2" <?php echo isset($data['shirt']->measure) && $data['shirt']->measure == '2' ? 'checked' : ''; ?>>
                <label for="inch">inch</label><br><br>
            </div>
          <label for="Collar size">Collar size</label>
          <input type="text" id="Collar size" name="collar_size" value="<?php echo isset($data['shirt']->collar_size) ? $data['shirt']->collar_size : ''; ?>" required>

          <label for="Chest width">Chest width</label>
          <input type="text" id="Chest width" name="chest_width" value="<?php echo isset($data['shirt']->chest_width) ? $data['shirt']->chest_width : ''; ?>" required>

          <label for="Waist width">Waist width</label>
          <input type="text" id="Waist width" name="waist_width" value="<?php echo isset($data['shirt']->waist_width) ? $data['shirt']->waist_width : ''; ?>" required>

          <label for="Bottom width">Bottom width</label>
          <input type="text" id="Bottom width" name="bottom_width" value="<?php echo isset($data['shirt']->bottom_width) ? $data['shirt']->bottom_width : ''; ?>" required>

          <label for="Shoulder width">Shoulder width</label>
          <input type="text" id="Shoulder width" name="shoulder_width" value="<?php echo isset($data['shirt']->shoulder_width) ? $data['shirt']->shoulder_width : ''; ?>" required>

          <label for="Sleeve length">Sleeve length</label>
          <input type="text" id="Sleeve length" name="sleeve_length" value="<?php echo isset($data['shirt']->sleeve_length) ? $data['shirt']->sleeve_length : ''; ?>" required>

          <label for="Armhole depth">Armhole depth</label>
          <input type="text" id="Armhole depth" name="armhole_depth" value="<?php echo isset($data['shirt']->armhole_depth) ? $data['shirt']->armhole_depth : ''; ?>" required>

          <label for="Bicep">Bicep</label>
          <input type="text" id="Bicep" name="bicep" value="<?php echo isset($data['shirt']->bicep) ? $data['shirt']->bicep : ''; ?>" required>

          <label for="Cuff size">Cuff size</label>
          <input type="text" id="Cuff size" name="cuff_size" value="<?php echo isset($data['shirt']->cuff_size) ? $data['shirt']->cuff_size : ''; ?>" required>

          <label for="Front length">Front length</label>
          <input type="text" id="Front length" name="front_length" value="<?php echo isset($data['shirt']->front_length) ? $data['shirt']->front_length : ''; ?>" required>

          <button type="submit" class="btn-save" style="display: none;">Save Changes</button>
        </form>

      </section>
    </main>
  </div>

</body>
</html>
<script>
    const form = document.querySelector('.change-form');
    const inputs = form.querySelectorAll('input[type="text"], input[type="radio"]'); // Select all relevant inputs
    const saveButton = form.querySelector('.btn-save');

    let originalValues = {}; // Store original values

    inputs.forEach(input => {
        originalValues[input.id] = input.value; // Store initial values
        input.addEventListener('input', enableSaveButton);
        input.addEventListener('change', enableSaveButton); // For radio buttons
    });

    function enableSaveButton() {
        let formChanged = false;
        inputs.forEach(input => {
          if (input.type === 'radio') {
            if (input.checked !== (originalValues[input.id] === input.value)) {
                formChanged = true;
            }
          } else if (input.value !== originalValues[input.id]) {
                formChanged = true;
            }
        });

        saveButton.style.display = formChanged ? 'block' : 'none';
    }
</script>