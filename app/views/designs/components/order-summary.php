<div class="order-summary">
    <div class="summary-header">
        <h3>Your Order Summary</h3>
    </div>

    <div class="summary-items">
        <?php if (isset($_SESSION['order_details']['design'])): ?>
            <div class="summary-item">
                <span class="item-label">Design:</span>
                <span class="item-value"><?php echo $_SESSION['order_details']['design']->name; ?></span>
                <span class="item-price">Rs. <?php echo number_format($_SESSION['order_details']['design']->base_price, 2); ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['order_details']['fabric'])): ?>
            <div class="summary-item">
                <span class="item-label">Fabric:</span>
                <span class="item-value"><?php echo $_SESSION['order_details']['fabric']->fabric_name; ?></span>
                <span class="item-price">
                    <?php if (isset($_SESSION['order_details']['fabric']->price_adjustment)): ?>
                        <p class="fabric-price-impact <?php echo $_SESSION['order_details']['fabric']->price_adjustment > 0 ? 'price-increase' : 'price-decrease'; ?>">
                            <?php echo $_SESSION['order_details']['fabric']->price_adjustment > 0 ? '+' : ''; ?>Rs. <?php echo number_format($_SESSION['order_details']['fabric']->price_adjustment, 2); ?>
                        </p>
                    <?php else: ?>
                        <p class="fabric-price-impact">Rs. 0.00</p>
                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['order_details']['color'])): ?>
            <div class="summary-item">
                <span class="item-label">Color:</span>
                <span class="item-value"><?php echo $_SESSION['order_details']['color']->color_name; ?></span>
                <span class="item-color">
                    <div class="summary-color-swatch"
                        data-color="<?php echo $_SESSION['order_details']['color']->color_name; ?>"
                        style="background-color: <?php echo $_SESSION['order_details']['color']->color_code ?? '#000'; ?>">
                    </div>
                </span>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['order_details']['customizations'])): ?>
            <div class="summary-section">
                <h4>Customizations:</h4>
                <?php foreach ($_SESSION['order_details']['customizations'] as $typeId => $choice): ?>
                    <div class="summary-item">
                        <span class="item-label"><?php echo $choice->name; ?>:</span>
                        <span class="item-price">
                            <?php if ($choice->price_adjustment != 0): ?>
                                <p class="fabric-price-impact <?php echo $choice->price_adjustment > 0 ? 'price-increase' : 'price-decrease'; ?>">
                                    <?php echo $choice->price_adjustment > 0 ? '+' : ''; ?>Rs. <?php echo number_format($choice->price_adjustment, 2); ?>
                                </p>
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['order_details']['measurements']) && !empty($_SESSION['order_details']['measurements'])): ?>
            <div class="summary-section">
                <h4>Measurements</h4>
                <div class="summary-item">
                    <span class="item-value">Measurements entered</span>
                    <span class="check-icon"><i class="fas fa-check-circle"></i></span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class=".order-summary-price-summary">
        <div class="subtotal">
            <span>Subtotal:</span>
            <span>Rs. <?php echo isset($_SESSION['order_details']['total_price']) ? number_format($_SESSION['order_details']['total_price'], 2) : '0.00'; ?></span>
        </div>
        <div class="taxes">
            <span>Tax (12%):</span>
            <span>Rs. <?php
                        $tax = isset($_SESSION['order_details']['total_price']) ? $_SESSION['order_details']['total_price'] * 0.12 : 0;
                        echo number_format($tax, 2);
                        ?></span>
        </div>
        <div class="total">
            <span>Total:</span>
            <span>Rs. <?php
                        $total = isset($_SESSION['order_details']['total_price']) ? $_SESSION['order_details']['total_price'] * 1.12 : 0;
                        echo number_format($total, 2);
                        ?></span>
        </div>
    </div>
</div>