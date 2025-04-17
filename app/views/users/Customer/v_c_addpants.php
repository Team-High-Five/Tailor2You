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
                <input type="radio" id="cm" name="measurement_unit" value="1" <?php echo isset($data['pant']->measure) && $data['pant']->measure == '1' ? 'checked' : ''; ?>>
                <label for="cm">cm</label>
                <input type="radio" id="inch" name="measurement_unit" value="2" <?php echo isset($data['pant']->measure) && $data['pant']->measure == '2' ? 'checked' : ''; ?>>
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
<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>

