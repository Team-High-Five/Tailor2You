document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category');
    const subCategorySelect = document.getElementById('sub-category');
    const genderInputs = document.querySelectorAll('input[name="gender"]');
    const fileInput = document.getElementById('main_image');
    const fileInfo = document.querySelector('.file-info');
    const fileName = document.querySelector('.file-name');

    // Filter categories based on gender selection
    function filterCategories() {
        const selectedGender = document.querySelector('input[name="gender"]:checked').value;

        Array.from(categorySelect.options).forEach(option => {
            if (option.value === '') return;

            const optionGender = option.getAttribute('data-gender');
            if (optionGender === selectedGender || optionGender === 'unisex') {
                option.style.display = '';
            } else {
                option.style.display = 'none';
                // If the hidden option is currently selected, reset the selection
                if (option.selected) {
                    categorySelect.value = '';
                    // Also reset subcategories
                    subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                }
            }
        });
    }


    categorySelect.addEventListener('change', function () {
        const categoryId = this.value;

        if (categoryId) {
            // Load subcategories
            fetch('<?php echo URLROOT; ?>/designs/getSubcategories/' + categoryId)
                .then(response => response.text())
                .then(html => {
                    subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>' + html;
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                    subCategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
                });
        } else {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
        }
    });

    // File input styling
    fileInput.addEventListener('change', function (e) {
        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
            fileInfo.classList.add('has-file');
        } else {
            fileName.textContent = '';
            fileInfo.classList.remove('has-file');
        }
    });

    // Drag and drop functionality
    fileInfo.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileInfo.addEventListener('dragleave', function () {
        this.classList.remove('dragover');
    });

    fileInfo.addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('dragover');

        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileName.textContent = e.dataTransfer.files[0].name;
            fileInfo.classList.add('has-file');
        }
    });

    fileInfo.addEventListener('click', function () {
        fileInput.click();
    });

    // Apply gender filter when gender selection changes
    genderInputs.forEach(input => {
        input.addEventListener('change', filterCategories);
    });

    filterCategories();
});

// Handle adding more customization options
document.querySelectorAll('.add-more-btn').forEach(button => {
    button.addEventListener('click', function () {
        const typeId = this.getAttribute('data-type');
        const rowTemplate = `
        <div class="customization-row" data-type-id="${typeId}">
            <div class="option-inputs">
                <div class="form-group">
                    <input type="text" name="choice_name[${typeId}][]" placeholder="Option name">
                </div>
                <div class="form-group">
                    <input type="number" name="choice_price[${typeId}][]" placeholder="Additional price" min="0" step="0.01">
                </div>
                <div class="form-group file-upload">
                    <label class="file-label">
                        <input type="file" name="choice_image[${typeId}][]" accept="image/*">
                        <span>Choose Image</span>
                    </label>
                </div>
            </div>
            <button type="button" class="remove-row-btn">×</button>
        </div>
    `;

        // Find the container for this type
        const container = this.closest('.customization-options');

        // Create a temporary div to hold the HTML
        const temp = document.createElement('div');
        temp.innerHTML = rowTemplate;

        // Append the new row
        container.appendChild(temp.firstElementChild);

        // Add event listener to the new remove button
        container.querySelector('.customization-row:last-child .remove-row-btn')
            .addEventListener('click', function () {
                this.closest('.customization-row').remove();
            });
    });
});

// Handle file inputs for custom styling
document.addEventListener('change', function (e) {
    if (e.target && e.target.type === 'file' && e.target.closest('.file-label')) {
        const fileLabel = e.target.closest('.file-label');
        if (e.target.files.length > 0) {
            fileLabel.querySelector('span').textContent = e.target.files[0].name;
            fileLabel.classList.add('has-file');
        } else {
            fileLabel.querySelector('span').textContent = 'Choose Image';
            fileLabel.classList.remove('has-file');
        }
    }
});
if (document.getElementById('debug-images')) {
    document.getElementById('debug-images').addEventListener('click', function () {
        const debugOutput = document.getElementById('debug-output');
        const imageElements = document.querySelectorAll('.choice-image img');

        let debugHTML = '<h4>Image Path Information:</h4><ul>';

        imageElements.forEach((img, index) => {
            const src = img.getAttribute('src');
            const alt = img.getAttribute('alt');
            const status = img.complete && img.naturalHeight !== 0 ? 'Loaded' : 'Failed to load';

            debugHTML += `<li>Image ${index + 1} (${alt}):<br>
                     Path: ${src}<br>
                     Status: <span class="${status === 'Loaded' ? 'success' : 'error'}">${status}</span></li>`;
        });

        debugHTML += '</ul>';
        debugOutput.innerHTML = debugHTML;
        debugOutput.style.display = debugOutput.style.display === 'none' ? 'block' : 'none';
    });
}
// Custom Measurements JavaScript
document.getElementById('add-custom-measurement').addEventListener('click', function () {
    customMeasurementCount++;

    // Create new measurement item
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
                    <option value="length" selected>Length</option>
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

    // Add to container
    document.getElementById('custom-measurements-container').appendChild(measurementItem);

    // Add event listener to the remove button
    const removeBtn = measurementItem.querySelector('.remove-measurement');
    removeBtn.addEventListener('click', function () {
        measurementItem.remove();
    });
});

// Set up existing remove buttons
document.querySelectorAll('.remove-measurement').forEach(button => {
    button.addEventListener('click', function () {
        this.closest('.custom-measurement-item').remove();
    });
});