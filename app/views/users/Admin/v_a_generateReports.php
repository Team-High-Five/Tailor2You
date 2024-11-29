<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

    <!-- Main Content Section -->
    <div class="report-container">
        <h2>Generate Reports</h2>
        <form>
            <div class="form-group">
                <label for="reportType">Report Type:</label>
                <select id="reportType" name="reportType">
                    <option value="">Select Report Type</option>
                    <option value="sales">Sales Report</option>
                    <option value="refund">Refund Report</option>
                    <option value="userActivity">User Activity Report</option>
                    <option value="inventory">Inventory Report</option>
                    <option value="complaints">Complaints & Reviews Report</option>
                    <option value="financial">Financial Report</option>
                </select>
            </div>
    
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" rows="3" placeholder="description of the selected report type, explaining what data it covers."></textarea>
            </div>
    
            <div class="form-group">
                <label>Date Range:</label>
                <div class="date-range">
                    <button type="button">Today</button>
                    <button type="button">Last 7 Days</button>
                    <button type="button">Last 30 Days</button>
                    <input type="date" id="customRange" placeholder="Custom">
                </div>
            </div>
    
            <div class="form-group">
                <label for="outputFormat">Output Format:</label>
                <select id="outputFormat" name="outputFormat">
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                    <option value="csv">CSV</option>
                    <option value="html">HTML</option>
                </select>
            </div>
    
            <div class="form-group buttons">
                <button type="button" id="generateReport">Generate Report</button>
                
                <button type="button" id="downloadReport">Download Report</button>
            </div>
        </form>
    </div>
</body>
</html>
