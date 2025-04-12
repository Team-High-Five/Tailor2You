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
    const optionSection = document.querySelector('.option-section');
    if (optionSection) {
        // --- Create New Choice Item ---
        const createChoiceItem = (typeId) => {
            const choiceItem = document.createElement('div');
            choiceItem.className = 'choice-item';
            choiceItem.innerHTML = `
                <div class="choice-image-container">
                    <img src="${URLROOT}/public/img/add-image.png" alt="Choice Preview" class="choice-preview-img">
                    <input type="file" name="choice_image[${typeId}][]" class="choice-image-input" accept="image/*">
                    <div class="required-badge">Required if adding option</div>
                </div>
                <input type="text" name="choice_name[${typeId}][]" placeholder="Option Name" class="name-input">
                <input type="number" name="choice_price[${typeId}][]" placeholder="Additional Cost (Optional)" step="0.01" class="price-input">
                <button type="button" class="remove-choice">×</button>
            `;
            
            // Add change event for name input
            const nameInput = choiceItem.querySelector('.name-input');
            const imageInput = choiceItem.querySelector('.choice-image-input');
            
            nameInput.addEventListener('change', function() {
                validateChoice(choiceItem);
            });
            
            imageInput.addEventListener('change', function() {
                validateChoice(choiceItem);
            });
            
            return choiceItem;
        };

        // --- Validate a choice item ---
        const validateChoice = (choiceItem) => {
            const nameInput = choiceItem.querySelector('.name-input');
            const imageInput = choiceItem.querySelector('.choice-image-input');
            const warning = choiceItem.querySelector('.warning-message') || document.createElement('div');
            
            // If either has content, both are required
            const nameHasContent = nameInput.value.trim() !== '';
            const imageHasFile = imageInput.files && imageInput.files.length > 0;
            
            // Remove previous warning if exists
            if (warning.parentElement === choiceItem) {
                choiceItem.removeChild(warning);
            }
            
            // Check if only one is provided but not both
            if ((nameHasContent && !imageHasFile) || (!nameHasContent && imageHasFile)) {
                warning.className = 'warning-message';
                warning.textContent = 'Both image and name are required for each option.';
                choiceItem.appendChild(warning);
                return false;
            }
            
            return true;
        };
        
        // --- Add Choice Button Click ---
        optionSection.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-choice')) {
                const button = event.target;
                const typeId = button.dataset.type;
                const choicesContainer = button.closest('.option-photo').querySelector(`.customization-choices[data-type="${typeId}"]`);
                
                const newChoiceItem = createChoiceItem(typeId);
                choicesContainer.appendChild(newChoiceItem);
            }

            // --- Remove Choice ---
            if (event.target.classList.contains('remove-choice')) {
                const button = event.target;
                const choiceItem = button.closest('.choice-item');
                const choicesContainer = choiceItem.closest('.customization-choices');
                
                choiceItem.remove();
            }

            // --- Trigger Choice File Input ---
            if (event.target.classList.contains('choice-preview-img')) {
                const img = event.target;
                const fileInput = img.closest('.choice-item').querySelector('.choice-image-input');
                if (fileInput) {
                    fileInput.click();
                }
            }
        });

        // --- Handle Choice Image Preview ---
        optionSection.addEventListener('change', function(event) {
            if (event.target.classList.contains('choice-image-input')) {
                const input = event.target;
                const previewImg = input.closest('.choice-item').querySelector('.choice-preview-img');

                if (input.files && input.files[0] && previewImg) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                
                // Validate after image change
                validateChoice(input.closest('.choice-item'));
            }
            
            // Validate choice when name changes
            if (event.target.classList.contains('name-input')) {
                validateChoice(event.target.closest('.choice-item'));
            }
        });
    }
    
    // --- Form Submission Validation ---
    const designForm = document.querySelector('form[action*="saveDesign"]');
    if (designForm) {
        designForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate all choice items
            document.querySelectorAll('.choice-item').forEach(item => {
                if (!validateChoice(item)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fix the errors in your customization options. Both name and image are required for each option you add.');
            }
        });
    }
});