document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('filterToggle');
    const optionsBox = document.getElementById('filterOptions');
    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        optionsBox.style.display = optionsBox.style.display === 'block' ? 'none' : 'block';
    });
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown-container')) {
            optionsBox.style.display = 'none';
        }
    });
});