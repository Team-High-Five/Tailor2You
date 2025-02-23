class DesignManager {
    constructor() {
        // Add button and modal elements check
        const addButton = document.getElementById('openModalBtn');
        const modal = document.getElementById('customizeModal');
        const closeBtn = document.querySelector('.close-btn');

        if (!addButton || !modal || !closeBtn) {
            console.error('Required elements not found');
            return;
        }

        this.modal = modal;
        this.modalBody = document.getElementById('modal-body');
        this.addButton = addButton;
        this.closeBtn = closeBtn;

        this.init();
    }

    init() {
        // Bind event listeners with proper context
        this.addButton.addEventListener('click', () => {
            console.log('Opening modal...');
            this.openModal();
        });

        this.closeBtn.addEventListener('click', () => {
            console.log('Closing modal...');
            this.closeModal();
        });

        window.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });
    }

    openModal() {
        console.log('Fetching content...');
        fetch(`${URLROOT}/designs/addCustomizeItem`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                this.modalBody.innerHTML = html;
                this.modal.style.display = 'block';
                this.setupFormHandlers();
            })
            .catch(error => {
                console.error('Error:', error);
                this.modalBody.innerHTML = '<p class="error">Failed to load content</p>';
            });
    }
    closeModal() {
        this.modal.style.display = 'none';
        this.modalBody.innerHTML = '';
    }

    setupFormHandlers() {
        const categorySelect = document.getElementById('category');
        const subCategorySelect = document.getElementById('sub-category');
        const genderInputs = document.querySelectorAll('input[name="gender"]');

        if (categorySelect) {
            const originalCategories = [...categorySelect.options].slice(1);

            // Handle gender selection
            genderInputs.forEach(input => {
                input.addEventListener('change', () => {
                    this.filterCategories(input.value, categorySelect, subCategorySelect, originalCategories);
                });
            });

            // Handle category selection
            categorySelect.addEventListener('change', () => {
                const categoryId = categorySelect.value;
                if (categoryId) {
                    this.loadSubcategories(categoryId, subCategorySelect);
                } else {
                    subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                }
            });
        }
    }

    filterCategories(gender, categorySelect, subCategorySelect, originalCategories) {
        categorySelect.innerHTML = '<option value="">Select Category</option>';
        originalCategories.forEach(option => {
            if (option.dataset.gender === gender || option.dataset.gender === 'unisex') {
                categorySelect.appendChild(option.cloneNode(true));
            }
        });
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
    }

    loadSubcategories(categoryId, subCategorySelect) {
        fetch(`${URLROOT}/designs/getSubcategories/${categoryId}`)
            .then(response => response.text())
            .then(html => {
                subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>' + html;
            })
            .catch(error => {
                console.error('Error:', error);
                subCategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
            });
    }
}

// Initialize with error handling
document.addEventListener('DOMContentLoaded', () => {
    try {
        new DesignManager();
    } catch (error) {
        console.error('Failed to initialize DesignManager:', error);
    }
});
