<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
 
  <main class="appointment-section">
    <div class="appointment-form">
      <h2>Request An Appointment</h2>
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date">
      </div>
      <div class="form-group">
        <label for="time">Time</label>
        <input type="time" id="time">
      </div>
      <div class="form-actions">
      <a href="<?php echo URLROOT ?>/Designs/placedOrder"><button class="request-btn">Request</button></a>
      <a href="<?php echo URLROOT ?>/Designs/placedOrder"><button class="skip-btn">Skip</button></a>
      </div>
    </div>
  </main>
</body>
</html>
