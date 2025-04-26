<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/order_details_styles.css'>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>

<div class="container">
    <div class="order-details-container">
        <div class="back-button">
            <a href="<?php echo URLROOT; ?>/customers/displayOrders">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
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
                        <img src="<?php echo URLROOT; ?>/public/img/uploads/designs/<?php echo $data['order']->main_image; ?>" 
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
                    <?php foreach ($data['measurements'] as $measurement): ?>
                        <div class="measurement-item">
                            <span class="label"><?php echo 'Measurement Name : ' . $measurement->display_name; ?></span>
                            <span class="value"><?php echo $measurement->value_inch; ?> inches</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- custom measurements -->
            <div class="section measurements">
                <h3>Custom Measurements</h3>
                <div class="measurements-grid">
                    <?php foreach ($data['customermeasurments'] as $measurement): ?>
                        <div class="measurement-item">
                            <span class="label"><?php echo 'Measurement Name : ' . $measurement->display_name; ?></span>
                            <span class="value"><?php echo $measurement->value; ?> inches</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tailor Details -->
            <div class="section tailordetails">
                <h3>Tailor's Information</h3>
                <div class="tailor-card">
                    <img src="<?php echo $data['tailor']->profile_pic ?
                        'data:image/jpeg;base64,'.base64_encode($data['tailor']->profile_pic) : 
                        URLROOT.'/public/img/default-profile.jpg'; ?>" 
                         alt="Tailor Profile">
                    <class="tailor-info">
                        <h4><?php echo $data['tailor']->first_name. " " . $data['tailor']->last_name; ?></h4>
                        <?php echo $data['tailor']->email; ?><br>
                        <?php echo $data['tailor']->phone_number; ?><br>
                        <?php echo $data['tailor']->address . ", ". $data['tailor']->home_town; ?><br>
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
                            <?php echo date('d M Y', strtotime($data['order']->order_date)); ?>
                        </span>
                    </div>
                    <div class="receipt-items">
                        <div class="receipt-item">
                            <span>Design Price</span>
                            <span>Rs. <?php echo number_format($data['order']->base_price, 2); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Customization Price</span>
                            <span>Rs. <?php echo number_format($data['order']->customization_price, 2); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Fabric Price</span>
                            <span>Rs. <?php echo number_format($data['order']->fabric_price, 2); ?></span>
                        </div>
                        <div class="receipt-total">
                            <span>Amount (tax excluded)</span>
                            <span>Rs. <?php echo number_format($data['order']->total_price, 2); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Included Tax</span>
                            <span>Rs. <?php echo number_format($data['order']->tax_amount, 2); ?></span>
                        </div>
                        <div class="receipt-total">
                            <span>Total Amount</span>
                            <span>Rs. <?php echo number_format($data['order']->final_amount, 2); ?></span>
                        </div>
                    </div>
                    <div class="payment-status <?php echo $data['order']->status; ?>">
                        <?php echo ucfirst($data['order']->status); ?>
                    </div>
                </div>
            </div>

            <div class="section Appointment-status-details">
                <h3>Appointment Status Details</h3>
                <div class="receipt">
                    <div class="receipt-items">
                        <div class="receipt-item">
                            <span>Appointment Status</span>
                            <span><?php echo ucfirst($data['order']->app_status); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Appointment ID</span>
                            <span><?php echo $data['order']->appointment_id; ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Appointment Date</span>
                            <span><?php echo date('d M Y', strtotime($data['order']->appointment_date)); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Appointment Time</span>
                            <span><?php echo $data['order']->appointment_time; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section order-status-details">
                <h3>Order Status Details</h3>
                <div class="receipt">
                    <div class="receipt-items">
                        <div class="receipt-item">
                            <span>Status</span>
                            <span><?php echo ucfirst($data['order']->order_status); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Delivery Address</span>
                            <span><?php echo $data['order']->delivery_address; ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Expected Delivery Date</span>
                            <span><?php echo date('d M Y', strtotime($data['order']->expected_delivery_date)); ?></span>
                        </div>
                        <div class="receipt-item">
                            <span>Actual Delivery Date</span>
                            <span><?php echo date('d M Y', strtotime($data['order']->actual_delivery_date)); ?></span>
                        </div>
                        <hr>
                        <br>
                        <div class="receipt-item">
                            <span>Notes</span>
                            <p><?php echo $data['order']->notes; ?></p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<?php require_once APPROOT . '/views/users/Customer/inc/footer.php'; ?>