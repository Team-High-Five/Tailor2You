<?php require_once APPROOT . '/views/admin/inc/header.php'; ?>
<?php require_once APPROOT . '/views/admin/inc/sidebar.php'; ?>

<div class="main-content">
    <div class="page-header">
        <h1>Feedback Statistics</h1>
        <a href="<?php echo URLROOT; ?>/feedback" class="btn btn-secondary">
            <i class="fas fa-list"></i> Back to Feedback List
        </a>
    </div>
    
    <div class="stats-container">
        <!-- Summary Cards -->
        <div class="stats-summary">
            <div class="stat-card">
                <div class="stat-value"><?php echo $data['stats']['total']; ?></div>
                <div class="stat-label">Total Feedback</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $data['stats']['published']; ?></div>
                <div class="stat-label">Published</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $data['stats']['pending']; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $data['stats']['rejected']; ?></div>
                <div class="stat-label">Rejected</div>
            </div>
            
            <div class="stat-card rating">
                <div class="stat-value"><?php echo $data['stats']['average_rating']; ?></div>
                <div class="rating-stars">
                    <?php 
                        $avgRating = $data['stats']['average_rating'];
                        for ($i = 1; $i <= 5; $i++): 
                            if ($i <= floor($avgRating)): ?>
                                <span class="star filled">★</span>
                            <?php elseif ($i - 0.5 <= $avgRating): ?>
                                <span class="star half-filled">★</span>
                            <?php else: ?>
                                <span class="star">☆</span>
                            <?php endif;
                        endfor; 
                    ?>
                </div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>
        
        <!-- Status Distribution Chart -->
        <div class="chart-container">
            <h2>Feedback Status Distribution</h2>
            <div class="status-chart">
                <?php 
                    $total = $data['stats']['total'] > 0 ? $data['stats']['total'] : 1;
                    $publishedPercent = ($data['stats']['published'] / $total) * 100;
                    $pendingPercent = ($data['stats']['pending'] / $total) * 100;
                    $rejectedPercent = ($data['stats']['rejected'] / $total) * 100;
                ?>
                <div class="chart-bar">
                    <div class="bar-segment published" style="width: <?php echo $publishedPercent; ?>%;" 
                         title="Published: <?php echo $data['stats']['published']; ?> (<?php echo round($publishedPercent); ?>%)">
                    </div>
                    <div class="bar-segment pending" style="width: <?php echo $pendingPercent; ?>%;" 
                         title="Pending: <?php echo $data['stats']['pending']; ?> (<?php echo round($pendingPercent); ?>%)">
                    </div>
                    <div class="bar-segment rejected" style="width: <?php echo $rejectedPercent; ?>%;" 
                         title="Rejected: <?php echo $data['stats']['rejected']; ?> (<?php echo round($rejectedPercent); ?>%)">
                    </div>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color published"></div>
                        <div class="legend-text">Published (<?php echo round($publishedPercent); ?>%)</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color pending"></div>
                        <div class="legend-text">Pending (<?php echo round($pendingPercent); ?>%)</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color rejected"></div>
                        <div class="legend-text">Rejected (<?php echo round($rejectedPercent); ?>%)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/admin/inc/footer.php'; ?>
