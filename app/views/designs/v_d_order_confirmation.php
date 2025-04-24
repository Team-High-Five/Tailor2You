<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="order-confirmation-container">
    <div class="confirmation-card">
        <div class="confirmation-message">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Order Placed Successfully!</h2>
            <p>Thank you for your order. We have received your request and will begin processing it shortly.</p>
        </div>

        <?php if (isset($_SESSION['order_details']) || isset($data['order_details'])): ?>
            <?php $order = $data['order_details'] ?? $_SESSION['order_details']; ?>

            <div class="confirmation-sections">
                <!-- Order Info Section -->
                <div class="confirmation-section">
                    <h3><i class="fas fa-info-circle"></i> Order Information</h3>
                    <div class="confirmation-content">
                        <div class="confirmation-row">
                            <span class="confirmation-label">Order Number:</span>
                            <span class="confirmation-value order-id">
                                <?php echo $order['payment']['order_number'] ?? 'T2Y-' . rand(10000, 99999); ?>
                            </span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Order Date:</span>
                            <span class="confirmation-value"><?php echo date('F j, Y'); ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Subtotal:</span>
                            <span class="confirmation-value">Rs. <?php echo number_format($order['subtotal'] ?? 0, 2); ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Platform Fee (12%):</span>
                            <span class="confirmation-value">Rs. <?php echo number_format($order['platform_fee'] ?? 0, 2); ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Total Amount:</span>
                            <span class="confirmation-value">Rs. <?php echo number_format($order['total_price'] ?? 0, 2); ?></span>
                        </div>

                        <div class="confirmation-row">
                            <span class="confirmation-label">Payment Method:</span>
                            <span class="confirmation-value">
                                <?php echo isset($order['payment']['payment_method']) && $order['payment']['payment_method'] === 'card' ?
                                    'Credit/Debit Card' : 'Cash on Delivery'; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Design Details -->
                <div class="confirmation-section">
                    <h3><i class="fas fa-tshirt"></i> Design Details</h3>
                    <div class="confirmation-content">
                        <div class="confirmation-row">
                            <span class="confirmation-label">Design:</span>
                            <span class="confirmation-value"><?php echo $order['design']->name ?? 'N/A'; ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Category:</span>
                            <span class="confirmation-value"><?php echo $order['design']->category_name ?? 'N/A'; ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Fabric:</span>
                            <span class="confirmation-value"><?php echo $order['fabric']->fabric_name ?? 'N/A'; ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Color:</span>
                            <span class="confirmation-value">
                                <?php echo $order['color']->color_name ?? 'N/A'; ?>
                                <?php if (isset($order['color']->color_code)): ?>
                                    <span class="summary-color-swatch" style="background-color: <?php echo $order['color']->color_code; ?>"></span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <?php if (!empty($order['customizations'])): ?>
                    <!-- Customizations -->
                    <div class="confirmation-section">
                        <h3><i class="fas fa-sliders-h"></i> Customizations</h3>
                        <div class="confirmation-content">
                            <?php foreach ($order['customizations'] as $customization): ?>
                                <div class="confirmation-row">
                                    <span class="confirmation-label"><?php echo $customization->type_name ?? 'Option'; ?>:</span>
                                    <span class="confirmation-value"><?php echo $customization->name ?? 'N/A'; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($order['appointment']) && empty($order['appointment']['skipped'])): ?>
                    <!-- Appointment Details -->
                    <div class="confirmation-section">
                        <h3><i class="fas fa-calendar-check"></i> Fitting Appointment</h3>
                        <div class="confirmation-content">
                            <div class="confirmation-row">
                                <span class="confirmation-label">Date:</span>
                                <span class="confirmation-value">
                                    <?php echo date('F j, Y', strtotime($order['appointment']['date'])); ?>
                                </span>
                            </div>
                            <div class="confirmation-row">
                                <span class="confirmation-label">Time:</span>
                                <span class="confirmation-value">
                                    <?php echo date('g:i A', strtotime($order['appointment']['time'])); ?>
                                </span>
                            </div>
                            <div class="confirmation-row">
                                <span class="confirmation-label">Location:</span>
                                <span class="confirmation-value">
                                    <?php echo $order['appointment']['location_type'] === 'shop' ? 'Tailor\'s Shop' : 'Your Location'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Tracking Section -->
                <div class="tracking-info">
                    <h3><i class="fas fa-truck"></i> Order Status</h3>
                    <div class="tracking-steps">
                        <div class="tracking-step">
                            <div class="step-icon active">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="step-label">Order Placed</span>
                        </div>
                        <div class="tracking-step">
                            <div class="step-icon">
                                <i class="fas fa-cut"></i>
                            </div>
                            <span class="step-label">Fabric Cutting</span>
                        </div>
                        <div class="tracking-step">
                            <div class="step-icon">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <span class="step-label">Stitching</span>
                        </div>
                        <div class="tracking-step">
                            <div class="step-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <span class="step-label">Ready for Delivery</span>
                        </div>
                        <div class="tracking-step">
                            <div class="step-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <span class="step-label">Delivered</span>
                        </div>
                    </div>
                </div>

                <div class="confirmation-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Delivery Information</h3>
                    <div class="confirmation-content">
                        <div class="confirmation-row">
                            <span class="confirmation-label">Estimated Delivery:</span>
                            <span class="confirmation-value"><?php echo date('F j, Y', strtotime('+14 days')); ?></span>
                        </div>
                        <div class="confirmation-row">
                            <span class="confirmation-label">Delivery Address:</span>
                            <span class="confirmation-value">Your default address</span>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="no-order-info">
                <p>No order information is available. Please contact customer support if you believe this is an error.</p>
            </div>
        <?php endif; ?>

        <div class="confirmation-actions">
            <a href="<?php echo URLROOT; ?>/Customers/displayOrders" class="action-btn secondary-action">
                <i class="fas fa-list"></i> View My Orders
            </a>
            <a href="<?php echo URLROOT; ?>/Pages" class="action-btn primary-action">
                <i class="fas fa-home"></i> Back to Homepage
            </a>
        </div>
    </div>

    <div class="order-receipt">
        <div class="receipt-header">
            <h3>Order Receipt</h3>
            <button class="print-btn" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <div class="receipt-content">
            <div class="receipt-logo">
                <img src="<?php echo URLROOT; ?>/public/img/logo.png" alt="Tailor2You Logo">
            </div>

            <div class="receipt-order-number">
                Order #: <?php echo $order['payment']['order_number'] ?? 'T2Y-' . rand(10000, 99999); ?>
            </div>

            <div class="receipt-details">
                <div class="receipt-row">
                    <span>Item</span>
                    <span>Price</span>
                </div>

                <div class="receipt-row">
                    <span><?php echo $order['design']->name ?? 'Custom Design'; ?></span>
                    <span>Rs. <?php echo number_format($order['design']->base_price ?? 0, 2); ?></span>
                </div>

                <?php if (isset($order['fabric']) && isset($order['fabric']->price_adjustment) && $order['fabric']->price_adjustment != 0): ?>
                    <div class="receipt-row">
                        <span>Fabric: <?php echo $order['fabric']->fabric_name; ?></span>
                        <span>Rs. <?php echo number_format($order['fabric']->price_adjustment, 2); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($order['customizations'])): ?>
                    <?php foreach ($order['customizations'] as $customization): ?>
                        <?php if (isset($customization->price_adjustment) && $customization->price_adjustment != 0): ?>
                            <div class="receipt-row">
                                <span><?php echo $customization->name; ?></span>
                                <span>Rs. <?php echo number_format($customization->price_adjustment, 2); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="receipt-divider"></div>

                <div class="receipt-row subtotal">
                    <span>Subtotal</span>
                    <span>Rs. <?php echo number_format($order['subtotal'] ?? 0, 2); ?></span>
                </div>

                <div class="receipt-row">
                    <span>Platform Fee (12%)</span>
                    <span>Rs. <?php echo number_format($order['platform_fee'] ?? 0, 2); ?></span>
                </div>

                <div class="receipt-row total">
                    <span>Total</span>
                    <span>Rs. <?php echo number_format($order['total_price'] ?? 0, 2); ?></span>
                </div>
            </div>

            <div class="receipt-footer">
                Thank you for shopping with Tailor2You!
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/designs/inc/footer.php'; ?>