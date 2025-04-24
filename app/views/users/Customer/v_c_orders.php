<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/Customer_orders_styles.css'>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>

<div class="container">
    <div class="order-container">
        <h2 class="section-title">My Orders</h2>
        
        <?php foreach ($data['orders'] as $order) : ?>
            <div class="order">
            <div class="order-image">
                <div class="image-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/designs/shirt1.jpg" alt="Black Shirt">
                    <div class="order-image-text">
                        <h4><?php echo $order->name ?></h4>
                        <p class="price"><?php echo $order->total_price ?></p>
                    </div>
                </div>
            </div>
            <div class="right-text">
                <div class="order-details">
                    <div class="order-header">
                        <h3>Order #<?php echo $order->order_id ?></h3>
                        <span class="order-date">
                            <i class="far fa-calendar-alt"></i>
                            Placed on <?php echo $order->order_date ?>
                        </span>
                    </div>
                    <div class="tailor-info">
                        <img src="<?php echo URLROOT; ?>/public/img/designs/tailordp.jpeg" alt="Tailor">
                        <div class="tailor-details">
                            <p class="tailor-label">Tailor</p>
                            <p class="tailor-name"><?php echo $order->first_name . " ". $order->last_name ?></p>
                        </div>
                    </div>
                </div>
                <div class="order-status">
                    <div class="status-wrapper">
                        <span class="status-dot pending"></span>
                        <button class="status pending"><?php echo $order->order_status ?></button>
                    </div>
                    <button class="view-order-btn" onclick="ordersViews(<?php echo $order->order_id ?>)">
                        <i class="fas fa-eye"></i>
                        View Details
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    function ordersViews(orderId) {
        window.location.href = "<?php echo URLROOT; ?>/Customers/ordersViews/" + orderId;
    }
</script>

<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>