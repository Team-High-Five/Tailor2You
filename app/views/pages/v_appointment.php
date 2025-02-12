<?php
require_once APPROOT . '/views/pages/inc/header.php';
require_once APPROOT . '/views/pages/inc/components/topnav.php';
?>
<div class="measurement-page-container">
  <div class="measurement-form-container">
    <div class="success-header">
      <span>Make An Appointment with <?php echo $data['tailor']->first_name ?></span>
    </div>
    <form action="<?php echo URLROOT; ?>/appointments/create" method="post">
      <input type="hidden" name="tailor_id" value="<?php echo $data['tailor']->user_id; ?>">
      <table>
        <thead>
          <tr>
            <th>Appointment Details</th>
            <th>Input</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <strong>Date</strong>
              <p>Select the date for the appointment</p>
            </td>
            <td>
              <input type="date" name="appointment_date" class="select" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_POST['appointment_date']) ? $_POST['appointment_date'] : date('Y-m-d'); ?>" required>
              <span class="error"><?php echo $data['date_err']; ?></span>
            </td>
          </tr>
          <tr>
            <td>
              <strong>Time</strong>
              <p>Select the time for the appointment</p>
            </td>
            <td>
              <div class="time-slots-container">
                <?php
                // Get booked appointments for the selected tailor on the selected date
                $bookedSlots = isset($data['booked_slots']) ? $data['booked_slots'] : [];

                // Generate time slots from 9 AM to 5 PM
                for ($hour = 9; $hour <= 17; $hour++) {
                  echo '<div class="time-slot-row">';
                  for ($minute = 0; $minute < 60; $minute += 30) {
                    $time = sprintf("%02d:%02d:00", $hour, $minute);
                    $period = ($hour >= 12) ? 'PM' : 'AM';
                    $displayHour = ($hour > 12) ? $hour - 12 : $hour;
                    $displayTime = sprintf("%d:%02d %s", $displayHour, $minute, $period);

                    // Check if this time slot is booked
                    $isBooked = in_array($time, $bookedSlots);
                    $class = $isBooked ? 'time-slot booked' : 'time-slot available';

                    echo "<div class='$class' data-time='$time'>";
                    echo "<input type='radio' name='appointment_time' value='$time' id='time_$time' " . ($isBooked ? 'disabled' : '') . " required>";
                    echo "<label for='time_$time'>$displayTime</label>";
                    echo "</div>";
                  }
                  echo '</div>';
                }
                ?>
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
              <span class="error"><?php echo $data['time_err']; ?></span>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="action-buttons">
        <button type="submit" class="request-button">Request Appointment</button>
        <a href="<?php echo URLROOT ?>/pages/tailorPage#tailorSection" class="skip-button">Cancel</a>
      </div>
    </form>
  </div>
  <div class="design-image-container">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['tailor']->profile_pic); ?>" alt="Tailor Profile">
    <div class="design-details">
      <div class="design-name">
        <span><?php echo $data['tailor']->first_name . ' ' . $data['tailor']->last_name; ?></span>
      </div>
      <div class="design-description">
        <span><?php echo $data['tailor']->bio; ?></span>
      </div>
    </div>
  </div>
</div>

<script>
  // Function to reload the page with the selected date
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

  // Load time slots on date change
  document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    dateInput.addEventListener('change', function() {
      reloadWithDate(this.value);
    });
  });

  // Attach event listeners to time slots
  document.addEventListener('DOMContentLoaded', function() {
    const timeSlots = document.querySelectorAll('.time-slot.available');

    timeSlots.forEach(slot => {
      slot.addEventListener('click', function() {
        // Remove selected class from all slots
        timeSlots.forEach(s => s.classList.remove('selected'));
        // Add selected class to clicked slot
        this.classList.add('selected');
        // Check the radio input
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
      });
    });
  });
</script>
<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>