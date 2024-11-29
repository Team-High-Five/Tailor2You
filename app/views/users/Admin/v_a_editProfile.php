
<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>
<?php
$user = [
    'first_name' => 'Kusum',
    'last_name' => 'Perera',
    'email' => 'kusumi1964@gmail.com',
    'phone' => '0776600577',
    'address' => '123 Main Street, Colombo',
    'account_status' => 'Active', // Fetch from DB (e.g., 'Active' or 'Inactive')
    'profile_pic' => 'path_to_image.jpg' // Replace with actual image path
];
?>
<div class="complaint-form">
<div class="container">
    <!-- User Info Section -->
    <div class="form-section">
        <!-- Left Column: Profile Picture -->
        <div class="left-column">
            <img src="<?php echo $user['tailor_image']; ?>" alt="User Profile Picture">
            <p><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
            <p><?php echo $user['email']; ?></p>
            <p><?php echo $user['phone']; ?></p>
        </div>

        <!-- Right Column: Form to Edit Details -->
        <div class="right-column">
            <form action="update_profile.php" method="POST">
                <div class="input-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="status">Account Status</label>
                    <select id="status" name="status" required>
                        <option value="Active" <?php if($user['account_status'] == 'Active') echo 'selected'; ?>>Active</option>
                        <option value="Inactive" <?php if($user['account_status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit">Save</button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='profile.php';">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
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
