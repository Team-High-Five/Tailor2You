<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
    <!-- Main Content Section -->
    <div class="content">
        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="To quickly find specific users">
            <button><i class="fas fa-search"></i></button>
        </div>
        
        <!-- User Table -->
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Review ID</th>
                    <th>Review Text</th>
                    <th>Ratings</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table Data Placeholder for Dynamic Data -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['user_name']) ?></td>
                        <td><?= htmlspecialchars($user['review_id']) ?></td>
                        <td><?= htmlspecialchars($user['review_text']) ?></td>
                        <td><?= htmlspecialchars($user['ratings']) ?></td>
                        <td><?= htmlspecialchars($user['date']) ?></td>
                        <td>
                            <select>
                                <option value="pending" <?= $user['status'] === 'pending' ? 'selected' : '' ?>Pending</option>
                                <option value="processed" <?= $user['status'] === 'processed' ? 'selected' : '' ?>Processed</option>
                            </select>
                        </td>
                        <td>
                            <button class="view-btn"><i class="fas fa-eye"></i> View</button>
                            <button class="edit-btn"><i class="fas fa-edit"></i> Resolve</button>
                            <button class="delete-btn"><i class="fas fa-trash-alt"></i> Reject</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.style.left = sidebar.style.left === "-250px" ? "0" : "-250px";
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
