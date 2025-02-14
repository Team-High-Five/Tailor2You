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
                        <button class="status <?php echo strtolower($appointment->status); ?>"><?php echo ucfirst($appointment->status); ?></button>
                        <?php if ($appointment->status !== 'accepted') : ?>
                            <button class="cancel" onclick="cancelAppointment(<?php echo $appointment->appointment_id; ?>)">Cancel</button>
                            <a href="<?php echo URLROOT; ?>/appointments/reschedule/<?php echo $appointment->appointment_id; ?>" class="action-link">Request For Rescheduling</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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