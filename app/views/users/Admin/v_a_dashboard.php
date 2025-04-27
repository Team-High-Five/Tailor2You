<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
<!-- Admin Dashboard -->
<!-- Dashboard Content -->
<div class="main-content">
    
    <!-- Statistics Cards -->
    <section class="Cards">
        <div class="card-container">
            <!-- Card 1: Users -->
            <div class="card">
                <div class="icon-container">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-content">
                    <h3><a href="<?php echo URLROOT; ?>/admin/viewAllUsers" class="no-underline">Users</a></h3>
                    <p><?php echo $data['userCount']; ?></p>
                </div>
            </div>
            <!-- Card 2: Orders -->
            <div class="card">
                <div class="icon-container">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="card-content">
                    <h3><a href="<?php echo URLROOT; ?>/admin/displayAllOrders" class="no-underline">Orders</a></h3>
                    <p><?php echo $data['orderCount']; ?></p>
                </div>
            </div>
            <!-- Card 3: Inventory -->
            <div class="card">
                <div class="icon-container">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="card-content">
                    <h3><a href="<?php echo URLROOT; ?>/admin/inventoryManagement" class="no-underline">Fabrics</a></h3>
                    <p><?php echo $data['inventoryCount']; ?></p>
                </div>
            </div>
            <!-- Card 4: Reviews -->
            <div class="card">
                <div class="icon-container">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="card-content">
                    <h3><a href="<?php echo URLROOT; ?>/admin/reviewSection" class="no-underline">Reviews</a></h3>
                    <p><?php echo $data['reviewCount']; ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Charts -->
    <div class="charts-row">
        <div class="chart-container">
            <div class="chart-title">Monthly Sales</div>
            <canvas id="chart1"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">Revenue Trends</div>
            <canvas id="chart2"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">User Distribution</div>
            <canvas id="chart3"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function destroyChartIfExists(chartInstance) {
        if (chartInstance) {
            chartInstance.destroy();
        }
    }
    
// Before chart initializations
let chart1Instance, chart2Instance, chart3Instance;

    // Common chart options for better visualization
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: true, // Change to true
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff',
                    font: {
                        size: 14
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleFont: {
                    size: 16
                },
                bodyFont: {
                    size: 14
                },
                padding: 10
            }
        }
    };
    // Chart 1 - Sales Bar Chart
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                }
            }
        }
    });

    // Chart 2 - Revenue Line Chart
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Revenue',
                data: [15, 10, 5, 2, 20, 30],
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                }
            }
        }
    });

    // Chart 3 - User Types Pie Chart
    try {
        // Use default data if userCounts is not available
        let labels = ['Customer', 'Tailor', 'Shopkeeper'];
        let dataValues = [50, 30, 20];

        // Try to get data from PHP if available
        try {
            const userCounts = <?php echo isset($data['userCounts']) ? json_encode($data['userCounts']) : '[]'; ?>;
            if (userCounts && userCounts.length > 0) {
                labels = userCounts.map(user => user.user_type);
                dataValues = userCounts.map(user => user.count);
            }
        } catch (e) {
            console.log('Using default user counts data');
        }

        var ctx3 = document.getElementById('chart3').getContext('2d');
        var chart3 = new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'User Types',
                    data: dataValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                cutout: '60%',
                radius: '90%'
            }
        });
    } catch (e) {
        console.error('Error rendering chart 3:', e);
    }
</script>
</body>

</html>