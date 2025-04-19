// Load feedback from server when document is ready
document.addEventListener('DOMContentLoaded', function() {
    loadFeedback();
});

function loadFeedback() {
    // Get the base URL from your PHP configuration
    const urlRoot = document.querySelector('meta[name="url-root"]')?.content || '';
    
    fetch(urlRoot + '/feedback/getPublished')
        .then(response => response.json())
        .then(data => {
            displayFeedback(data);
        })
        .catch(error => {
            console.error('Error fetching feedback:', error);
            document.getElementById('feedback-list').innerHTML = 
                '<div class="error-message">Unable to load feedback at this time.</div>';
        });
}

function displayFeedback(feedbackData) {
    const feedbackList = document.getElementById('feedback-list');
    
    if (feedbackData.length === 0) {
        feedbackList.innerHTML = '<div class="no-feedback">Be the first to leave feedback!</div>';
        return;
    }
    
    let html = '';
    
    feedbackData.forEach(item => {
        const date = new Date(item.created_at);
        const formattedDate = date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
        
        html += `<div class="feedback-card">
            <div class="feedback-header">
                <div class="feedback-name">${item.name}</div>
                <div class="feedback-date">${formattedDate}</div>
            </div>
            <div class="feedback-rating">
                ${generateStars(item.rating)}
            </div>
            <div class="feedback-text">${item.feedback_text}</div>
        </div>`;
    });
    
    feedbackList.innerHTML = html;
}

function generateStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            stars += '<span class="star filled">★</span>';
        } else {
            stars += '<span class="star">☆</span>';
        }
    }
    return stars;
}
