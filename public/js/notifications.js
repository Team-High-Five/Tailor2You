document.addEventListener('DOMContentLoaded', function () {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationBadge = document.getElementById('notificationBadge');
    const notificationList = document.getElementById('notificationList');
    const markAllReadBtn = document.getElementById('markAllReadBtn');

    let notifications = [];
    let isDropdownOpen = false;

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        if (!notificationBtn.contains(event.target) && !notificationDropdown.contains(event.target)) {
            closeNotificationDropdown();
        }
    });

    // Toggle dropdown on notification button click
    notificationBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        if (isDropdownOpen) {
            closeNotificationDropdown();
        } else {
            openNotificationDropdown();
            fetchNotifications();
        }
    });

    // Mark all as read
    markAllReadBtn.addEventListener('click', function () {
        // For future implementation
        notificationBadge.classList.remove('visible');
        const unreadItems = document.querySelectorAll('.notification-item.unread');
        unreadItems.forEach(item => {
            item.classList.remove('unread');
        });
    });

    function openNotificationDropdown() {
        notificationDropdown.classList.add('show');
        isDropdownOpen = true;
    }

    function closeNotificationDropdown() {
        notificationDropdown.classList.remove('show');
        isDropdownOpen = false;
    }

    function fetchNotifications() {
        // Use fetch API to get notifications from the server
        fetch(`${URLROOT}/Notifications/getNotifications`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    notifications = data.notifications;
                    renderNotifications();

                    // Update badge
                    if (data.count > 0) {
                        notificationBadge.textContent = data.count > 9 ? '9+' : data.count;
                        notificationBadge.classList.add('visible');
                    } else {
                        notificationBadge.classList.remove('visible');
                    }
                } else {
                    notificationList.innerHTML = `
                    <div class="notification-empty">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error loading notifications</p>
                    </div>
                `;
                }
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                notificationList.innerHTML = `
                <div class="notification-empty">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Error loading notifications</p>
                </div>
            `;
            });
    }

    function renderNotifications() {
        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="notification-empty">
                    <i class="fas fa-bell-slash"></i>
                    <p>No new notifications</p>
                </div>
            `;
            return;
        }

        notificationList.innerHTML = '';

        notifications.forEach(notification => {
            const item = document.createElement('div');
            item.classList.add('notification-item');
            if (!notification.is_read) {
                item.classList.add('unread');
            }

            // Format the timestamp
            const notificationDate = new Date(notification.date);
            const now = new Date();
            let timeString;

            if (notificationDate.toDateString() === now.toDateString()) {
                // Today, show time
                timeString = notificationDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                timeString = 'Today at ' + timeString;
            } else {
                // Not today, show date
                timeString = notificationDate.toLocaleDateString([], {
                    month: 'short',
                    day: 'numeric'
                });
            }

            if (notification.type === 'reschedule_request') {
                let formattedDate = new Date(notification.details.proposed_date);
                formattedDate = formattedDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                item.innerHTML = `
                    <h4 class="notification-title">${notification.title}</h4>
                    <p class="notification-message">${notification.message}</p>
                    <div class="reschedule-details">
                        <p><strong>New Date:</strong> ${formattedDate}</p>
                        <p><strong>New Time:</strong> ${formatTime(notification.details.proposed_time)}</p>
                        <p><strong>Reason:</strong> ${notification.details.reason}</p>
                    </div>
                    <div class="notification-actions">
                        <a href="${URLROOT}/Customers/handleReschedule/${notification.appointment_id}/accept" class="accept-action">
                            Accept
                        </a>
                        <a href="${URLROOT}/Customers/handleReschedule/${notification.appointment_id}/reject" class="reject-action">
                            Reject
                        </a>
                    </div>
                    <p class="notification-time">${timeString}</p>
                `;
            } else {
                item.innerHTML = `
                    <h4 class="notification-title">${notification.title}</h4>
                    <p class="notification-message">${notification.message}</p>
                    <p class="notification-time">${timeString}</p>
                `;
            }

            notificationList.appendChild(item);
        });
    }

    function formatTime(timeString) {
        const [hour, minute] = timeString.split(':');
        const hourNum = parseInt(hour);
        const ampm = hourNum >= 12 ? 'PM' : 'AM';
        const hour12 = hourNum % 12 || 12;
        return `${hour12}:${minute} ${ampm}`;
    }

    // Initial fetch for the badge
    function updateNotificationBadge() {
        fetch(`${URLROOT}/Notifications/getNotifications`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.count > 0) {
                    notificationBadge.textContent = data.count > 9 ? '9+' : data.count;
                    notificationBadge.classList.add('visible');
                }
            })
            .catch(error => {
                console.error('Error updating badge:', error);
            });
    }

    // Check for new notifications every minute
    updateNotificationBadge();
    setInterval(updateNotificationBadge, 60000);
});