
  document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = document.querySelectorAll('.msg-flash, .alert');
    
    flashMessages.forEach(message => {
      // Auto-dismiss after 5 seconds
      setTimeout(() => {
        message.style.opacity = '0';
        message.style.transform = 'translateY(-10px)';
        message.style.transition = 'all 0.5s ease';
        
        // Remove from DOM after transition
        setTimeout(() => {
          message.remove();
        }, 500);
      }, 5000);
    });
  });
