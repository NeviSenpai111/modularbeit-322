function toggleBurgerMenu(element) {
    element.classList.toggle('active');
    toggleSidebar();
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.style.width = sidebar.style.width === '250px' ? '0' : '250px';
}
