<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<link rel='stylesheet' type='text/css' media='screen'
href='<?php echo URLROOT; ?>/public/css/customer/Customer_orders_styles.css'>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>

<div class="container">
    <div class="order-container">
        <!-- Order 1 -->
        <div class="order">
            <div class="order-image">
                <img src="<?php echo URLROOT; ?>/public/img/designs/shirt1.jpg" alt="Dotted Black Dress">
                <div class="order-image-text">
                    <p>Black Shirt</p>
                    <p>Rs.2500 <span style="color: #888;"></span></p>
                </div>
            </div>
            <div class="right-text">
                <div class="order-details">
                    <h3>Order #1067907</h3>
                    <p>Placed on 02/09/2024</p>
                    <div class="tailor-info">
                        <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor">
                        <p><strong>Tailor</strong> - Pieris M.P Tailors</p>
                    </div>
                </div>
                <div class="order-status">
                    <div class="status pending">Pending</div>
                    <button class="view-order-btn">View Order</button>
                    <button class="view-order-btn">Go to payments</button>
                </div>
            </div>
        </div>

        <div class="order">
            <div class="order-image">
                <img src="<?php echo URLROOT; ?>/public/img/designs/shirt2.jpg" alt="Dotted Black Dress">
                <div class="order-image-text">
                    <p>Rockstar shirt</p>
                    <p>Rs.2500 <span style="color: #888;"></span></p>
                </div>
            </div>
            <div class="right-text">
                <div class="order-details">
                    <h3>Order #1064509</h3>
                    <p>Placed on 30/09/2024</p>
                    <div class="tailor-info">
                        <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor">
                        <p><strong>Tailor</strong> - Bandara M.P</p>
                    </div>

                    <div class="progress-container">
                        <div class="progress-bar" style="width: 50%;"></div>
                        <p class="progress-status">50% completed</p>
                    </div>
                </div>
                <div class="order-status">
                    <div class="status accepted">Accepted</div>
                    <button class="view-order-btn">View Order</button>
                    <button class="view-order-btn">Go to payments</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>