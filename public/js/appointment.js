document.addEventListener('DOMContentLoaded', function() {
    const appointmentDateInput = document.getElementById('appointment_date');
    const appointmentTimeInput = document.getElementById('appointment_time');
    const rescheduleForm = document.getElementById('reschedule-form');

    rescheduleForm.addEventListener('submit', function(event) {
        const currentDate = new Date();
        const selectedDate = new Date(appointmentDateInput.value);
        const selectedTime = appointmentTimeInput.value.split(':');
        selectedDate.setHours(selectedTime[0], selectedTime[1]);

        if (selectedDate < currentDate) {
            event.preventDefault();
            alert('The selected date and time cannot be before the current date and time.');
        }
    });
});