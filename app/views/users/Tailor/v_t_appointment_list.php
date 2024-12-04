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
          <tr>
            <td>00001</td>
            <td><a href="<?php echo URLROOT; ?>/tailors/displayAppointmentDetails" class="appointment-link" data-id="1067907">Christine
                Brooks</a></td>

            <td>14 Feb 2019</td>
            <td>4:00 p.m.</td>
            <td><span class="status accepted">Accepted</span></td>
          </tr>
          <tr>
            <td>00002</td>
            <td>Rosie Pearson</td>

            <td>14 Feb 2019</td>
            <td>3:00 p.m.</td>
            <td><span class="status processing">Processing</span></td>
          </tr>
          <tr>
            <td>00003</td>
            <td>Darrell Caldwell</td>

            <td>14 Feb 2019</td>
            <td>10:30 a.m.</td>
            <td><span class="status rejected">Rejected</span></td>
          </tr>
          <!-- Add more rows as needed -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="AppointmentCard" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <div id="modal-body">
      <!-- Content from v_t_customize_add_new.php will be loaded here -->
    </div>
  </div>
</div>

<script>
  document.getElementById('1067907').addEventListener('click', function() {
    document.getElementById('AppointmentCard').style.display = 'block';
    // Load the content of v_t_customize_add_new.php into the modal
    fetch('<?php echo URLROOT; ?>/tailors/displayAppointmentDetails')
      .then(response => response.text())
      .then(html => {
        document.getElementById('modal-body').innerHTML = html;
      });
  });

  document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('AppointmentCard').style.display = 'none';
  });

  window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('AppointmentCard')) {
      document.getElementById('AppointmentCard').style.display = 'none';
    }
  });
</script>
<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>