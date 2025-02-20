<div class="main-content">
  <div class="appointment-details-container">
    <div class="add-new-post-content">
      <div class="modal-header">
        <h1>Appointment #<?php echo $data['appointment']->appointment_id; ?></h1>
        <button class="close-btn" onclick="document.getElementById('AppointmentCard').style.display='none'">&times;</button>
      </div>
      <div class="appointment-info">
        <p class="appointment-date"><?php echo date('d/m/Y - h:i a', strtotime($data['appointment']->appointment_date . ' ' . $data['appointment']->appointment_time)); ?></p>
        <div class="user-info">
          <img src="data:image/jpeg;base64,<?php echo $data['appointment']->profile_pic; ?>" alt="User profile" class="user-avatar">
          <span class="user-name"><?php echo $data['appointment']->first_name . ' ' . $data['appointment']->last_name; ?></span>
        </div>
        <div class="calendar-icon">
          <div class="month"><?php echo date('F', strtotime($data['appointment']->appointment_date)); ?></div>
          <div class="date"><?php echo date('d', strtotime($data['appointment']->appointment_date)); ?></div>
          <div class="day"><?php echo date('l', strtotime($data['appointment']->appointment_date)); ?></div>
        </div>
      </div>
      <div class="status <?php echo strtolower($data['appointment']->status); ?>"><?php echo ucfirst($data['appointment']->status); ?></div>
      <div class="tailor-info">
        <p><strong>Assigned Shopkeeper</strong> <?php echo $data['appointment']->shopkeeper_first_name . ' ' . $data['appointment']->shopkeeper_last_name; ?></p>
      </div>
      <div class="action-buttons">
        <?php if ($data['appointment']->status === 'pending') : ?>
          <form action="<?php echo URLROOT; ?>/shopkeepers/acceptAppointment/<?php echo $data['appointment']->appointment_id; ?>" method="post">
            <button type="submit" class="action-button accept-button">Accept Appointment</button>
          </form>
        <?php endif; ?>
        <button class="action-button reject-button" data-id="<?php echo $data['appointment']->appointment_id; ?>">Reschedule Appointment</button>
      </div>
    </div>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>