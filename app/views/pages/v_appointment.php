<?php
require_once APPROOT . '/views/designs/inc/header.php';
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
              <input type="date" name="appointment_date" class="select" id="date" min="<?php echo date('Y-m-d'); ?>" required>
              <span class="error"><?php echo $data['date_err']; ?></span>
            </td>
          </tr>
          <tr>
            <td>
              <strong>Time</strong>
              <p>Select the time for the appointment</p>
            </td>
            <td>
              <select name="appointment_time" class="select" id="time" required>
                <?php
                // Get booked appointments for the selected tailor on the selected date
                $bookedSlots = isset($data['booked_slots']) ? $data['booked_slots'] : [];

                // Generate time slots from 9 AM to 5 PM
                for ($hour = 9; $hour <= 17; $hour++) {
                  $period = ($hour >= 12) ? 'PM' : 'AM';
                  $displayHour = ($hour > 12) ? $hour - 12 : $hour;

                  for ($minute = 0; $minute < 60; $minute += 30) {
                    $time = sprintf("%02d:%02d:00", $hour, $minute);
                    $displayTime = sprintf("%d:%02d %s", $displayHour, $minute, $period);

                    // Check if this time slot is booked
                    $isBooked = in_array($time, $bookedSlots);

                    if ($isBooked) {
                      echo "<option value='$time' disabled class='booked-slot'>$displayTime (Not Available)</option>";
                    } else {
                      echo "<option value='$time'>$displayTime</option>";
                    }
                  }
                }
                ?>
              </select>
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
  // Function to load time slots
  function loadTimeSlots(date, tailorId) {
    fetch(`<?php echo URLROOT; ?>/appointments/getAvailableSlots/${tailorId}/${date}`)
      .then(response => response.json())
      .then(data => {
        const timeSelect = document.getElementById('time');
        timeSelect.innerHTML = ''; // Clear current options

        // Generate time slots
        for (let hour = 9; hour <= 17; hour++) {
          const period = (hour >= 12) ? 'PM' : 'AM';
          const displayHour = (hour > 12) ? hour - 12 : hour;

          for (let minute = 0; $minute < 60; $minute += 30) {
            const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}:00`;
            const displayTime = `${displayHour}:${String(minute).padStart(2, '0')} ${period}`;

            const option = document.createElement('option');
            option.value = time;
            option.textContent = displayTime;

            if (data.booked_slots && data.booked_slots.includes(time)) {
              option.disabled = true;
              option.className = 'booked-slot';
              option.textContent += ' (Not Available)';
            }

            timeSelect.appendChild(option);
          }
        }
      })
      .catch(error => console.error('Error:', error));
  }

  // Load time slots on page load
  document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const tailorId = document.querySelector('input[name="tailor_id"]').value;

    // Set default date to today
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;

    // Load initial time slots
    loadTimeSlots(today, tailorId);

    // Update time slots when date changes
    dateInput.addEventListener('change', function() {
      loadTimeSlots(this.value, tailorId);
    });
  });
</script>
<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>
