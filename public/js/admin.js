function confirmDelete() {
    return confirm('Are you sure you want to delete this user?');
}

function confirmSave() {
    return confirm('Are you sure you want to save these changes?');
}

function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    var mainContent = document.querySelector(".main-content");
    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-300px";
        mainContent.classList.remove("shifted");
    } else {
        sidebar.style.left = "0px";
        mainContent.classList.add("shifted");
    }
}

function toggleDropdown() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "block";
    }
}

// Add event listeners for dropdown buttons
document.querySelectorAll('.dropdown-btn').forEach(button => {
    button.addEventListener('click', toggleDropdown);
});

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
    if (!event.target.matches('.dropdown-btn')) {
        const dropdowns = document.getElementsByClassName("dropdown-container");
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
}