<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>
<div class="passcontainer">
  <div class="measurement-layout">
    <main class="main-content">
      <section class="content">

      <h2>Pant Measurement</h2>
        <form name="addPants" class="change-form" action="<?php echo URLROOT?>/Customers/addPants" method="post">
          <input type="hidden" name="is_create" value="<?php echo empty($data['pant']) ? '1' : '0'; ?>">
          <label for="measure">Measurement type</label>
            <div class="radiobtn">
                <input type="radio" id="cm" name="measurement_unit" value="cm" <?php echo isset($data['pant']->measure) && $data['pant']->measure == 'cm' ? 'checked' : ''; ?>>
                <label for="cm">cm</label>
                <input type="radio" id="inch" name="measurement_unit" value="inch" <?php echo isset($data['pant']->measure) && $data['pant']->measure == 'inch' ? 'checked' : ''; ?>>
                <label for="inch">inch</label><br><br>
            </div>
          <label for="waist_width">Waist Width</label>
          <input type="text" id="waist_width" name="waist_width" value="<?php echo isset($data['pant']->waist_width) ? $data['pant']->waist_width : ''; ?>" required>

          <label for="seat">Seat</label>
          <input type="text" id="seat" name="seat" value="<?php echo isset($data['pant']->seat) ? $data['pant']->seat : ''; ?>" required>

          <label for="mid_thigh_width">Mid Thigh Width</label>
          <input type="text" id="mid_thigh_width" name="mid_thigh_width" value="<?php echo isset($data['pant']->mid_thigh_width) ? $data['pant']->mid_thigh_width : ''; ?>" required>

          <label for="inseam">Inseam</label>
          <input type="text" id="inseam" name="inseam" value="<?php echo isset($data['pant']->inseam) ? $data['pant']->inseam : ''; ?>" required>

          <label for="bottom_width">Bottom Width</label>
          <input type="text" id="bottom_width" name="bottom_width" value="<?php echo isset($data['pant']->bottom_width) ? $data['pant']->bottom_width : ''; ?>" required>

          <label for="rise_height_front">Rise Height Front</label>
          <input type="text" id="rise_height_front" name="rise_height_front" value="<?php echo isset($data['pant']->rise_height_front) ? $data['pant']->rise_height_front : ''; ?>" required>

          <label for="rise_height_back">Rise Height Back</label>
          <input type="text" id="rise_height_back" name="rise_height_back" value="<?php echo isset($data['pant']->rise_height_back) ? $data['pant']->rise_height_back : ''; ?>" required>

          <button type="submit" class="btn-save" style="display: none;">Save Changes</button>
        </form>
      </section>
    </main>
    
    <aside class="guide-section">
        <div class="guide-content-wrapper">
            <div class="guide-images">
                <div class="guide-image-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/pantmeasfront.png" 
                         alt="Front Measurements" 
                         class="guide-image">
                    <div class="measurement-tooltip">
                        <div class="tooltip-content">
                            <h4>Front Measurements</h4>
                            <ul class="tooltip-list">
                              <li>Waist: Around natural waistline</li>
                              <li>Rise Height Front: Waistband to crotch</li>
                              <li>Thigh Width: Across thigh from crotch</li>
                              <li>Inseam: Crotch to bottom hem</li>
                              <li>Bottom Width: Across leg opening</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="guide-image-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/pantmeasback.png" 
                         alt="Back Measurements" 
                         class="guide-image">
                    <div class="measurement-tooltip">
                        <div class="tooltip-content">
                            <h4>Back Measurements</h4>
                            <ul class="tooltip-list">
                              <li>Rise Height Back: Back waistband to crotch</li>
                              <li>Seat Width: Across widest hips</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="guide-content">
                <p>Follow these guidelines for accurate measurements of your pants.</p>
                <div class="measurement-tip">
                    <ul>
                        <li>Stand straight with feet slightly apart.</li>
                        <li>Keep the measuring tape straight, not loose or tight.</li>
                        <li>For waist, measure where you typically wear your pants.</li>
                        <li>For inseam, measure from crotch to desired length.</li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
  </div>
</div>

</body>
</html>
<script>
  const form = document.querySelector('.change-form');
  const inputs = form.querySelectorAll('input[type="text"]');
  const cmRadio = document.getElementById('cm');
  const inchRadio = document.getElementById('inch');
  const saveButton = form.querySelector('.btn-save');

  // Conversion constants
  const CM_TO_INCH = 0.393701;
  const INCH_TO_CM = 2.54;

  // Store original values and their units
  let measurementStore = {};

  // Initialize measurement store based on database value and unit
  window.addEventListener('load', function() {
      inputs.forEach(input => {
          const measurementId = input.id.replace(' ', ''); // Adjust if your database column names differ
          const databaseValue = parseFloat(input.value);
          const databaseUnit = cmRadio.checked ? 'cm' : (inchRadio.checked ? 'inch' : 'cm'); // Default to cm if neither is checked initially

          if (!isNaN(databaseValue)) {
              if (databaseUnit === 'cm') {
                  measurementStore[input.id] = {
                      cm: databaseValue,
                      inch: (databaseValue * CM_TO_INCH).toFixed(2)
                  };
              } else if (databaseUnit === 'inch') {
                  measurementStore[input.id] = {
                      cm: (databaseValue * INCH_TO_CM).toFixed(2),
                      inch: databaseValue
                  };
              } else {
                  // Handle unknown unit (shouldn't happen if radio buttons are correctly set)
                  measurementStore[input.id] = { cm: databaseValue, inch: (databaseValue * CM_TO_INCH).toFixed(2) }; // Default to cm
              }
          } else {
              measurementStore[input.id] = { cm: '', inch: '' };
          }
      });
      toggleInputs(); // Initial display based on checked radio
  });

  // Show inputs based on selected unit
  function toggleInputs() {
      inputs.forEach(input => {
          const currentUnit = cmRadio.checked ? 'cm' : 'inch';
          input.value = measurementStore[input.id][currentUnit] || ''; // Use empty string if value is undefined
          input.style.display = measurementStore[input.id][currentUnit] !== undefined ? 'block' : 'none';
      });
  }

  // Handle unit change
  cmRadio.addEventListener('change', toggleInputs);
  inchRadio.addEventListener('change', toggleInputs);

  // Update both cm and inch values when input changes
  inputs.forEach(input => {
      input.addEventListener('input', function() {
          // Allow only numerical input
          this.value = this.value.replace(/[^0-9.]/g, '');

          if (this.value) {
              const currentValue = parseFloat(this.value);
              if (!isNaN(currentValue)) {
                  enableSaveButton();
                  if (cmRadio.checked) {
                      measurementStore[this.id] = {
                          cm: currentValue,
                          inch: (currentValue * CM_TO_INCH).toFixed(2)
                      };
                  } else {
                      measurementStore[this.id] = {
                          cm: (currentValue * INCH_TO_CM).toFixed(2),
                          inch: currentValue
                      };
                  }
              }
          } else {
              measurementStore[this.id].cm = '';
              measurementStore[this.id].inch = '';
              enableSaveButton();
          }
      });
  });

  // Enable save button if form changes
  function enableSaveButton() {
      let formChanged = false;
      inputs.forEach(input => {
          const originalValue = cmRadio.checked ?
              (measurementStore[input.id] ? measurementStore[input.id].cm : '') :
              (measurementStore[input.id] ? measurementStore[input.id].inch : '');
          if (parseFloat(input.value) !== parseFloat(originalValue)) {
              formChanged = true;
          }
      });
      saveButton.style.display = formChanged ? 'block' : 'none';
  }
</script>
<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>

