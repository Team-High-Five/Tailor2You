document.addEventListener('DOMContentLoaded', function () {
    // Get filter elements
    const dateFilter = document.getElementById('filter-date');
    const timeFilter = document.getElementById('filter-time');
    const statusFilter = document.getElementById('filter-status');
    const resetButton = document.getElementById('reset-filters');

    // Get the no results message
    const noResultsMsg = document.querySelector('.no-orders');

    // Apply filters when any select changes
    dateFilter.addEventListener('change', applyFilters);
    timeFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

    // Reset filters button
    resetButton.addEventListener('click', resetFilters);

    // Main filter function
    function applyFilters() {
        const dateValue = dateFilter.value;
        const timeValue = timeFilter.value;
        const statusValue = statusFilter.value.toLowerCase();

        let visibleCount = 0;
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set to start of today

        // Get all table rows except header
        const rows = document.querySelectorAll('.order-table tbody tr');

        rows.forEach(row => {
            let showRow = true;

            // Filter by date
            if (dateValue) {
                const timestamp = parseInt(row.getAttribute('data-timestamp'));
                const orderDate = new Date(timestamp * 1000); // Convert timestamp to date

                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);

                const nextWeek = new Date(today);
                nextWeek.setDate(nextWeek.getDate() + 7);

                const nextMonth = new Date(today);
                nextMonth.setDate(nextMonth.getDate() + 30);

                switch (dateValue) {
                    case 'today':
                        // Compare dates without time
                        const todayStr = today.toDateString();
                        const orderDateStr = orderDate.toDateString();
                        if (orderDateStr !== todayStr) {
                            showRow = false;
                        }
                        break;
                    case 'tomorrow':
                        const tomorrowStr = tomorrow.toDateString();
                        const orderDateStr2 = orderDate.toDateString();
                        if (orderDateStr2 !== tomorrowStr) {
                            showRow = false;
                        }
                        break;
                    case 'week':
                        if (orderDate < today || orderDate > nextWeek) {
                            showRow = false;
                        }
                        break;
                    case 'month':
                        if (orderDate < today || orderDate > nextMonth) {
                            showRow = false;
                        }
                        break;
                }
            }

            // Filter by price range (replacing time filter)
            if (showRow && timeValue) {
                const priceValue = parseFloat(row.getAttribute('data-price'));
                
                switch(timeValue) {
                    case 'morning': // Under 1000
                        if (priceValue >= 1000) {
                            showRow = false;
                        }
                        break;
                    case 'afternoon': // 1000-3000
                        if (priceValue < 1000 || priceValue > 3000) {
                            showRow = false;
                        }
                        break;
                    case 'evening': // Over 3000
                        if (priceValue <= 3000) {
                            showRow = false;
                        }
                        break;
                }
            }

            // Filter by status
            if (showRow && statusValue && statusValue !== '') {
                const status = row.getAttribute('data-status');
                if (status !== statusValue) {
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
            if (noResultsMsg) {
                noResultsMsg.style.display = 'block';
            } else {
                // If no message exists, create one
                const table = document.querySelector('.order-table');
                const tbody = table.querySelector('tbody');
                
                if (!tbody.querySelector('.no-orders')) {
                    const noOrdersRow = document.createElement('tr');
                    noOrdersRow.className = 'no-orders';
                    noOrdersRow.innerHTML = '<td colspan="7"><p>No orders match your filters</p></td>';
                    tbody.appendChild(noOrdersRow);
                }
            }
        } else {
            // Hide the no results message if it exists
            const noOrdersRow = document.querySelector('.no-orders');
            if (noOrdersRow) {
                noOrdersRow.style.display = 'none';
            }
        }
    }

    function resetFilters() {
        dateFilter.value = '';
        timeFilter.value = '';
        statusFilter.value = '';

        // Show all rows
        document.querySelectorAll('.order-table tbody tr').forEach(row => {
            row.style.display = '';
        });

        // Hide "No results" message
        const noOrdersRow = document.querySelector('.no-orders');
        if (noOrdersRow) {
            noOrdersRow.style.display = 'none';
        }
    }

    // Apply initial filters if any are set
    if (dateFilter.value || timeFilter.value || statusFilter.value) {
        applyFilters();
    }
});