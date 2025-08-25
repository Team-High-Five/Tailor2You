document.addEventListener('DOMContentLoaded', function() {
    // Initialize the star ratings display
    initStarRatings();
    
    // Setup horizontal scrolling
    initHorizontalScroller();
});

// Convert numeric ratings to star icons
function initStarRatings() {
    const ratingElements = document.querySelectorAll('.feedback-rating');
    
    ratingElements.forEach(element => {
        // Get the text content that contains the rating
        const ratingText = element.textContent;
        // Extract the numeric value using regex
        const ratingMatch = ratingText.match(/Rating: (\d+)/);
        
        if (ratingMatch && ratingMatch[1]) {
            const rating = parseInt(ratingMatch[1]);
            
            // Create the star container
            const starContainer = document.createElement('div');
            starContainer.className = 'star-rating';
            
            // Create 5 stars (filled based on rating)
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.className = i <= rating ? 'star filled' : 'star';
                star.innerHTML = '★';
                starContainer.appendChild(star);
            }
            
            // Replace text with stars
            element.innerHTML = '';
            element.appendChild(starContainer);
        }
    });
}

// Setup horizontal scrolling functionality
function initHorizontalScroller() {
    const scroller = document.querySelector('.feedback-scroller');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const scrollProgress = document.querySelector('.scroll-progress');
    
    if (!scroller || !prevBtn || !nextBtn) return;
    
    // Update scroll buttons state
    function updateScrollButtons() {
        // Check if we can scroll left
        prevBtn.disabled = scroller.scrollLeft <= 0;
        
        // Check if we can scroll right
        const canScrollRight = scroller.scrollWidth > scroller.clientWidth && 
                              scroller.scrollLeft < scroller.scrollWidth - scroller.clientWidth;
        nextBtn.disabled = !canScrollRight;
        
        // Update progress bar
        if (scroller.scrollWidth > scroller.clientWidth) {
            const scrollPercentage = (scroller.scrollLeft / (scroller.scrollWidth - scroller.clientWidth)) * 100;
            scrollProgress.style.width = `${scrollPercentage}%`;
        } else {
            scrollProgress.style.width = '100%';
        }
    }
    
    // Initialize buttons state
    updateScrollButtons();
    
    // Previous button click
    prevBtn.addEventListener('click', () => {
        // Scroll left by one card width (approximately)
        scroller.scrollBy({
            left: -370, // Card width + gap
            behavior: 'smooth'
        });
    });
    
    // Next button click
    nextBtn.addEventListener('click', () => {
        // Scroll right by one card width (approximately)
        scroller.scrollBy({
            left: 370, // Card width + gap
            behavior: 'smooth'
        });
    });
    
    // Update buttons when scrolling
    scroller.addEventListener('scroll', () => {
        updateScrollButtons();
    });
    
    // Update on window resize
    window.addEventListener('resize', () => {
        updateScrollButtons();
    });
    
    // Touch scrolling with momentum (for mobile)
    let isDown = false;
    let startX;
    let scrollLeft;
    
    scroller.addEventListener('mousedown', (e) => {
        isDown = true;
        scroller.style.cursor = 'grabbing';
        startX = e.pageX - scroller.offsetLeft;
        scrollLeft = scroller.scrollLeft;
    });
    
    scroller.addEventListener('mouseleave', () => {
        isDown = false;
        scroller.style.cursor = 'grab';
    });
    
    scroller.addEventListener('mouseup', () => {
        isDown = false;
        scroller.style.cursor = 'grab';
    });
    
    scroller.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scroller.offsetLeft;
        const walk = (x - startX) * 2; // Scroll speed multiplier
        scroller.scrollLeft = scrollLeft - walk;
    });
    
    // Set initial cursor style
    scroller.style.cursor = 'grab';
}