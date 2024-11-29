<!-- header -->
<?php require_once APPROOT . '/views/inc/admin/adminheader.php'; ?>
<!-- Admin Review Form -->
<div class="complaint-form">
<div class="review-form-container">
    <h2>View Reviews</h2>
    
    <!-- Review Text -->
    <label for="reviewText">Review Text:</label>
    <textarea id="reviewText" name="reviewText" rows="4" disabled></textarea>

    <!-- Ratings -->
    <div class="section-title">Ratings:</div>
    <div class="ratings">
        ★ ★ ★ ★ ★
    </div>

    <!-- User Information Section -->
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

    <!-- Response History Section -->
    <div class="section-title">Response History</div>
    <label for="notes">Add Notes:</label>
    <textarea id="notes" name="notes" rows="4"></textarea>

    <!-- Buttons -->
    <div class="button-container">
        <button class="save-btn">Save Notes</button>
        <button class="accept-btn">Accept</button>
        <button class="reject-btn">Reject</button>
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
