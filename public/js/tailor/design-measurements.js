document.addEventListener('DOMContentLoaded', function () {
    // Get references to the custom measurement elements
    const addCustomMeasurementBtn = document.getElementById('add-custom-measurement');
    const customMeasurementsContainer = document.getElementById('custom-measurements-container');

    // Counter for creating unique IDs
    let customMeasurementCount = 0;

    // Add event listener to the button
    if (addCustomMeasurementBtn) {
        addCustomMeasurementBtn.addEventListener('click', function () {
            addCustomMeasurement();
        });
    }

    // Function to add a new custom measurement
    function addCustomMeasurement() {
        customMeasurementCount++;

        // Create a new measurement item
        const measurementItem = document.createElement('div');
        measurementItem.className = 'custom-measurement-item';
        measurementItem.dataset.id = customMeasurementCount;

        // HTML for the measurement item
        measurementItem.innerHTML = `
            <div class="custom-measurement-header">
                <h4>Custom Measurement #${customMeasurementCount}</h4>
                <button type="button" class="remove-measurement">×</button>
            </div>
            <div class="custom-measurement-form">
                <div class="form-group">
                    <label for="custom_name_${customMeasurementCount}">Measurement Name*</label>
                    <input type="text" id="custom_name_${customMeasurementCount}" name="custom_name[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="custom_display_name_${customMeasurementCount}">Display Name*</label>
                    <input type="text" id="custom_display_name_${customMeasurementCount}" name="custom_display_name[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="custom_description_${customMeasurementCount}">Description</label>
                    <textarea id="custom_description_${customMeasurementCount}" name="custom_description[]" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="custom_unit_type_${customMeasurementCount}">Measurement Type*</label>
                        <select id="custom_unit_type_${customMeasurementCount}" name="custom_unit_type[]" class="form-control" required>
                            <option value="length">Length</option>
                            <option value="circumference">Circumference</option>
                            <option value="angle">Angle</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group half-width">
                        <label for="custom_required_${customMeasurementCount}">Required?</label>
                        <select id="custom_required_${customMeasurementCount}" name="custom_required[]" class="form-control">
                            <option value="1" selected>Required</option>
                            <option value="0">Optional</option>
                        </select>
                    </div>
                </div>
            </div>
        `;

        // Add the new measurement item to the container
        customMeasurementsContainer.appendChild(measurementItem);

        // Add event listener to the remove button
        const removeBtn = measurementItem.querySelector('.remove-measurement');
        removeBtn.addEventListener('click', function () {
            customMeasurementsContainer.removeChild(measurementItem);
        });

        // Scroll to the new measurement item
        measurementItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Form validation for the measurements tab
    const form = document.querySelector('form[action*="saveDesign"]');
    if (form) {
        form.addEventListener('submit', function (e) {
            // Check if we're on the measurements tab and validate
            const measurementsTab = document.querySelector('#measurements.tab-pane.active');
            if (measurementsTab) {
                // Validate that at least one measurement is selected
                const standardMeasurements = document.querySelectorAll('input[name="measurements[]"]:checked');
                const customMeasurements = document.querySelectorAll('.custom-measurement-item');

                if (standardMeasurements.length === 0 && customMeasurements.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one measurement or add a custom measurement for this design.');
                }

                // Validate each custom measurement
                customMeasurements.forEach(item => {
                    const nameInput = item.querySelector('input[name="custom_name[]"]');
                    const displayNameInput = item.querySelector('input[name="custom_display_name[]"]');

                    if (!nameInput.value.trim() || !displayNameInput.value.trim()) {
                        e.preventDefault();
                        item.classList.add('has-error');

                        // Add error message if not already present
                        if (!item.querySelector('.error-message')) {
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'error-message';
                            errorMsg.textContent = 'Name and Display Name are required for custom measurements';
                            item.querySelector('.custom-measurement-form').appendChild(errorMsg);
                        }
                    } else {
                        item.classList.remove('has-error');
                        const errorMsg = item.querySelector('.error-message');
                        if (errorMsg) errorMsg.remove();
                    }
                });
            }
        });
    }
});