<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/Customer_Appointments_styles.css'>

<div class="cusmain">
    <div class="cusappointment-container">
        <?php if (empty($data['appointments'])) : ?>
            <div class="no-appointments">
                <i class="fas fa-calendar-times"></i>
                <h2>No Appointments Available</h2>
                <p>You currently don't have any appointments scheduled.</p>
                <a href="<?php echo URLROOT; ?>/pages/meetTailor" class="btn">Book an Appointment</a>
            </div>
        <?php else : ?>
            <?php foreach ($data['appointments'] as $appointment) : ?>
                <div class="cusappointment">
                    <div class="calendar">
                        <div class="month"><?php echo date('F', strtotime($appointment->appointment_date)); ?></div>
                        <div class="date"><?php echo date('d', strtotime($appointment->appointment_date)); ?></div>
                        <div class="day"><?php echo date('l', strtotime($appointment->appointment_date)); ?></div>
                    </div>
                    <div class="details">
                        <h3>Appointment #<?php echo $appointment->appointment_id; ?></h3>
                        <p><?php echo date('d/m/Y - h:i a', strtotime($appointment->appointment_date . ' ' . $appointment->appointment_time)); ?></p>
                        <div class="tailor-info">
                            <?php if ($appointment->tailor_profile_pic) : ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($appointment->tailor_profile_pic); ?>" alt="Tailor">
                            <?php else : ?>
                                <img src="<?php echo URLROOT; ?>/public/img/default-profile.jpg" alt="Tailor">
                            <?php endif; ?>
                            <span>Tailor - <?php echo $appointment->tailor_first_name . ' ' . $appointment->tailor_last_name; ?></span>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="status <?php echo strtolower($appointment->status); ?>" disabled>
                            <?php echo ucfirst(strtolower($appointment->status)); ?>
                        </button>
                        <?php if ($appointment->status !== 'completed'): ?>
                            <button class="reschedule-btn" 
                                    data-appointment-id="<?php echo $appointment->appointment_id; ?>"
                                    data-tailor-id="<?php echo $appointment->tailor_id; ?>">
                                Reschedule
                            </button>
                            <button class="cancel">Cancel</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div id="rescheduleModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Reschedule Appointment</h2>
                    <span class="close-modal">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="rescheduleForm" method="post">
                        <input type="hidden" id="appointmentId" name="appointment_id">
                        <input type="hidden" id="tailorId" name="tailor_id">
                        
                        <div class="form-group">
                            <label for="appointment_date">Select Date</label>
                            <input type="date" id="appointment_date" name="appointment_date" 
                                   min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Select Time</label>
                            <div class="time-slots-container">
                                <div class="time-slots" id="timeSlots">
                                    <!-- Time slots will be populated dynamically -->
                                </div>
                            </div>
                            <div class="time-slots-legend">
                                <div class="legend-item">
                                    <span class="legend-color available"></span>
                                    <span>Available</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color booked"></span>
                                    <span>Booked</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color selected"></span>
                                    <span>Selected</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-actions">
                            <button type="submit" class="confirm-btn">Confirm Reschedule</button>
                            <button type="button" class="cancel-btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cancelAppointment(appointmentId) {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            window.location.href = '<?php echo URLROOT; ?>/appointments/cancel/' + appointmentId;
        }
    }
</script>

<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>