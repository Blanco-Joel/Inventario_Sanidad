document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.sidebar ul li > a');

    menuItems.forEach(item => {
        item.addEventListener('click', function(event) {
            const submenu = item.nextElementSibling;
            if (submenu && submenu.classList.contains('submenu')) {
                // Evitar que se cierre el submenú si la opción activa ya está seleccionada
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            }
        });
    });
});
