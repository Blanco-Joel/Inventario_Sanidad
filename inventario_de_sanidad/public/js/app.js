document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector('.sidebar');
    const linkTexts = document.querySelectorAll('.link-text');

    // Mostrar texto solo cuando termina la transición del sidebar
    sidebar.addEventListener('mouseenter', () => {
        sidebar.classList.add('expanded');

        const onTransitionEnd = (e) => {
            if (e.propertyName === 'width') {
                linkTexts.forEach(link => link.classList.add('show'));
                sidebar.removeEventListener('transitionend', onTransitionEnd);
            }
        };

        sidebar.addEventListener('transitionend', onTransitionEnd);
    });

    sidebar.addEventListener('mouseleave', () => {
        linkTexts.forEach(link => link.classList.remove('show'));
        sidebar.classList.remove('expanded');

        // cerrar submenús al salir del sidebar
        document.querySelectorAll('.has-submenu.open').forEach(item => {
            item.classList.remove('open');
        });
    });

    // Desplegar submenús al hacer clic
    const submenuParents = document.querySelectorAll(".sidebar .has-submenu");

    submenuParents.forEach(parent => {
        const toggleLink = parent.querySelector("a");

        toggleLink.addEventListener("click", (e) => {
            e.preventDefault();
            parent.classList.toggle("open");
        });
    });


    // Notificaciones
    const btnNotifications = document.getElementById("btn-notifications");
    const notificationsList = document.getElementById("notifications-list");

    btnNotifications.addEventListener("click", () => {
        notificationsList.classList.toggle("show");
    });


    // Logout desplegable
    const userInfoToggle = document.getElementById("user-info-toggle");
    const logoutSection = document.getElementById("logout-section");

    userInfoToggle.addEventListener("click", () => {
        logoutSection.style.display =
            logoutSection.style.display === "none" || logoutSection.style.display === ""
                ? "block"
                : "none";
    });

    // Opcional: ocultar si se hace clic fuera
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".user-dropdown")) {
            logoutSection.style.display = "none";
        }
    });
});
