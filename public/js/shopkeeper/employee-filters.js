document.addEventListener('DOMContentLoaded', function () {
    // Get filter elements
    const nameSearch = document.getElementById('name-search');
    const districtFilter = document.getElementById('district-filter');
    const applyButton = document.getElementById('apply-filters');
    const resetButton = document.getElementById('reset-filters');

    // Get the no results message
    const noResultsMsg = document.querySelector('.no-results');

    // Apply filters when apply button is clicked
    applyButton.addEventListener('click', applyFilters);

    // Reset filters button
    resetButton.addEventListener('click', resetFilters);

    // Add search-as-you-type functionality for name search
    nameSearch.addEventListener('input', function() {
        if (this.value.length >= 2 || this.value.length === 0) {
            applyFilters();
        }
    });

    // Main filter function
    function applyFilters() {
        const nameValue = nameSearch.value.toLowerCase();
        const districtValue = districtFilter.value;

        let visibleCount = 0;

        // Get all table rows except header
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            let showRow = true;

            // Filter by name
            if (nameValue) {
                const nameCell = row.cells[1].textContent.toLowerCase();
                if (!nameCell.includes(nameValue)) {
                    showRow = false;
                }
            }

            // Filter by district
            if (showRow && districtValue) {
                const districtCell = row.cells[5].textContent.trim();
                if (districtCell !== districtValue && districtCell !== 'Not specified') {
                    showRow = false;
                }
            }

            // Show or hide the row
            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show "No results" message if no rows are visible
        if (visibleCount === 0 && rows.length > 0) {
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }

    function resetFilters() {
        nameSearch.value = '';
        districtFilter.value = '';

        // Show all rows
        document.querySelectorAll('.product-table tbody tr').forEach(row => {
            row.style.display = '';
        });

        // Hide "No results" message
        noResultsMsg.style.display = 'none';
    }

    // Apply initial filters if any are set
    if (nameSearch.value || districtFilter.value) {
        applyFilters();
    }
});
