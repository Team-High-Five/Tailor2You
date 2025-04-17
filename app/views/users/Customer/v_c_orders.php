<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/Customer_orders_styles.css'>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>

<div class="container">
    <div class="order-container">
        <h2 class="section-title">My Orders</h2>
        
        <!-- Order 1 -->
        <div class="order">
            <div class="order-image">
                <div class="image-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/shirt1.jpg" alt="Black Shirt">
                    <div class="order-image-text">
                        <h4>Black Shirt</h4>
                        <p class="price">Rs.2500</p>
                    </div>
                </div>
            </div>
            <div class="right-text">
                <div class="order-details">
                    <div class="order-header">
                        <h3>Order #1067907</h3>
                        <span class="order-date">
                            <i class="far fa-calendar-alt"></i>
                            Placed on 02/09/2024
                        </span>
                    </div>
                    <div class="tailor-info">
                        <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor">
                        <div class="tailor-details">
                            <p class="tailor-label">Tailor</p>
                            <p class="tailor-name">Pieris M.P Tailors</p>
                        </div>
                    </div>
                </div>
                <div class="order-status">
                    <div class="status-wrapper">
                        <span class="status-dot pending"></span>
                        <button class="status pending">Pending</button>
                    </div>
                    <button class="view-order-btn">
                        <i class="fas fa-eye"></i>
                        View Details
                    </button>
                </div>
            </div>
        </div>

        <!-- Order 2 -->
        <div class="order">
            <div class="order-image">
                <div class="image-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/shirt2.jpg" alt="Rockstar shirt">
                    <div class="order-image-text">
                        <h4>Rockstar shirt</h4>
                        <p class="price">Rs.2500</p>
                    </div>
                </div>
            </div>
            <div class="right-text">
                <div class="order-details">
                    <div class="order-header">
                        <h3>Order #1064509</h3>
                        <span class="order-date">
                            <i class="far fa-calendar-alt"></i>
                            Placed on 30/09/2024
                        </span>
                    </div>
                    <div class="tailor-info">
                        <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor">
                        <div class="tailor-details">
                            <p class="tailor-label">Tailor</p>
                            <p class="tailor-name">Bandara M.P</p>
                        </div>
                    </div>
                    <div class="progress-wrapper">
                        <div class="progress-container">
                            <div class="progress-bar" style="width: 50%;"></div>
                        </div>
                        <p class="progress-status">50% completed</p>
                    </div>
                </div>
                <div class="order-status">
                    <div class="status-wrapper">
                        <span class="status-dot accepted"></span>
                        <button class="status accepted">Accepted</button>
                    </div>
                    <button class="view-order-btn" class="fas fa-eye" onclick="ordersViews()">View Details</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>