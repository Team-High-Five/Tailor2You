document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('rescheduleModal');
    const closeModal = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.cancel-btn');
    const rescheduleForm = document.getElementById('rescheduleForm');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');

    // Open modal and set appointment data
    document.querySelectorAll('.reschedule-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const appointmentId = this.dataset.appointmentId;
            const tailorId = this.dataset.tailorId;
            
            document.getElementById('appointmentId').value = appointmentId;
            document.getElementById('tailorId').value = tailorId;
            
            modal.style.display = 'block';
            loadAvailableTimeSlots();
        });
    });

    // Close modal functions
    function closeRescheduleModal() {
        modal.style.display = 'none';
        rescheduleForm.reset();
    }

    closeModal.addEventListener('click', closeRescheduleModal);
    cancelBtn.addEventListener('click', closeRescheduleModal);
    
    // Close on outside click
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeRescheduleModal();
        }
    });

    // Load available time slots when date changes
    dateInput.addEventListener('change', loadAvailableTimeSlots);

    function loadAvailableTimeSlots() {
        const date = dateInput.value;
        const tailorId = document.getElementById('tailorId').value;

        if (!date || !tailorId) return;

        // Disable all time slots initially
        Array.from(timeSelect.options).forEach(option => {
            option.disabled = false;
        });

        // Fetch booked slots from server
        fetch(`${URLROOT}/appointments/getBookedSlots/${tailorId}/${date}`)
            .then(response => response.json())
            .then(data => {
                if (data.booked_slots) {
                    data.booked_slots.forEach(slot => {
                        const option = Array.from(timeSelect.options)
                            .find(opt => opt.value === slot);
                        if (option) {
                            option.disabled = true;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error loading time slots:', error);
            });
    }

    // Handle form submission
    rescheduleForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(`${URLROOT}/appointments/reschedule`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to reschedule appointment');
            }
        })
        .catch(error => {
            console.error('Error rescheduling appointment:', error);
            alert('An error occurred while rescheduling the appointment');
        });
    });
});