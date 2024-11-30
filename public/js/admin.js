function confirmDelete() {
    return confirm('Are you sure you want to delete this user?');
}
function confirmSave() {
    return confirm('Are you sure you want to save these changes?');
}
<a href="<?php echo URLROOT; ?>/admin/editCustomer/<?php echo $customer->user_id; ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
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