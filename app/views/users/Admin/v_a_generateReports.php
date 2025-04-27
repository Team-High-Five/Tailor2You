<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<!-- Main Content Section -->
<div class="report-container">
    <h2>Generate Reports</h2>
    <form action="<?php echo URLROOT; ?>/reports/generate" method="POST">
        <!-- Report Type Selection -->
        <div class="form-group">
            <label for="reportType">Report Type:</label>
            <select id="reportType" name="reportType" required>
                <option value="">Select Report Type</option>
                <option value="sales">Sales Report</option>
                <option value="refund">Refund Report</option>
                <option value="userActivity">User Activity Report</option>
                <option value="inventory">Inventory Report</option>
            </select>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="3" placeholder="Description"></textarea>
        </div>

        <!-- Date Range -->
        <div class="form-group">
            <label>Date Range:</label>
            <div class="date-range">
                <button type="button" onclick="setDateRange('today')">Today</button>
                <button type="button" onclick="setDateRange('last7')">Last 7 Days</button>
                <button type="button" onclick="setDateRange('last30')">Last 30 Days</button>
                <input type="date" id="customRangeStart" name="customRangeStart" placeholder="Start Date">
                <input type="date" id="customRangeEnd" name="customRangeEnd" placeholder="End Date">
            </div>
        </div>

        <!-- Output Format -->
        <div class="form-group">
            <label for="outputFormat">Output Format:</label>
            <select id="outputFormat" name="outputFormat" required>
            
                <option value="pdf">PDF</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="form-group buttons">
            <button type="submit" id="generateReport">Generate Report</button>
        </div>
    </form>
</div>

<script>
    // JavaScript to handle date range buttons
    function setDateRange(range) {
        const today = new Date();
        let startDate, endDate;

        if (range === 'today') {
            startDate = today.toISOString().split('T')[0];
            endDate = startDate;
        } else if (range === 'last7') {
            endDate = today.toISOString().split('T')[0];
            const last7Days = new Date(today.setDate(today.getDate() - 7));
            startDate = last7Days.toISOString().split('T')[0];
        } else if (range === 'last30') {
            endDate = today.toISOString().split('T')[0];
            const last30Days = new Date(today.setDate(today.getDate() - 30));
            startDate = last30Days.toISOString().split('T')[0];
        }

        document.getElementById('customRangeStart').value = startDate;
        document.getElementById('customRangeEnd').value = endDate;
    }
</script>
</body>
</html>
