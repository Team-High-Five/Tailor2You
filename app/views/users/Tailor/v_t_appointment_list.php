<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="appointment-list-container">
    <div class="filter-bar">
      <button class="filter-btn">Filter By</button>
      <select>
        <option>14 Feb 2019</option>
        <!-- Add more date options as needed -->
      </select>
      <select>
        <option>Order Type</option>
        <!-- Add more order types as needed -->
      </select>
      <select>
        <option>Order Status</option>
        <!-- Add more statuses as needed -->
      </select>
      <button class="reset-filter-btn">Reset Filter</button>
      <a href="<?php echo URLROOT; ?>/Tailors/displayCalendar" class="progress-btn">Calender</a>
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
          <?php foreach ($data['appointments'] as $appointment) : ?>
            <tr>
              <td><?php echo $appointment->appointment_id; ?></td>
              <td><a href="<?php echo URLROOT; ?>/tailors/displayAppointmentDetails/<?php echo $appointment->appointment_id; ?>" class="appointment-link"><?php echo $appointment->first_name . ' ' . $appointment->last_name; ?></a></td>
              <td><?php echo date('d M Y', strtotime($appointment->appointment_date)); ?></td>
              <td><?php echo date('h:i a', strtotime($appointment->appointment_time)); ?></td>
              <td><span class="status <?php echo strtolower($appointment->status); ?>"><?php echo ucfirst($appointment->status); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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
<div id="rescheduleAppointmentModal" class="modal">
  <div class="modal-body">
    <div class="pop-modal-container">
      <div class="add-new-post-content">
        <div class="modal-header">
          <h1>Reschedule Appointment</h1>
          <button class="close-btn">&times;</button>
        </div>
        <form id="reschedule-form" action="" method="post">
          <div class="form-group">
            <label for="appointment_date">New Date</label>
            <input type="date" id="appointment_date" name="appointment_date" required>
          </div>
          <div class="form-group">
            <label for="appointment_time">New Time</label>
            <input type="time" id="appointment_time" name="appointment_time" required>
          </div>
          <button type="submit" class="submit-btn">Reschedule</button>
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
      document.getElementById('reschedule-form').action = '<?php echo URLROOT; ?>/tailors/rescheduleAppointment/' + appointmentId;
      document.getElementById('rescheduleAppointmentModal').style.display = 'block';
    }
  });
</script>
<script src="<?php echo URLROOT; ?>/public/js/appointment.js"></script>
<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>