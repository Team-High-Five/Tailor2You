<?php
require_once APPROOT . '/views/designs/inc/header.php';
require_once APPROOT . '/views/pages/inc/components/topnav.php';
require_once APPROOT . '/helpers/session_helper.php';

?>
<div class="measurement-page-container">
  <div class="measurement-form-container">
    <div class="success-header">
      <span>Make A Appointment</span>
    </div>
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
            <input type="date" class="select" id="date">
          </td>
        </tr>
        <tr>
          <td>
            <strong>Time</strong>
            <p>Select the time for the appointment</p>
          </td>
          <td>
            <input type="time" class="select" id="time">
          </td>
        </tr>
      </tbody>
    </table>

    <div class="action-buttons">
      <a href="<?php echo URLROOT ?>/Designs/placedOrder" class="request-button">Request</a>
      <a href="<?php echo URLROOT ?>/Designs/placedOrder" class="skip-button">Skip</a>
    </div>
  </div>
  <div class="design-image-container">
    <img src="<?php echo URLROOT; ?>/public/img/designs/still-life-with-classic-shirts-hanger.jpg" alt="Shirt Image">
    <div class="design-details">
      <div class="design-name">
        <span>Design Name</span>
      </div>
      <div class="design-description">
        <span>Design Description</span>
      </div>
    </div>
  </div>
</div>
</body>

</html>