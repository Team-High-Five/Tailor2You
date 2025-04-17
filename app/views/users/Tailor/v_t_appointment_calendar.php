<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

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
      <a href="<?php echo URLROOT; ?>/tailors/displayCalendar/<?php echo $prevYear; ?>/<?php echo str_pad($prevMonth, 2, '0', STR_PAD_LEFT); ?>">&lt;</a>
      <h3><?php echo date('F Y', strtotime($data['year'] . '-' . $data['month'] . '-01')); ?></h3>
      <a href="<?php echo URLROOT; ?>/tailors/displayCalendar/<?php echo $nextYear; ?>/<?php echo str_pad($nextMonth, 2, '0', STR_PAD_LEFT); ?>">&gt;</a>
    </div>
    <div class="calendar-grid">
      <!-- Weekday headers with better semantic markup -->
      <div class="weekday">Mon</div>
      <div class="weekday">Tue</div>
      <div class="weekday">Wed</div>
      <div class="weekday">Thu</div>
      <div class="weekday">Fri</div>
      <div class="weekday">Sat</div>
      <div class="weekday">Sun</div>

      <?php
      $firstDayOfMonth = strtotime($data['year'] . '-' . $data['month'] . '-01');
      $daysInMonth = date('t', $firstDayOfMonth);
      $dayOfWeek = date('N', $firstDayOfMonth);
      $currentDate = date('Y-m-d');
      $today = date('Y-m-d');

      // Print empty cells for days before the first day of the month
      for ($i = 1; $i < $dayOfWeek; $i++) {
        echo '<div class="day"></div>';
      }

      // Print days of the month
      for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = $data['year'] . '-' . $data['month'] . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

        // Determine day classes
        $classes = ['day'];
        if ($date == $today) {
          $classes[] = 'current';
        } elseif ($date < $today) {
          $classes[] = 'past';
        }

        echo '<div class="' . implode(' ', $classes) . '">';
        echo '<div class="day-number">' . $day . '</div>';

        // Count appointments for this day
        $dayAppointments = array_filter($data['appointments'], function ($appointment) use ($date) {
          return $appointment->appointment_date == $date;
        });

        // Display appointments (limit to 3 for cleaner display)
        $count = 0;
        foreach ($dayAppointments as $appointment) {
          if ($count < 3) {
            echo '<div class="appointment">';
            echo '<div class="appointment-time">' . date('h:i a', strtotime($appointment->appointment_time)) . '</div>';
            echo '<div class="appointment-customer">' . $appointment->first_name . ' ' . $appointment->last_name . '</div>';
            echo '</div>';
          }
          $count++;
        }

        // Show indicator for more appointments
        if (count($dayAppointments) > 3) {
          $more = count($dayAppointments) - 3;
          echo '<div class="more-appointments">+' . $more . ' more</div>';
        }

        echo '</div>';
      }
      ?>
    </div>
  </div>

  <?php require_once APPROOT . '/views/users/Tailor/inc/Footer.php'; ?>