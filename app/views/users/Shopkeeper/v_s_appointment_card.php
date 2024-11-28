<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>
<div class="main-content">
  <div class="appointment-details-container">
    <div class="appointment-header">
      <p>Appointment #1067907</p>
      <a href="<?php echo URLROOT ?>/Shopkeepers/displayAppointments"><button class="close-btn">&times;</button></a>
    </div>
    <div class="appointment-info">
      <p class="appointment-date">22/09/2024 - 4:00 p.m.</p>
      <div class="user-info">
        <img src="../<?php APPROOT ?>/public/img/woman_avatar.png" alt="User profile" class="user-avatar">
        <span class="user-name">Christine Brooks</span>
      </div>
      <div class="calendar-icon">
        <div class="month">September</div>
        <div class="date">22</div>
        <div class="day">Sunday</div>
      </div>
    </div>
    <div class="status accepted">Accepted</div>

    <div class="tailor-info">
      <p><strong>Assigned Tailor</strong> Sudarshani P.H.</p>
    </div>
    <button class="reschedule-btn">Request For Rescheduling</button>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>