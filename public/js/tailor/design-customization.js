document.addEventListener('DOMContentLoaded', function () {
    // Image preview handling
    document.getElementById('main-image').addEventListener('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('design-preview').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Add new customization choice
    document.querySelectorAll('.add-choice').forEach(button => {
        button.addEventListener('click', function () {
            const typeId = this.dataset.type;
            const container = document.querySelector(`.customization-choices[data-type="${typeId}"]`);

            const newChoice = document.createElement('div');
            newChoice.className = 'choice-item';
            newChoice.innerHTML = `
                <input type="file" name="choice_image[${typeId}][]" class="choice-image" accept="image/*">
                <input type="text" name="choice_name[${typeId}][]" placeholder="Option Name" class="name-input" required>
                <input type="number" name="choice_price[${typeId}][]" placeholder="Additional Cost" step="0.01" class="price-input">
                <button type="button" class="remove-choice">×</button>
            `;

            container.appendChild(newChoice);
        });
    });

    // Remove customization choice
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-choice')) {
            e.target.closest('.choice-item').remove();
        }
    });
});