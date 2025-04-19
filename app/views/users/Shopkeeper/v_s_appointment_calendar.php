<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="calendar">
    <div class="calendar-header">
      <?php
      $prevMonth = $data['month'] - 1;
      $prevYear = $data['year'];
      if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
      }

      $nextMonth = $data['month'] + 1;
      $nextYear = $data['year'];
      if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
      }
      ?>
      <a href="<?php echo URLROOT; ?>/shopkeepers/displayCalendar/<?php echo $prevYear; ?>/<?php echo str_pad($prevMonth, 2, '0', STR_PAD_LEFT); ?>">&lt;</a>
      <h3><?php echo date('F Y', strtotime($data['year'] . '-' . $data['month'] . '-01')); ?></h3>
      <a href="<?php echo URLROOT; ?>/shopkeepers/displayCalendar/<?php echo $nextYear; ?>/<?php echo str_pad($nextMonth, 2, '0', STR_PAD_LEFT); ?>">&gt;</a>
    </div>
    <div class="calendar-grid">
      <div>Mon</div>
      <div>Tue</div>
      <div>Wed</div>
      <div>Thu</div>
      <div>Fri</div>
      <div>Sat</div>
      <div>Sun</div>

      <?php
      $firstDayOfMonth = strtotime($data['year'] . '-' . $data['month'] . '-01');
      $daysInMonth = date('t', $firstDayOfMonth);
      $dayOfWeek = date('N', $firstDayOfMonth);
      $currentDate = date('Y-m-d');

      // Print empty cells for days before the first day of the month
      for ($i = 1; $i < $dayOfWeek; $i++) {
        echo '<div class="day"></div>';
      }

      // Print days of the month
      for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = $data['year'] . '-' . $data['month'] . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
        $isCurrent = ($date == $currentDate) ? 'current' : '';
        echo '<div class="day ' . $isCurrent . '">';
        echo '<div class="day-number">' . $day . '</div>';

        // Print appointments for the day
        foreach ($data['appointments'] as $appointment) {
          if ($appointment->appointment_date == $date) {
            echo '<div class="appointment">';
            echo '<div class="appointment-time">' . date('h:i a', strtotime($appointment->appointment_time)) . '</div>';
            echo '<div class="appointment-customer">' . $appointment->first_name . ' ' . $appointment->last_name . '</div>';
            echo '</div>';
          }
        }

        echo '</div>';
      }
      ?>
    </div>
  </div>
</div>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>