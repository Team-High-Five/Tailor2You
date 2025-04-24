<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/order_details_styles.css'>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>

<div class="container">
    <div class="order-details-container">
        <div class="back-button">
            <a href="<?php echo URLROOT; ?>/customers/orders">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
        <?php print_r($data['order']);?>
        <?php print_r($data['measurements']);?>

        <div class="order-header">
            <div class="order-title">
                <h2>Order Details #<?php echo $data['order']->order_id; ?></h2>
                <span class="order-date">Placed on <?php echo date('d M Y', strtotime($data['order']->created_at)); ?></span>
            </div>
            <div class="order-status <?php echo strtolower($data['order']->status); ?>">
                <?php echo ucfirst($data['order']->status); ?>
            </div>
        </div>

        <div class="order-content">
            <!-- Design Details Section -->
            <div class="section design-details">
                <h3>Design Details</h3>
                <div class="design-info">
                    <div class="design-image">
                        <img src="<?php echo URLROOT; ?>/public/img/designs/<?php echo $data['order']->design_image; ?>" 
                             alt="<?php echo $data['order']->name; ?>">
                    </div>
                    <div class="design-text">
                        <h4><?php echo $data['order']->name; ?></h4>
                        <p class="design-description"><?php echo $data['order']->design_description; ?></p>
                        <p class="design-price">Rs. <?php echo number_format($data['order']->base_price, 2); ?></p>
                    </div>
                </div>
            </div>

            <!-- Measurements Section -->
            <div class="section measurements">
                <h3>Measurements</h3>
                <div class="measurements-grid">
                    <?php foreach ($data['measurements'] as $key => $value): ?>
                        <div class="measurement-item">
                            <span class="label"><?php echo ucwords(str_replace('_', ' ', $key)); ?></span>
                            <span class="value"><?php echo $value; ?> inches</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tailor Details -->
            <div class="section tailor-details">
                <h3>Tailor Information</h3>
                <div class="tailor-card">
                    <img src="<?php echo $data['order']->tailor_image ? 
                        'data:image/jpeg;base64,'.base64_encode($data['order']->tailor_image) : 
                        URLROOT.'/public/img/default-profile.jpg'; ?>" 
                         alt="Tailor Profile">
                    <div class="tailor-info">
                        <h4><?php echo $data['order']->tailor_name; ?></h4>
                        <p class="rating">⭐ <?php echo number_format($data['order']->tailor_rating, 1); ?></p>
                    </div>
                </div>
            </div>

            <!-- Payment Receipt -->
            <div class="section payment-details">
                <h3>Payment Details</h3>
                <div class="receipt">
                    <div class="receipt-header">
                        <h4>Receipt</h4>
                        <span class="receipt-date">
                            <?php echo date('d M Y', strtotime($data['order']->payment_date)); ?>
                        </span>
                    </div>
                    <div class="receipt-items">
                        <div class="receipt-item">
                            <span>Design Price</span>
                            <span>Rs. <?php echo number_format($data['order']->design_price, 2); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Tailoring Charges</span>
                            <span>Rs. <?php echo number_format($data['order']->tailoring_charge, 2); ?></span>
                        </div>
                        <div class="receipt-total">
                            <span>Total Amount</span>
                            <span>Rs. <?php echo number_format($data['order']->total_amount, 2); ?></span>
                        </div>
                    </div>
                    <div class="payment-status <?php echo $data['order']->payment_status; ?>">
                        <?php echo ucfirst($data['order']->payment_status); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>