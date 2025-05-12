document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('search-bar');
    const resetButton = document.getElementById('reset-filters');
    const profileCards = document.querySelectorAll('.profile-card');

    // Custom dropdowns
    const dropdowns = document.querySelectorAll('.custom-dropdown');

    const filters = {
        gender: '',
        category: '',
        location: '',
    };

    // Initialize custom dropdowns
    dropdowns.forEach((dropdown) => {
        const selected = dropdown.querySelector('.custom-dropdown__selected');
        const options = dropdown.querySelectorAll('.custom-dropdown__option');

        // Toggle dropdown visibility
        selected.addEventListener('click', () => {
            dropdown.classList.toggle('open');
        

        // Handle option selection
        options.forEach((option) => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');
                const dropdownId = dropdown.id;

                // Update selected text
                selected.textContent = option.textContent;

                // Update filters object
                if (dropdownId === 'gender-dropdown') {
                    filters.gender = value;
                } else if (dropdownId === 'category-dropdown') {
                    filters.category = value;
                } else if (dropdownId === 'location-dropdown') {
                    filters.location = value;
                }

                // Close dropdown
                dropdown.classList.remove('open');

                // Apply filters
                applyFilters();
            });
        });


        // Dynamically position the dropdown options
        if (dropdown.classList.contains('open')) {
            const rect = selected.getBoundingClientRect();
            options.style.position = 'fixed';
            options.style.top = `${rect.bottom}px`;
            options.style.left = `${rect.left}px`;
            options.style.width = `${rect.width}px`;
            options.style.zIndex = 1000; // Ensure it is above other elements
        } else {
            options.style.position = '';
            options.style.top = '';
            options.style.left = '';
            options.style.width = '';
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
            options.style.position = '';
            options.style.top = '';
            options.style.left = '';
            options.style.width = '';
        }
    });
});

// Function to filter and search
function applyFilters() {
    const searchQuery = searchBar.value.toLowerCase();

    profileCards.forEach((card) => {
        const name = card.querySelector('.profile-card__name').textContent.toLowerCase();
        const profession = card.querySelector('.profile-card__profession').textContent.toLowerCase();
        const location = card.dataset.location.toLowerCase();
        const gender = card.dataset.gender.toLowerCase();
        const category = card.dataset.category.toLowerCase();

        // Check if the card matches all filters
        const matchesSearch = name.includes(searchQuery);
        const matchesGender = !filters.gender || gender === filters.gender;
        const matchesCategory = !filters.category || category === filters.category;
        const matchesLocation = !filters.location || location === filters.location;

        if (matchesSearch && matchesGender && matchesCategory && matchesLocation) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Event listener for search bar
searchBar.addEventListener('input', applyFilters);

// Reset filters
resetButton.addEventListener('click', function () {
    searchBar.value = '';
    filters.gender = '';
    filters.category = '';
    filters.location = '';

    // Reset dropdowns
    dropdowns.forEach((dropdown) => {
        const selected = dropdown.querySelector('.custom-dropdown__selected');
        if (dropdown.id === 'gender-dropdown') {
            selected.textContent = 'All Genders';
        } else if (dropdown.id === 'category-dropdown') {
            selected.textContent = 'All Categories';
        } else if (dropdown.id === 'location-dropdown') {
            selected.textContent = 'All Locations';
        }
    });

    applyFilters();
});
});