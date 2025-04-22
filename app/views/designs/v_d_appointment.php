<?php
require_once APPROOT . '/views/designs/inc/header.php';
require_once APPROOT . '/views/pages/inc/components/topnav.php';
require_once APPROOT . '/helpers/session_helper.php';
?>

<div class="design-page-container">
  <div class="design-details-container">
    <div class="appointment-content">
      <div class="appointment-header">
        <span>Schedule Your Fitting Appointment</span>
      </div>

      <form action="<?php echo URLROOT; ?>/Orders/processAppointment" method="post" id="appointmentForm">
        <table class="appointment-table">
          <thead>
            <tr>
              <th>Appointment Details</th>
              <th>Selection</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <strong>Date</strong>
                <p>Select your preferred fitting date</p>
              </td>
              <td>
                <input type="date" name="appointment_date" id="appointment_date" class="date-input"
                  min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                  value="<?php echo $data['selected_date'] ?? date('Y-m-d', strtotime('+1 day')); ?>" required>
              </td>
            </tr>
            <tr>
              <td>
                <strong>Time</strong>
                <p>Select your preferred fitting time slot</p>
              </td>
              <td>
                <div class="time-slots-container">

                  <div class="time-slot-row">
                    <?php
                    $tailorId = $_SESSION['order_details']['design']->user_id ?? 0;
                    $bookedSlots = $data['booked_slots'] ?? [];

                    // For debugging - uncomment temporarily if needed
                    // echo '<pre>Debug: '; print_r($bookedSlots); echo '</pre>'; 

                    // Generate time slots from 9 AM to 5 PM
                    for ($hour = 9; $hour <= 17; $hour++) {
                      for ($minute = 0; $minute < 60; $minute += 30) {
                        if ($hour == 17 && $minute > 0) continue; // Skip after 5:00 PM

                        $time = sprintf("%02d:%02d:00", $hour, $minute);
                        $period = ($hour >= 12) ? 'PM' : 'AM';
                        $displayHour = ($hour > 12) ? $hour - 12 : $hour;
                        if ($displayHour == 0) $displayHour = 12; // Fix midnight display
                        $displayTime = sprintf("%d:%02d %s", $displayHour, $minute, $period);

                        // Check if this time slot is booked
                        $isBooked = in_array($time, $bookedSlots);
                        $class = $isBooked ? 'time-slot booked' : 'time-slot available';

                        echo "<div class='$class' data-time='$time'>";
                        echo "<input type='radio' name='appointment_time' value='$time' id='time_$time' " .
                          ($isBooked ? 'disabled' : '') . " required>";
                        echo "<label for='time_$time'>$displayTime</label>";
                        echo "</div>";
                      }
                    }
                    ?>
                  </div>

                </div>

                <div class="time-slots-legend">
                  <div class="legend-item">
                    <div class="legend-color legend-available"></div>
                    <span>Available</span>
                  </div>
                  <div class="legend-item">
                    <div class="legend-color legend-booked"></div>
                    <span>Booked</span>
                  </div>
                  <div class="legend-item">
                    <div class="legend-color legend-selected"></div>
                    <span>Selected</span>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <strong>Fitting Location</strong>
                <p>Where would you like to meet?</p>
              </td>
              <td>
                <div class="location-options">
                  <div class="location-option">
                    <input type="radio" name="location_type" id="tailor_shop" value="shop" checked>
                    <label for="tailor_shop">Tailor's Shop</label>
                  </div>
                  <div class="location-option">
                    <input type="radio" name="location_type" id="customer_location" value="home">
                    <label for="customer_location">My Location (Additional charges may apply)</label>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="button-group">
          <a href="<?php echo URLROOT; ?>/Orders/enterMeasurements" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
          </a>
          <button type="submit" class="continue-btn">
            Confirm Appointment 
          </button>
          <a href="<?php echo URLROOT; ?>/Orders/skipAppointment" class="skip-btn">
            Skip <i class="fas fa-forward"></i>
          </a>

        </div>
      </form>
    </div>
  </div>

  <div class="design-image-container">
    <div class="design-image-wrapper">
      <?php if (isset($_SESSION['order_details']['design']) && !empty($_SESSION['order_details']['design']->main_image)) : ?>
        <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $_SESSION['order_details']['design']->main_image; ?>"
          alt="<?php echo $_SESSION['order_details']['design']->name; ?>"
          onerror="this.src='<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg'">
      <?php else : ?>
        <img src="<?php echo URLROOT; ?>/public/img/designs/placeholder.jpg" alt="Design Image">
      <?php endif; ?>
    </div>

    <div class="tailor-info">
      <?php if (isset($_SESSION['order_details']['design'])) : ?>
        <h3>Your Tailor</h3>
        <div class="tailor-details">
          <span class="tailor-name"><?php echo $_SESSION['order_details']['design']->first_name . ' ' . $_SESSION['order_details']['design']->last_name; ?></span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Add Order Summary Component -->
    <?php require_once APPROOT . '/views/designs/components/order-summary.php'; ?>
  </div>
</div>

<script>
  // Function to reload the page with the selected date to show available slots
  function reloadWithDate(date) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = window.location.href;

    const dateInput = document.createElement('input');
    dateInput.type = 'hidden';
    dateInput.name = 'appointment_date';
    dateInput.value = date;

    form.appendChild(dateInput);
    document.body.appendChild(form);
    form.submit();
  }

  // Load time slots when date changes
  document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('appointment_date');
    dateInput.addEventListener('change', function() {
      reloadWithDate(this.value);
    });

    // Handle time slot selection
    const timeSlots = document.querySelectorAll('.time-slot.available');
    timeSlots.forEach(slot => {
      slot.addEventListener('click', function() {
        timeSlots.forEach(s => s.classList.remove('selected'));
        this.classList.add('selected');
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
      });
    });
  });
</script>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>