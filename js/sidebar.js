
const toggleDropdown = (event, dropdownId)=> {
    event.stopPropagation();
    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
        if (dropdown.id !== dropdownId) {
            dropdown.classList.add('hidden');
        }
    });
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
        dropdown.classList.add('hidden');
    });
});

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.toggle('sidebar-hidden');
    overlay.classList.toggle('hidden');
}