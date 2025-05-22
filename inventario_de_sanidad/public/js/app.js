document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector('.sidebar');
    const linkTexts = document.querySelectorAll('.link-text');
    const btnNotifications = document.getElementById("btn-notifications");
    const notificationsList = document.getElementById("notifications-list");
    const userInfoToggle = document.getElementById("user-info-toggle");
    const logoutSection = document.getElementById("logout-section");

    initSidebarToggle();
    initSubmenus();
    initNotifications();
    initLogoutToggle();
    initActiveLinks();

    // Función que controla la apertura y cierre del sidebar
    function initSidebarToggle() {
        document.addEventListener('click', (e) => {
            // Comprueba si el click fue dentro del sidebar
            const clickedInsideSidebar = e.target.closest('.sidebar');

            // Comprueba si el sidebar está expandido
            const isSidebarExpanded = sidebar.classList.contains('expanded');

            // Si se clicó dentro y no está expandido, lo expande
            if (clickedInsideSidebar && !isSidebarExpanded) {
                sidebar.classList.add('expanded');
            // Si se clicó fuera y está expandido, lo colapsa
            } else if (!clickedInsideSidebar && isSidebarExpanded) {
                linkTexts.forEach(link => link.classList.remove('show'));
                sidebar.classList.remove('expanded');

                // Cerrar submenús si los hay abiertos
                document.querySelectorAll('.has-submenu.open').forEach(item => {
                    item.classList.remove('open');
                });
            }
        });

        // Cuando termina la transición CSS (ancho), si el sidebar está expandido, hace visibles los textos
        sidebar.addEventListener('transitionend', (e) => {
            if (e.propertyName === 'width' && sidebar.classList.contains('expanded')) {
                linkTexts.forEach(link => link.classList.add('show'));
            }
        });
    }

    // Permite abrir/cerrar submenús con click
    function initSubmenus() {
        const submenuParents = document.querySelectorAll(".sidebar .has-submenu");

        submenuParents.forEach(parent => {
            const toggleLink = parent.querySelector("a");
            if (!toggleLink) return;

            toggleLink.addEventListener("click", (e) => {
                e.preventDefault();
                parent.classList.toggle("open");
            });
        });
    }

    // Inicializa el botón de notificaciones para mostrar/ocultar la lista
    function initNotifications() {
        // Al hacer click en el botón de notificaciones:
        btnNotifications.addEventListener("click", (e) => {
            e.stopPropagation();
            notificationsList.classList.toggle("show");
        });

        // Si se hace click en cualquier parte fuera del botón o la lista, se oculta la lista
        document.addEventListener("click", (e) => {
            if (!e.target.closest("#btn-notifications") && !e.target.closest("#notifications-list")) {
                notificationsList.classList.remove("show");
            }
        });
    }


    // Inicializa el toggle del logout dentro del dropdown de usuario
    function initLogoutToggle() {
        userInfoToggle.addEventListener("click", (e) => {
            e.stopPropagation();
            // Alterna la visibilidad del logout (block o none)
            logoutSection.style.display =
                logoutSection.style.display === "none" || logoutSection.style.display === ""
                    ? "block"
                    : "none";
        });

        // Si se hace click fuera del dropdown, oculta el logout
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".user-dropdown")) {
                logoutSection.style.display = "none";
            }
        });
    }

    // Inicializa la clase active en los enlaces del sidebar para marcar el seleccionado
    function initActiveLinks() {
        const links = document.querySelectorAll('.sidebar a');

        links.forEach(link => {
            // Solo aplica a enlaces con href válido que no sea vacío
            const href = link.getAttribute('href');
            if (href && href !== '') {
                link.addEventListener('click', function (e) {
                    // Remueve la clase active de todos
                    links.forEach(l => l.classList.remove('active'));

                    // Agrega la clase active al actual
                    this.classList.add('active');
                });
            }
        });
    }
});
