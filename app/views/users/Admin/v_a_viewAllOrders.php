<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="main-content">
    <div class="search-container">
        <div class="search-bar">
            <input type="text" placeholder="To quickly find specific orders">
            <button><i class="fas fa-search"></i></button>
        </div>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($data['orders']) && !empty($data['orders'])): ?>
                <?php foreach ($data['orders'] as $order): ?>
                    <tr>
                        <td><?php echo $order->order_id; ?></td>
                        <td><?php echo $order->customer_id; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($order->order_date)); ?></td>
                        <td><?php echo number_format($order->total_amount, 2); ?></td>
                        <td><span class="status <?php echo strtolower($order->status); ?>"><?php echo ucfirst($order->status); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



