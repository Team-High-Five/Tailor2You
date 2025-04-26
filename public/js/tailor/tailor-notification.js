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
        fetch(`${URLROOT}/Notifications/markAllAsRead`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_type: 'tailor' })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    notificationBadge.classList.remove('visible');
                    const unreadItems = document.querySelectorAll('.notification-item.unread');
                    unreadItems.forEach(item => {
                        item.classList.remove('unread');
                    });
                }
            })
            .catch(error => {
                console.error('Error marking notifications as read:', error);
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
        fetch(`${URLROOT}/Notifications/getTailorNotifications`, {
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
                timeString = 'Today at ' + notificationDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            } else {
                timeString = notificationDate.toLocaleDateString([], {
                    month: 'short',
                    day: 'numeric'
                });
            }

            // Different notification types
            switch (notification.type) {
                case 'new_appointment':
                    item.innerHTML = `
                        <h4 class="notification-title">${notification.title}</h4>
                        <p class="notification-message">${notification.message}</p>
                        <div class="appointment-details">
                            <p><strong>Date:</strong> ${formatDate(notification.details.date)}</p>
                            <p><strong>Time:</strong> ${formatTime(notification.details.time)}</p>
                            <p><strong>Customer:</strong> ${notification.details.customer_name}</p>
                        </div>
                        <div class="notification-action">
                            <a href="${URLROOT}/Tailors/appointmentDetail/${notification.details.appointment_id}" class="view-btn">
                                View Details
                            </a>
                            <a href="javascript:void(0)" class="accept-btn" onclick="handleAppointmentAction(${notification.details.appointment_id}, 'accept')">Accept</a>
                            <a href="javascript:void(0)" class="reject-btn" onclick="handleAppointmentAction(${notification.details.appointment_id}, 'reject')">Reject</a>
                        </div>
                        <p class="notification-time">${timeString}</p>
                    `;
                    break;

                case 'order_placed':
                    item.innerHTML = `
                        <h4 class="notification-title">${notification.title}</h4>
                        <p class="notification-message">${notification.message}</p>
                        <div class="appointment-details">
                            <p><strong>Order ID:</strong> #${notification.details.order_id}</p>
                            <p><strong>Customer:</strong> ${notification.details.customer_name}</p>
                            <p><strong>Amount:</strong> Rs.${notification.details.amount}</p>
                        </div>
                        <div class="notification-action">
                            <a href="${URLROOT}/Tailors/orderDetails/${notification.details.order_id}" class="view-btn">
                                View Order
                            </a>
                        </div>
                        <p class="notification-time">${timeString}</p>
                    `;
                    break;

                default:
                    item.innerHTML = `
                        <h4 class="notification-title">${notification.title}</h4>
                        <p class="notification-message">${notification.message}</p>
                        <p class="notification-time">${timeString}</p>
                    `;
            }

            notificationList.appendChild(item);
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function formatTime(timeString) {
        const [hour, minute] = timeString.split(':');
        const hourNum = parseInt(hour);
        const ampm = hourNum >= 12 ? 'PM' : 'AM';
        const hour12 = hourNum % 12 || 12;
        return `${hour12}:${minute} ${ampm}`;
    }

    // Define handler for appointment actions
    window.handleAppointmentAction = function (appointmentId, action) {
        fetch(`${URLROOT}/Tailors/handleAppointment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                appointment_id: appointmentId,
                action: action
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Refresh notifications
                    fetchNotifications();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error handling appointment:', error);
                alert('An error occurred. Please try again.');
            });
    };

    // Initial fetch for the badge
    function updateNotificationBadge() {
        fetch(`${URLROOT}/Notifications/getTailorNotifications`, {
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