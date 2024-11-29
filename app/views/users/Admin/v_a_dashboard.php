<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

    <!-- Admin Dashboard -->
     <!-- Dashboard Content -->
    <div class="main-content">
    <div class="search-bar">
            <input type="text" placeholder="To quickly find specific users">
            <button><i class="fas fa-search"></i></button>
        </div>
      <!-- Statistics Cards -->
       <section class="Cards">
      <div class="card-container">
        <!-- Card 1 -->
        <div class="card">
            <div class="icon-container">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3>Users</h3>
                <p>150</p>
            </div>
        </div>
    
        <!-- Card 2 -->
        <div class="card">
            <div class="icon-container">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="card-content">
                <h3>Orders</h3>
                <p>80</p>
            </div>
        </div>
    
        <!-- Card 3 -->
        <div class="card">
            <div class="icon-container">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="card-content">
                <h3>Inventory</h3>
                <p>230</p>
            </div>
        </div>
    
        <!-- Card 4 -->
        <div class="card">
            <div class="icon-container">
                <i class="fas fa-comments"></i>
            </div>
            <div class="card-content">
                <h3>Reviews</h3>
                <p>45</p>
            </div>
        </div>
    </div>
      <!-- Pie Chart Placeholder -->
      <div class="chart-container">
        <canvas id="myPieChart"></canvas>
    </div>
  </div>
</section>

<script>
// Fetch Data (dummy data implementation)
function fetchData() {
    // Example of dynamic content that you can fetch from the backend
    const userCount = 150; // Example value from the backend
    const orderCount = 80; // Example value from the backend
    const inventoryCount = 230; // Example value from the backend
    const reviewsCount = 45; // Example value from the backend

    // Assign values to the HTML elements
    document.getElementById('user-count').innerText = userCount;
    document.getElementById('order-count').innerText = orderCount;
    document.getElementById('inventory-count').innerText = inventoryCount;
    document.getElementById('reviews-count').innerText = reviewsCount;
}

// Call fetchData() on page load to populate dashboard stats
window.onload = function() {
    renderPieChart();
};
function renderPieChart() {
    const ctx = document.getElementById('myPieChart').getContext('2d');
    
    const data = {
        labels: ['Users', 'Orders', 'Inventory', 'Reviews'],
        datasets: [{
            data: [150, 80, 230, 45], // Replace with dynamic data
            backgroundColor: ['#F9E79F', '#FFD700', '#B8860B', '#D4AF37'],
            hoverBackgroundColor: ['#F9E79F', '##FFD700', '#B8860B', '#D4AF37']
        }]
    };

    new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
}

</script>
</body>
</html>