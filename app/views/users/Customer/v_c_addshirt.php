<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/profilebuttons_styles.css'>
<div class="passcontainer">
    <div class="shirt-measurement-layout">
        <!-- Existing form content -->
        <main class="main-content">
          <section class="content">
            <h2>Shirt Measurement</h2>
             <form name="addShirts" class="change-form" action="<?php echo URLROOT?>/Customers/addShirts" method="post">
              <input type="hidden" name="is_create" value="<?php echo empty($data['shirt']) ? '1' : '0'; ?>">
              <label for="measure">Measurement type</label>
                <div class="radiobtn">
                    <input type="radio" id="cm" name="measurement_unit" value="cm" <?php echo isset($data['shirt']->measure) && $data['shirt']->measure == 'cm' ? 'checked' : ''; ?>>
                    <label for="cm">cm</label>
                    <input type="radio" id="inch" name="measurement_unit" value="inch" <?php echo isset($data['shirt']->measure) && $data['shirt']->measure == 'inch' ? 'checked' : ''; ?>>
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

        <!-- Updated guide section -->
        <aside class="shirt-guide-section">
            <div class="guide-image-wrapper">
                <img src="<?php echo URLROOT; ?>/public/img/Shirtmes.png" 
                     alt="Shirt Measurement Guide" 
                     class="shirt-guide-image">
                <div class="measurement-tooltip">
                    <div class="tooltip-content">
                        <h4>Shirt Measurements</h4>
                        <ul class="tooltip-list">
                            <li>Collar Size: Around base of neck</li>
                            <li>Chest Width: Around fullest chest</li>
                            <li>Waist Width: Around natural waist</li>
                            <li>Bottom Width: Around hip level</li>
                            <li>Shoulder Width: Across shoulders</li>
                            <li>Sleeve Length: Shoulder to wrist</li>
                            <li>Armhole Depth: Shoulder to armpit</li>
                            <li>Bicep: Around upper arm</li>
                            <li>Cuff Size: Around wrist</li>
                            <li>Front Length: Shoulder to hem</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Keep original guide content -->
            <div class="guide-content">
                <p>Follow these guidelines for accurate measurements of your shirt.</p>
                <div class="measurement-tip">
                    <ul>
                        <li>Stand straight with arms relaxed.</li>
                        <li>Use a flexible measuring tape.</li>
                        <li>Don't pull the tape too tight.</li>
                        <li>Measure over a well-fitting shirt</li>
                    </ul>
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