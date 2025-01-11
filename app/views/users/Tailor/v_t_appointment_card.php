<div class="appointment-details-container">
  <div class="add-new-post-content">
    <div class="modal-header">
      <h1>Appointment #<?php echo $data['appointment']->appointment_id; ?></h1>
      <a href="<?php echo URLROOT ?>/Tailors/displayAppointments"><button class="close-btn">&times;</button></a>
    </div>
    <div class="appointment-info">
      <p class="appointment-date"><?php echo date('d/m/Y - h:i a', strtotime($data['appointment']->appointment_date . ' ' . $data['appointment']->appointment_time)); ?></p>
      <div class="user-info">
        <img src="<?php echo URLROOT; ?>/public/img/woman_avatar.png" alt="User profile" class="user-avatar">
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
      <p><strong>Assigned Tailor</strong> <?php echo $data['appointment']->tailor_first_name . ' ' . $data['appointment']->tailor_last_name; ?></p>
    </div>
    <div class="action-buttons">
      <button class="action-button accept-button">Accept Appointment</button>
      <button class="action-button reject-button" data-id="<?php echo $data['appointment']->appointment_id; ?>">Reschedule Appointment</button>
    </div>
  </div>
</div>
