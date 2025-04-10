document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('rescheduleModal');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.cancel-btn');
    const rescheduleForm = document.getElementById('rescheduleForm');
    const dateInput = document.getElementById('appointment_date');

    // Open modal when clicking reschedule button
    document.querySelectorAll('.reschedule-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const appointmentId = this.dataset.appointmentId;
            const tailorId = this.dataset.tailorId;
            
            document.getElementById('appointmentId').value = appointmentId;
            document.getElementById('tailorId').value = tailorId;
            
            modal.style.display = 'block';
            loadTimeSlots();
        });
    });

    // Close modal functions
    function closeModal() {
        modal.style.display = 'none';
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    window.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Load time slots when date changes
    dateInput.addEventListener('change', loadTimeSlots);

    function loadTimeSlots() {
        const date = dateInput.value;
        const tailorId = document.getElementById('tailorId').value;
        
        fetch(`${URLROOT}/appointments/getAvailableSlots/${tailorId}/${date}`)
            .then(response => response.json())
            .then(data => {
                const timeSlotsContainer = document.getElementById('timeSlots');
                timeSlotsContainer.innerHTML = '';

                // Generate time slots from 9 AM to 5 PM
                for (let hour = 9; hour <= 17; hour++) {
                    for (let minute = 0; minute < 60; minute += 30) {
                        const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}:00`;
                        const period = hour >= 12 ? 'PM' : 'AM';
                        const displayHour = hour > 12 ? hour - 12 : hour;
                        const displayTime = `${displayHour}:${String(minute).padStart(2, '0')} ${period}`;
                        
                        const isBooked = data.booked_slots.includes(time);
                        
                        const slot = document.createElement('div');
                        slot.className = `time-slot ${isBooked ? 'booked' : 'available'}`;
                        slot.innerHTML = `
                            <input type="radio" name="appointment_time" value="${time}" 
                                id="time_${time}" ${isBooked ? 'disabled' : ''} required>
                            <label for="time_${time}">${displayTime}</label>
                        `;
                        
                        if (!isBooked) {
                            slot.addEventListener('click', () => selectTimeSlot(slot));
                        }
                        
                        timeSlotsContainer.appendChild(slot);
                    }
                }
            });
    }

    function selectTimeSlot(slot) {
        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
        slot.classList.add('selected');
        slot.querySelector('input[type="radio"]').checked = true;
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
        });
    });
});