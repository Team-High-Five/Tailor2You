localStorage.setItem('theme', newTheme);

// Load saved theme on page load
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    document.documentElement.setAttribute('data-theme', savedTheme);
}