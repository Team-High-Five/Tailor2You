document.addEventListener('DOMContentLoaded', function () {
    // --- Main Design Preview ---
    const designPreview = document.getElementById('design-preview');
    const mainImageInput = document.getElementById('main-image');

    if (designPreview && mainImageInput) {
        // Handle file selection for main design image
        mainImageInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    designPreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Click on image triggers file input
        designPreview.addEventListener('click', function () {
            mainImageInput.click();
        });
    }

    // --- Customization Choice Management ---
    const customizationsTab = document.querySelector('#customizations');
    // Get the template from the hidden div
    const choiceTemplate = document.getElementById('choice-template').firstElementChild;

    if (customizationsTab && choiceTemplate) {
        // -- Add Choice Button Click --
        const addChoiceButtons = document.querySelectorAll('.add-choice');
        addChoiceButtons.forEach(button => {
            button.addEventListener('click', function () {
                const typeId = this.getAttribute('data-type');
                const choicesContainer = document.querySelector(`.customization-choices[data-type="${typeId}"]`);

                if (!choicesContainer) {
                    console.error(`Container for type ${typeId} not found`);
                    return;
                }

                // Clone the template
                const newChoice = choiceTemplate.cloneNode(true);

                // Update the name attributes to have the correct type_id
                newChoice.querySelectorAll('[name*="TYPE_ID"]').forEach(input => {
                    const name = input.getAttribute('name').replace('TYPE_ID', typeId);
                    input.setAttribute('name', name);
                });

                // Add to the container
                choicesContainer.appendChild(newChoice);

                // Setup image preview handling for this new choice
                setupChoiceImageHandling(newChoice);

                // Update accordion height to accommodate new content
                const accordionContent = choicesContainer.closest('.accordion-content');
                if (accordionContent && accordionContent.style.maxHeight) {
                    accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
                }
            });
        });

        // --- Setup image handling for a choice item ---
        function setupChoiceImageHandling(choiceItem) {
            const previewImg = choiceItem.querySelector('.choice-preview-img');
            const fileInput = choiceItem.querySelector('.choice-image-input');

            if (previewImg && fileInput) {
                // Preview the selected image
                fileInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Setup remove button
            const removeButton = choiceItem.querySelector('.remove-choice');
            if (removeButton) {
                removeButton.addEventListener('click', function () {
                    const accordionContent = choiceItem.closest('.accordion-content');
                    choiceItem.remove();

                    // Update accordion height after removing content
                    if (accordionContent && accordionContent.style.maxHeight) {
                        accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
                    }
                });
            }
        }

        // --- Event delegation for dynamic elements (using the customizations tab) ---
        customizationsTab.addEventListener('click', function (e) {
            // Handle clicks on remove buttons
            if (e.target.classList.contains('remove-choice')) {
                const choiceItem = e.target.closest('.choice-item');
                if (choiceItem) {
                    const accordionContent = choiceItem.closest('.accordion-content');
                    choiceItem.remove();

                    // Update accordion height after removing content
                    if (accordionContent && accordionContent.style.maxHeight) {
                        accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
                    }
                }
            }
            // Handle clicks on preview images
            if (e.target.classList.contains('choice-preview-img')) {
                const fileInput = e.target.closest('.choice-item').querySelector('.choice-image-input');
                if (fileInput) {
                    fileInput.click();
                }
            }
        });

        // Form validation
        const form = document.querySelector('form[action*="saveDesign"]');
        if (form) {
            form.addEventListener('submit', function (e) {
                let isValid = true;

                // Check each choice item
                document.querySelectorAll('.choice-item').forEach(item => {
                    const nameInput = item.querySelector('.name-input');
                    const fileInput = item.querySelector('.choice-image-input');

                    if (!nameInput || !fileInput) return;

                    const hasName = nameInput.value.trim() !== '';
                    const hasFile = fileInput.files && fileInput.files.length > 0;

                    // If one is provided, both must be
                    if ((hasName && !hasFile) || (!hasName && hasFile)) {
                        isValid = false;
                        // Add error styling
                        item.classList.add('has-error');
                        // Add error message if not already present
                        if (!item.querySelector('.error-message')) {
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'error-message';
                            errorMsg.textContent = 'Both name and image are required';
                            item.appendChild(errorMsg);
                        }
                    } else {
                        // Remove error styling
                        item.classList.remove('has-error');
                        // Remove any error message
                        const errorMsg = item.querySelector('.error-message');
                        if (errorMsg) errorMsg.remove();
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please complete all option details. Both image and name are required for each option you add.');
                }
            });
        }
    }
});