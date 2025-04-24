<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="appointment-list-container">
    <div class="filter-bar">
      <div class="filter-label">
        <i class="fas fa-filter"></i> Filter Appointments
      </div>
      <select id="filter-date" class="filter-select">
        <option value="">All Dates</option>
        <option value="today">Today</option>
        <option value="tomorrow">Tomorrow</option>
        <option value="week">Next 7 Days</option>
        <option value="month">Next 30 Days</option>
      </select>
      <select id="filter-time" class="filter-select">
        <option value="">All Times</option>
        <option value="morning">Morning (Before 12PM)</option>
        <option value="afternoon">Afternoon (12PM-5PM)</option>
        <option value="evening">Evening (After 5PM)</option>
      </select>
      <select id="filter-status" class="filter-select">
        <option value="">All Statuses</option>
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="completed">Completed</option>
        <option value="rejected">Rejected</option>
      </select>
      <button id="reset-filters" class="rst-btn">Reset</button>
      <a href="<?php echo URLROOT; ?>/Tailors/displayCalendar" class="calendar-btn">
        <i class="fas fa-calendar-alt"></i> Calendar
      </a>
    </div>

    <div class="table-container">
      <table class="appointment-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data['appointments'] as $appointment) :
            // Format date for display
            $displayDate = date('d M Y', strtotime($appointment->appointment_date));
            // Get timestamp for easy date comparison
            $dateTimestamp = strtotime($appointment->appointment_date);

            // Format time for display
            $displayTime = date('h:i a', strtotime($appointment->appointment_time));
            // Get 24-hour format time for easy filtering
            $hour24 = date('H', strtotime($appointment->appointment_time));

            // Determine time period
            $timePeriod = '';
            if ($hour24 < 12) {
              $timePeriod = 'morning';
            } else if ($hour24 >= 12 && $hour24 < 17) {
              $timePeriod = 'afternoon';
            } else {
              $timePeriod = 'evening';
            }
          ?>
            <tr
              data-date="<?php echo $appointment->appointment_date; ?>"
              data-timestamp="<?php echo $dateTimestamp; ?>"
              data-time="<?php echo $appointment->appointment_time; ?>"
              data-time-period="<?php echo $timePeriod; ?>"
              data-status="<?php echo strtolower($appointment->status); ?>">
              <td><?php echo $appointment->appointment_id; ?></td>
              <td><a href="<?php echo URLROOT; ?>/tailors/displayAppointmentDetails/<?php echo $appointment->appointment_id; ?>" class="appointment-link"><?php echo $appointment->first_name . ' ' . $appointment->last_name; ?></a></td>
              <td><?php echo $displayDate; ?></td>
              <td><?php echo $displayTime; ?></td>
              <td><span class="status <?php echo strtolower($appointment->status); ?>"><?php echo ucfirst($appointment->status); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="no-results" style="display: none;">No appointments match your filter criteria</div>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="AppointmentCard" class="modal">
  <div id="modal-body">
    <!-- Content from v_t_appointment_card.php will be loaded here -->
  </div>
</div>

<!-- Reschedule Appointment Modal -->
<!-- Reschedule Appointment Modal -->
<div id="rescheduleAppointmentModal" class="modal">
  <div class="modal-body">
    <div class="add-new-post-container">
      <div class="add-new-post-content">
        <div class="modal-header">
          <h1>Request Appointment Reschedule</h1>
          <button class="close-btn">&times;</button>
        </div>
        <form id="reschedule-form" action="" method="post">
          <div class="post-form-container">
            <div class="form-group">
              <label for="appointment_date">Proposed New Date</label>
              <input type="date" id="appointment_date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
              <label for="appointment_time">Proposed New Time</label>
              <select id="appointment_time" name="appointment_time" required>
                <?php
                // Generate 30-minute time slots from 8:00 to 19:00
                for ($hour = 8; $hour < 19; $hour++) {
                  for ($minute = 0; $minute < 60; $minute += 30) {
                    $time = sprintf('%02d:%02d', $hour, $minute);
                    echo "<option value=\"$time\">$time</option>";
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="reschedule_reason">Reason for Reschedule</label>
              <textarea id="reschedule_reason" name="reschedule_reason" rows="3" placeholder="Please explain why you need to reschedule this appointment" required></textarea>
            </div>
          </div>
          <button type="submit" class="submit-btn">Send Reschedule Request</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.appointment-link').forEach(link => {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('AppointmentCard').style.display = 'block';
      // Load the content of v_t_appointment_card.php into the modal
      fetch(this.href)
        .then(response => response.text())
        .then(html => {
          document.getElementById('modal-body').innerHTML = html;
        });
    });
  });

  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('AppointmentCard').style.display = 'none';
      document.getElementById('rescheduleAppointmentModal').style.display = 'none';
    });
  });

  window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('AppointmentCard')) {
      document.getElementById('AppointmentCard').style.display = 'none';
    }
    if (event.target == document.getElementById('rescheduleAppointmentModal')) {
      document.getElementById('rescheduleAppointmentModal').style.display = 'none';
    }
  });

  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('reject-button')) {
      event.preventDefault();
      const appointmentId = event.target.dataset.id;
      document.getElementById('reschedule-form').action = '<?php echo URLROOT; ?>/tailors/requestRescheduleAppointment/' + appointmentId;
      document.getElementById('rescheduleAppointmentModal').style.display = 'block';
    }
  });
</script>
<script src="<?php echo URLROOT; ?>/public/js/appointment.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/tailor/appointment-filters.js"></script>
<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>