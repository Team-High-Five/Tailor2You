<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
    <!-- Main Content Section -->
    <div class="complaint-form">
        <h2>Refund Payments</h2>
    <div class="refund-container">
            <div class="column-left">
                <div class="form-group">
                    <label for="refundID">Refund ID:</label>
                    <input type="text" id="refundID" name="refundID" disabled>
                </div>
                <div class="form-group">
                    <label for="requestDate">Request Date:</label>
                    <input type="text" id="requestDate" name="requestDate" disabled>
                    
                </div>
                <div class="form-group">
                    <label for="refundAmount">Refund Amount:</label>
                    <input type="text" id="refundAmount" name="refundAmount" disabled>
                </div>
                <div class="form-group">
                    <label for="paymentMethod">Payment Method:</label>
                    <input type="text" id="paymentMethod" name="paymentMethod" disabled>
                </div>
            </div>
        
            <div class="column-right">
                <div class="form-group">
                    <label for="orderID">Order ID:</label>
                    <input type="text" id="orderID" name="orderID" disabled>
                </div>
                <div class="form-group">
                    <label for="processedDate">Processed Date:</label>
                    <input type="text" id="processedDate" name="processedDate" disabled>
                </div>
                <div class="form-group">
                    <label for="refundStatus">Refund Status:</label>
                    <select id="refundStatus" name="refundStatus" disabled>
                        <option value="pending">Pending</option>
                        <option value="processed">Processed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bankDetails">Bank Account/Credit Card Details:</label>
                    <textarea id="bankDetails" name="bankDetails" rows="3" disabled></textarea>
                </div>
            </div>
        </div>

            <div class="section-title">User Information:</div>
            <div class="user-info">

                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" disabled>
            
                <label for="userID">User ID:</label>
                <input type="text" id="userID" name="userID" disabled>
                
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" disabled>
                
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" disabled>
            </div>
    
            <div class="section-title">Response History</div>
           
                <label for="notes">Add Notes:</label>
                <textarea id="notes" name="notes" rows="4"></textarea>
                
        
            <div class="button-container">
                <button class="save-btn"> Save Notes</button>
                <button class="resolve-btn">Process</button>
                <button class="reject-btn">Cancle</button>
                
            </div>
        </div>
    </div>    
    
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.style.left = sidebar.style.left === "-300px" ? "0" : "-300px";
        }

        function toggleDropdown() {
            const dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.classList.toggle("show");
        }

        // Optional: Add function to log out or sign out (placeholder actions)
        function logout() {
            alert("Logging out...");
            // Add actual logout code here
        }

        function signOut() {
            alert("Signing out...");
            // Add actual sign out code here
        }

        // Close the dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.fa-ellipsis-h')) {
                const dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
