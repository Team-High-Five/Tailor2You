document.addEventListener('DOMContentLoaded', function () {
    // Get filter elements
    const dateFilter = document.getElementById('filter-date');
    const timeFilter = document.getElementById('filter-time');
    const statusFilter = document.getElementById('filter-status');
    const resetButton = document.getElementById('reset-filters');

    // Get the no results message
    const noResultsMsg = document.querySelector('.no-results');

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
        const rows = document.querySelectorAll('.appointment-table tbody tr');

        rows.forEach(row => {
            let showRow = true;

            // Filter by date
            if (dateValue) {
                const timestamp = parseInt(row.getAttribute('data-timestamp'));
                const appointmentDate = new Date(timestamp * 1000); // Convert timestamp to date

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
                        const appDateStr = appointmentDate.toDateString();
                        if (appDateStr !== todayStr) {
                            showRow = false;
                        }
                        break;
                    case 'tomorrow':
                        const tomorrowStr = tomorrow.toDateString();
                        const appDateStr2 = appointmentDate.toDateString();
                        if (appDateStr2 !== tomorrowStr) {
                            showRow = false;
                        }
                        break;
                    case 'week':
                        if (appointmentDate < today || appointmentDate > nextWeek) {
                            showRow = false;
                        }
                        break;
                    case 'month':
                        if (appointmentDate < today || appointmentDate > nextMonth) {
                            showRow = false;
                        }
                        break;
                }
            }

            // Filter by time period
            if (showRow && timeValue) {
                const timePeriod = row.getAttribute('data-time-period');
                if (timeValue !== timePeriod) {
                    showRow = false;
                }
            }

            // Filter by status
            if (showRow && statusValue) {
                const status = row.getAttribute('data-status');
                if (statusValue !== '' && status !== statusValue) {
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
        dateFilter.value = '';
        timeFilter.value = '';
        statusFilter.value = '';

        // Show all rows
        document.querySelectorAll('.appointment-table tbody tr').forEach(row => {
            row.style.display = '';
        });

        // Hide "No results" message
        noResultsMsg.style.display = 'none';
    }

    // Apply initial filters if any are set
    if (dateFilter.value || timeFilter.value || statusFilter.value) {
        applyFilters();
    }
});