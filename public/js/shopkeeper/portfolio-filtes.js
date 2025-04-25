document.addEventListener('DOMContentLoaded', function () {
    // Get filter elements
    const genderFilter = document.getElementById('filter-gender');
    const itemTypeFilter = document.getElementById('filter-item-type');
    const dateFilter = document.getElementById('filter-date');
    const resetButton = document.getElementById('reset-filters');

    // Get the no results message
    const noResultsMsg = document.querySelector('.no-results');

    // Apply filters when any select changes
    genderFilter.addEventListener('change', applyFilters);
    itemTypeFilter.addEventListener('change', applyFilters);
    dateFilter.addEventListener('change', applyFilters);

    // Reset filters button
    resetButton.addEventListener('click', resetFilters);

    // Main filter function
    function applyFilters() {
        const genderValue = genderFilter.value.toLowerCase();
        const itemTypeValue = itemTypeFilter.value.toLowerCase();
        const dateValue = dateFilter.value;

        let visibleCount = 0;
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set to start of today

        // Get all portfolio items
        const items = document.querySelectorAll('.portfolio-item');

        items.forEach(item => {
            let showItem = true;

            // Filter by gender
            if (genderValue && showItem) {
                const gender = item.getAttribute('data-gender');
                if (genderValue !== gender) {
                    showItem = false;
                }
            }

            // Filter by item type
            if (itemTypeValue && showItem) {
                const itemType = item.getAttribute('data-item-type');
                if (itemTypeValue !== itemType) {
                    showItem = false;
                }
            }

            // Filter by date
            if (dateValue && showItem) {
                const timestamp = parseInt(item.getAttribute('data-timestamp'));
                const itemDate = new Date(timestamp * 1000); // Convert timestamp to date

                const oneWeekAgo = new Date(today);
                oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);

                const oneMonthAgo = new Date(today);
                oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);

                const oneYearAgo = new Date(today);
                oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);

                switch (dateValue) {
                    case 'today':
                        // Compare dates without time
                        const todayStr = today.toDateString();
                        const itemDateStr = itemDate.toDateString();
                        if (itemDateStr !== todayStr) {
                            showItem = false;
                        }
                        break;
                    case 'week':
                        if (itemDate < oneWeekAgo) {
                            showItem = false;
                        }
                        break;
                    case 'month':
                        if (itemDate < oneMonthAgo) {
                            showItem = false;
                        }
                        break;
                    case 'year':
                        if (itemDate < oneYearAgo) {
                            showItem = false;
                        }
                        break;
                }
            }

            // Show or hide the item
            if (showItem) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show "No results" message if no items are visible
        if (visibleCount === 0 && items.length > 0) {
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }

    function resetFilters() {
        genderFilter.value = '';
        itemTypeFilter.value = '';
        dateFilter.value = '';

        // Show all items
        document.querySelectorAll('.portfolio-item').forEach(item => {
            item.style.display = '';
        });

        // Hide "No results" message
        noResultsMsg.style.display = 'none';
    }

    // Apply initial filters if any are set
    if (genderFilter.value || itemTypeFilter.value || dateFilter.value) {
        applyFilters();
    }
});
