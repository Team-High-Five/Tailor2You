<div id="rescheduleAppointmentModal" class="modal">
    <div class="add-new-post-content">
        <div class="modal-header">
            <h1>Reschedule Appointment #<?php echo $data['appointment']->appointment_id; ?></h1>
            <button class="close-btn">&times;</button>
        </div>
        <form id="reschedule-form" action="<?php echo URLROOT; ?>/tailors/rescheduleAppointment/<?php echo $data['appointment']->appointment_id; ?>" method="post">
            <div class="form-group">
                <label for="appointment_date">New Date</label>
                <input type="date" id="appointment_date" name="appointment_date" value="<?php echo $data['appointment']->appointment_date; ?>" required>
            </div>
            <div class="form-group">
                <label for="appointment_time">New Time</label>
                <select id="appointment_time" name="appointment_time" required>
                    <?php
                    // Generate 30-minute time slots from 00:00 to 23:30
                    for ($hour = 0; $hour < 24; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 30) {
                            $time = sprintf('%02d:%02d', $hour, $minute);
                            $selected = ($time == date('H:i', strtotime($data['appointment']->appointment_time))) ? 'selected' : '';
                            echo "<option value=\"$time\" $selected>$time</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="submit-btn">Reschedule</button>
        </form>
    </div>
</div>