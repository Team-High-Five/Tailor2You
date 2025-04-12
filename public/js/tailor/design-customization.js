// Add this to a design-customization.js file and include it in your page

document.addEventListener('DOMContentLoaded', function () {
    // Design preview image functionality
    const designPreview = document.getElementById('design-preview');
    const mainImage = document.getElementById('main-image');

    if (designPreview && mainImage) {
        mainImage.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    designPreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Click on image to trigger file input
        designPreview.addEventListener('click', function () {
            mainImage.click();
        });
    }

    // Add/remove customization options
    document.querySelectorAll('.add-choice').forEach(button => {
        button.addEventListener('click', function () {
            const typeId = this.dataset.type;
            const choicesContainer = document.querySelector(`.customization-choices[data-type="${typeId}"]`);
            const choiceItem = choicesContainer.querySelector('.choice-item').cloneNode(true);

            // Clear inputs in the cloned node
            choiceItem.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
                input.value = '';
            });

            // Add event listener to remove button
            const removeButton = choiceItem.querySelector('.remove-choice');
            removeButton.addEventListener('click', function () {
                choiceItem.remove();
            });

            choicesContainer.appendChild(choiceItem);
        });
    });

    // Initial setup for remove buttons
    document.querySelectorAll('.remove-choice').forEach(button => {
        button.addEventListener('click', function () {
            if (this.closest('.customization-choices').querySelectorAll('.choice-item').length > 1) {
                this.closest('.choice-item').remove();
            }
        });
    });
});