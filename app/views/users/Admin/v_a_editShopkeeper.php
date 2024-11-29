<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- sidebar -->
<?php require_once APPROOT . '/views/inc/admin/adminsidebar.php'; ?>

<div class="complaint-form">
        <div class="profile-edit">
            <div class="left-section">
                <img src="shopkeeper.jpg" alt="Shopkeeper Profile Image" class="profile-pic">
                <div class="shopkeeper-info">
                    <h3>Sanjeewa Prasanna</h3>
                    <p><a href="mailto:sanjeewap@gmail.com">sanjeewap@gmail.com</a></p>
                    <p>0772578680</p>
                </div>
            </div>

            <div class="right-section">
                <h2>Basic Info</h2>
                <form action="update_shopkeeper.php" method="post" enctype="multipart/form-data">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name" required>

                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name" required>

                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" name="company_name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" required>

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>

                    <label for="account-status">Account Status</label>
                    <select id="account-status" name="account_status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <label for="logo">Logo</label>
                    <div class="logo-upload">
                        <?php
                        // Fetch logo path from the database
                        // $logo_path would be a variable where you store the path from the DB.
                        if (!empty($logo_path)) {
                            echo '<img src="' . $logo_path . '" alt="Shopkeeper Logo" class="uploaded-logo">';
                        } else {
                            echo '<p>No logo uploaded. You can upload one below:</p>';
                        }
                        ?>
                        <input type="file" id="logo" name="logo" accept="image/*">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="save-btn">Save</button>
                        <button type="reset" class="cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    
</body>
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
</html>
