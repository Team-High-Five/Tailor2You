document.addEventListener('DOMContentLoaded', function() {
    // Get filter elements
    const dateFilter = document.getElementById('filter-date');
    const genderFilter = document.getElementById('filter-gender');
    const statusFilter = document.getElementById('filter-status');
    const resetButton = document.getElementById('reset-filters');
    const productGrid = document.querySelector('.product-grid');
    
    // Create a "No results" message element
    const noResultsMsg = document.createElement('div');
    noResultsMsg.className = 'no-results-message';
    noResultsMsg.textContent = 'No designs match your filter criteria';
    productGrid.appendChild(noResultsMsg);

    // Apply filters when any select changes
    dateFilter.addEventListener('change', applyFilters);
    genderFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    
    // Reset filters
    resetButton.addEventListener('click', resetFilters);

    // Main filter function
    function applyFilters() {
        const dateValue = dateFilter.value;
        const genderValue = genderFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        
        let visibleCount = 0;
        
        // Get all product cards
        const cards = document.querySelectorAll('.product-card');
        
        cards.forEach(card => {
            let showCard = true;
            
            // Filter by date if selected
            if (dateValue && card.dataset.createdAt) {
                const cardDate = new Date(card.dataset.createdAt);
                const today = new Date();
                const daysDiff = Math.floor((today - cardDate) / (1000 * 60 * 60 * 24));
                
                if (daysDiff > parseInt(dateValue)) {
                    showCard = false;
                }
            }
            
            // Filter by gender if selected
            if (genderValue && card.dataset.gender) {
                if (genderValue !== 'all' && card.dataset.gender.toLowerCase() !== genderValue) {
                    showCard = false;
                }
            }
            
            // Filter by status if selected
            if (statusValue && card.dataset.status) {
                if (statusValue !== 'all' && card.dataset.status.toLowerCase() !== statusValue) {
                    showCard = false;
                }
            }
            
            // Show or hide the card
            if (showCard) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });
        
        // Show "No results" message if no cards are visible
        if (visibleCount === 0 && cards.length > 0) {
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }
    
    function resetFilters() {
        dateFilter.value = '';
        genderFilter.value = '';
        statusFilter.value = '';
        
        // Show all cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.remove('hidden');
        });
        
        // Hide "No results" message
        noResultsMsg.style.display = 'none';
    }
});