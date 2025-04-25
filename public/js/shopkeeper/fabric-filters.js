document.addEventListener('DOMContentLoaded', function () {
    // Get filter elements
    const priceSort = document.getElementById('price-sort');
    const stockSort = document.getElementById('stock-sort');
    const colorSelect = document.getElementById('color-select');
    const applyButton = document.getElementById('apply-filters');
    const resetButton = document.getElementById('reset-filters');

    // Get the no results message
    const noResultsMsg = document.querySelector('.no-results');

    // Apply filters when button is clicked
    applyButton.addEventListener('click', applyFilters);

    // Reset filters button
    resetButton.addEventListener('click', resetFilters);

    // Main filter and sort function
    function applyFilters() {
        const priceSortValue = priceSort.value;
        const stockSortValue = stockSort.value;
        const selectedColor = colorSelect.value.toLowerCase();
        
        // Get all table rows
        const tbody = document.querySelector('.product-table tbody');
        const rows = Array.from(document.querySelectorAll('.product-table tbody tr'));
        
        // First, filter by color if selected
        let filteredRows = rows;
        if (selectedColor) {
            filteredRows = rows.filter(row => {
                const colorDots = row.querySelectorAll('td:nth-child(6) .color-dot');
                const fabricColors = Array.from(colorDots).map(dot => {
                    // Extract color from the background-color style
                    const bgColor = dot.style.backgroundColor;
                    return extractColorName(bgColor);
                });
                
                // Check if selected color exists in the fabric colors
                return fabricColors.some(fabricColor => 
                    fabricColor.includes(selectedColor)
                );
            });
        }
        
        // Then, sort by price if selected
        if (priceSortValue) {
            filteredRows.sort((a, b) => {
                const priceA = extractPrice(a.querySelector('td:nth-child(4)').textContent);
                const priceB = extractPrice(b.querySelector('td:nth-child(4)').textContent);
                
                return priceSortValue === 'asc' ? priceA - priceB : priceB - priceA;
            });
        }
        
        // Then, sort by stock if selected (and if price sort isn't applied)
        if (stockSortValue && !priceSortValue) {
            filteredRows.sort((a, b) => {
                const stockA = parseFloat(a.querySelector('td:nth-child(5)').textContent.trim());
                const stockB = parseFloat(b.querySelector('td:nth-child(5)').textContent.trim());
                
                return stockSortValue === 'asc' ? stockA - stockB : stockB - stockA;
            });
        }
        
        // Remove all current rows
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        
        // Add filtered and sorted rows back to the table
        filteredRows.forEach(row => {
            tbody.appendChild(row);
        });
        
        // Show "No results" message if no rows are visible
        if (filteredRows.length === 0 && rows.length > 0) {
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }

    function resetFilters() {
        priceSort.value = '';
        stockSort.value = '';
        colorSelect.value = '';

        // Reload the page to reset the table to its original state
        window.location.reload();
    }

    // Helper function to extract price number from "Rs.1,234.56" format
    function extractPrice(priceText) {
        return parseFloat(priceText.replace('Rs.', '').replace(/,/g, '').trim());
    }

    // Helper function to extract simple color name from CSS color value
    function extractColorName(cssColor) {
        // Handle rgb format
        if (cssColor.startsWith('rgb')) {
            const rgb = cssColor.match(/\d+/g).map(Number);
            // Very simple color detection - could be improved
            if (rgb[0] > 200 && rgb[1] < 100 && rgb[2] < 100) return 'red';
            if (rgb[0] < 100 && rgb[1] > 200 && rgb[2] < 100) return 'green';
            if (rgb[0] < 100 && rgb[1] < 100 && rgb[2] > 200) return 'blue';
            if (rgb[0] > 200 && rgb[1] > 200 && rgb[2] < 100) return 'yellow';
            if (rgb[0] > 200 && rgb[1] < 100 && rgb[2] > 200) return 'purple';
            if (rgb[0] > 100 && rgb[1] > 50 && rgb[2] < 50) return 'orange';
            if (rgb[0] < 100 && rgb[1] < 100 && rgb[2] < 100) return 'black';
            if (rgb[0] > 200 && rgb[1] > 200 && rgb[2] > 200) return 'white';
            if (rgb[0] === rgb[1] && rgb[1] === rgb[2] && rgb[0] > 100 && rgb[0] < 200) return 'gray';
            if (rgb[0] > 100 && rgb[1] < 100 && rgb[2] < 100) return 'brown';
        }
        // Return the color as is for named colors
        return cssColor.toLowerCase();
    }
});
