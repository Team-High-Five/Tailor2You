<?php if ($_SESSION['user_type'] == 'shopkeeper') {
  require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php';
  require_once APPROOT . '/views/users/Shopkeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] == 'tailor') {
  require_once APPROOT . '/views/users/Tailor/inc/Header.php';
  require_once APPROOT . '/views/users/Tailor/inc/sideBar.php';
  require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} ?>
<div class="main-content">
  <div class="stats">
    <div class="card orders-card">
      <div class="card-icon"><i class="ri-shopping-cart-line"></i></div>
      <h3>Total Orders</h3>
      <div class="card-value"><?php echo number_format($data['stats']['total_orders']); ?></div>
      <div class="card-trend <?php echo $data['stats']['order_percent_change'] >= 0 ? 'trend-up' : 'trend-down'; ?>">
        <i class="ri-arrow-<?php echo $data['stats']['order_percent_change'] >= 0 ? 'up' : 'down'; ?>-line trend-icon"></i>
        <?php echo abs($data['stats']['order_percent_change']); ?>% <?php echo $data['stats']['order_percent_change'] >= 0 ? 'Up' : 'Down'; ?> from past week
      </div>
    </div>
    <div class="card sales-card">
      <div class="card-icon"><i class="ri-money-dollar-circle-line"></i></div>
      <h3>Total Sales</h3>
      <div class="card-value">Rs.<?php echo number_format($data['stats']['total_sales']); ?></div>
      <div class="card-trend <?php echo $data['stats']['sales_percent_change'] >= 0 ? 'trend-up' : 'trend-down'; ?>">
        <i class="ri-arrow-<?php echo $data['stats']['sales_percent_change'] >= 0 ? 'up' : 'down'; ?>-line trend-icon"></i>
        <?php echo abs($data['stats']['sales_percent_change']); ?>% <?php echo $data['stats']['sales_percent_change'] >= 0 ? 'Up' : 'Down'; ?> from yesterday
      </div>
    </div>
    <div class="card appointments-card">
      <div class="card-icon"><i class="ri-calendar-check-line"></i></div>
      <h3>Total Appointments</h3>
      <div class="card-value"><?php echo number_format($data['stats']['total_appointments']); ?></div>
      <div class="card-trend <?php echo $data['stats']['appointment_percent_change'] >= 0 ? 'trend-up' : 'trend-down'; ?>">
        <i class="ri-arrow-<?php echo $data['stats']['appointment_percent_change'] >= 0 ? 'up' : 'down'; ?>-line trend-icon"></i>
        <?php echo abs($data['stats']['appointment_percent_change']); ?>% <?php echo $data['stats']['appointment_percent_change'] >= 0 ? 'Up' : 'Down'; ?> from yesterday
      </div>
    </div>
  </div>

  <div class="charts">
    <div class="chart-container">
      <h3 class="chart-title">Monthly Sales (<?php echo date('Y'); ?>)</h3>
      <canvas id="barChart"></canvas>
    </div>
    <div class="chart-container">
      <h3 class="chart-title">Order Status Distribution</h3>
      <canvas id="pieChart"></canvas>
    </div>
  </div>

  <div class="recent-section">
    <div class="recent-orders">
      <h3>Recent Orders</h3>
      <div class="view-all-link">
        <a href="<?php echo URLROOT; ?>/Tailors/displayOrders">View All <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="order-table-container">
        <table class="order-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="recentOrdersList">
            <tr>
              <td colspan="5" class="loading-data">Loading recent orders...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="upcoming-appointments">
      <h3>Upcoming Appointments</h3>
      <div class="view-all-link">
        <a href="<?php echo URLROOT; ?>/Tailors/displayAppointments">View All <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="appointment-list" id="upcomingAppointmentsList">
        <p class="loading-data">Loading upcoming appointments...</p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 3D tilt effect on stat cards
    document.querySelectorAll('.card').forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const angleX = (y - centerY) / 10;
        const angleY = (centerX - x) / 10;

        card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) translateZ(10px)`;
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
      });
    });

    // Activate chart animations
    const chartContainers = document.querySelectorAll('.chart-container');
    const options = {
      threshold: 0.3
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('chart-animate');
          observer.unobserve(entry.target);
        }
      });
    }, options);

    chartContainers.forEach(container => {
      observer.observe(container);
    });

    // Uncomment these when your API endpoints are ready
    fetchRecentOrders();
    fetchUpcomingAppointments();
  });
  // Bar Chart
  const barCtx = document.getElementById('barChart').getContext('2d');
  const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($data['chart_data']['months']); ?>,
      datasets: [{
        label: 'Sales (Rs)',
        data: <?php echo json_encode($data['chart_data']['sales_values']); ?>,
        backgroundColor: 'rgba(106, 90, 205, 0.6)',
        borderColor: 'rgba(106, 90, 205, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rs ' + value.toLocaleString();
            }
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Rs ' + context.parsed.y.toLocaleString();
            }
          }
        }
      }
    }
  });

  // Pie Chart
  const pieCtx = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($data['chart_data']['status_labels']); ?>,
      datasets: [{
        label: 'Orders',
        data: <?php echo json_encode($data['chart_data']['status_counts']); ?>,
        backgroundColor: <?php echo json_encode($data['chart_data']['pie_colors']); ?>,
        borderColor: <?php echo json_encode($data['chart_data']['pie_border_colors']); ?>,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'right',
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.label + ': ' + context.parsed + ' orders';
            }
          }
        }
      }
    }
  });

  // Fetch recent orders for the dashboard
  function fetchRecentOrders() {
    fetch('<?php echo URLROOT; ?>/api/getRecentOrders')
      .then(response => response.json())
      .then(data => {
        const ordersList = document.getElementById('recentOrdersList');

        if (data.length === 0) {
          ordersList.innerHTML = '<tr><td colspan="5" class="no-data">No recent orders found</td></tr>';
          return;
        }

        let html = '';
        data.forEach(order => {
          const statusClass = getStatusClass(order.status);
          html += `
            <tr>
              <td>#${order.order_id}</td>
              <td>${order.customer_name}</td>
              <td>${order.order_date}</td>
              <td>Rs ${parseFloat(order.total_amount).toLocaleString()}</td>
              <td><span class="status-badge ${statusClass}">${formatStatus(order.status)}</span></td>
            </tr>
          `;
        });

        ordersList.innerHTML = html;
      })
      .catch(error => {
        console.error('Error fetching recent orders:', error);
        document.getElementById('recentOrdersList').innerHTML =
          '<tr><td colspan="5" class="error-data">Failed to load orders. Please try again later.</td></tr>';
      });
  }

  // Fetch upcoming appointments
  function fetchUpcomingAppointments() {
    fetch('<?php echo URLROOT; ?>/api/getUpcomingAppointments')
      .then(response => response.json())
      .then(data => {
        const appointmentsList = document.getElementById('upcomingAppointmentsList');

        if (data.length === 0) {
          appointmentsList.innerHTML = '<p class="no-data">No upcoming appointments</p>';
          return;
        }

        let html = '';
        data.forEach(appointment => {
          const statusClass = getStatusClass(appointment.status);
          html += `
            <div class="appointment-card">
              <div class="appointment-date">
                <div class="date">${formatAppointmentDate(appointment.appointment_date)}</div>
                <div class="time">${formatAppointmentTime(appointment.appointment_time)}</div>
              </div>
              <div class="appointment-details">
                <div class="customer-name">${appointment.customer_name}</div>
                <div class="status-badge ${statusClass}">${formatStatus(appointment.status)}</div>
              </div>
              <a href="<?php echo URLROOT; ?>/Tailors/displayAppointmentDetails/${appointment.appointment_id}" class="view-details">
                <i class="ri-eye-line"></i>
              </a>
            </div>
          `;
        });

        appointmentsList.innerHTML = html;
      })
      .catch(error => {
        console.error('Error fetching upcoming appointments:', error);
        document.getElementById('upcomingAppointmentsList').innerHTML =
          '<p class="error-data">Failed to load appointments. Please try again later.</p>';
      });
  }

  // Helper functions for formatting
  function getStatusClass(status) {
    const statusMap = {
      'order_placed': 'status-pending',
      'fabric_cutting': 'status-cutting',
      'stitching': 'status-stitching',
      'ready_for_delivery': 'status-ready',
      'delivered': 'status-completed',
      'cancelled': 'status-rejected',
      'pending': 'status-pending',
      'accepted': 'status-accepted',
      'confirmed': 'status-confirmed',
      'completed': 'status-completed',
      'rejected': 'status-rejected',
      'reschedule_pending': 'status-reschedule_pending'
    };

    return statusMap[status] || 'status-pending';
  }

  function formatStatus(status) {
    return status.split('_').map(word =>
      word.charAt(0).toUpperCase() + word.slice(1)
    ).join(' ');
  }

  function formatAppointmentDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric'
    });
  }

  function formatAppointmentTime(timeString) {
    return timeString.substring(0, 5);
  }

  // Optional: Add some interactive animations
  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
  });

  // Load the dynamic content
  // Uncomment these when you implement the API endpoints
  // fetchRecentOrders();
  // fetchUpcomingAppointments();
</script>


<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>