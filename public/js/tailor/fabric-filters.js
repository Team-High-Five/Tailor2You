document.addEventListener('DOMContentLoaded', function () {
    // Get filter elements
    const priceSort = document.getElementById('price-sort');
    const stockSort = document.getElementById('stock-sort');
    const colorSelect = document.getElementById('color-select');
    const resetButton = document.getElementById('reset-filters');
    const fabricRows = document.querySelectorAll('.product-table tbody tr');
    const noResultsMessage = document.querySelector('.no-results');

    // Apply filters when any filter changes
    function applyFilters() {
        const selectedPrice = priceSort.value;
        const selectedStock = stockSort.value;
        const selectedColor = colorSelect.value.toLowerCase();

        // First make all rows visible
        fabricRows.forEach(row => {
            row.style.display = '';
        });

        // Apply color filter if selected
        if (selectedColor) {
            fabricRows.forEach(row => {
                const colorDots = row.querySelectorAll('.color-dot');
                let hasColor = false;

                colorDots.forEach(dot => {
                    const dotStyle = window.getComputedStyle(dot);
                    const backgroundColor = dotStyle.backgroundColor;

                    // Check if this dot matches the selected color
                    // This is a simplified check - we're checking if the color name exists in the background style
                    if (dot.style.backgroundColor.includes(selectedColor)) {
                        hasColor = true;
                    }
                });

                // Hide row if it doesn't have the selected color
                if (!hasColor) {
                    row.style.display = 'none';
                }
            });
        }

        // Apply price sorting if selected
        if (selectedPrice) {
            const visibleRows = Array.from(fabricRows).filter(row => row.style.display !== 'none');

            // Sort the visible rows by price
            const sortedRows = visibleRows.sort((a, b) => {
                const priceA = parseFloat(a.children[3].textContent.replace('Rs.', '').replace(',', ''));
                const priceB = parseFloat(b.children[3].textContent.replace('Rs.', '').replace(',', ''));

                return selectedPrice === 'asc' ? priceA - priceB : priceB - priceA;
            });

            // Reorder the rows in the table
            const tbody = document.querySelector('.product-table tbody');
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        // Apply stock sorting if selected
        if (selectedStock) {
            const visibleRows = Array.from(fabricRows).filter(row => row.style.display !== 'none');

            // Sort the visible rows by stock
            const sortedRows = visibleRows.sort((a, b) => {
                const stockA = parseFloat(a.children[4].textContent);
                const stockB = parseFloat(b.children[4].textContent);

                return selectedStock === 'asc' ? stockA - stockB : stockB - stockA;
            });

            // Reorder the rows in the table
            const tbody = document.querySelector('.product-table tbody');
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        // Check if any rows are visible
        const visibleRowCount = Array.from(fabricRows).filter(row => row.style.display !== 'none').length;
        if (visibleRowCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    // Add event listeners to filter elements
    priceSort.addEventListener('change', applyFilters);
    stockSort.addEventListener('change', applyFilters);
    colorSelect.addEventListener('change', applyFilters);

    // Reset button functionality
    resetButton.addEventListener('click', function () {
        // Reset all filter values
        priceSort.value = '';
        stockSort.value = '';
        colorSelect.value = '';

        // Reset all rows to visible
        fabricRows.forEach(row => {
            row.style.display = '';
        });

        // Hide no results message
        noResultsMessage.style.display = 'none';

        // Reset table to original order
        const tbody = document.querySelector('.product-table tbody');
        const originalRows = Array.from(fabricRows).sort((a, b) => {
            // Sort by fabric ID to restore original order
            const idA = parseInt(a.children[2].textContent);
            const idB = parseInt(b.children[2].textContent);
            return idA - idB;
        });

        originalRows.forEach(row => tbody.appendChild(row));
    });

    // Animation for filter bar
    const filterBar = document.querySelector('.filter-bar');
    if (filterBar) {
        // Add animation class after a small delay
        setTimeout(() => {
            filterBar.classList.add('animate-in');
        }, 100);
    }

    // Add hover animations to filter selects
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('focus', function () {
            this.parentElement.classList.add('active');
        });

        select.addEventListener('blur', function () {
            this.parentElement.classList.remove('active');
        });
    });
});