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
                    <p>1930</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="card">
                <div class="icon-container">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="card-content">
                    <h3>Orders</h3>
                    <p>480</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="card">
                <div class="icon-container">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="card-content">
                    <h3>Inventory</h3>
                    <p>120</p>
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
    </section>
    <!-- Charts -->
    <div class="charts-row">
        <div class="chart-container">
            <canvas id="chart1"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="chart2"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="chart3"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart 1
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#e3dddd' // Y-axis labels color
                    }
                },
                x: {
                    ticks: {
                        color: '#e3dddd' // X-axis labels color
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#e3dddd' // Legend labels color
                    }
                }
            }
        }
    });

    // Chart 2
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Revenue',
                data: [15, 10, 5, 2, 20, 30],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#e3dddd' // Y-axis labels color
                    }
                },
                x: {
                    ticks: {
                        color: '#e3dddd' // X-axis labels color
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#e3dddd' // Legend labels color
                    }
                }
            }
        }
    });

    // Chart 3
    var ctx3 = document.getElementById('chart3').getContext('2d');
    var chart3 = new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Customers', 'Shopkeepers', 'Tailors'],
            datasets: [{
                label: 'Colors',
                data: [10, 20, 30],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#e3dddd' // Legend labels color
                    }
                }
            }
        }
    });
</script>
</body>
</html>