function addEvent(element, eventName, handler) {
    if (element.addEventListener) {
        element.addEventListener(eventName, handler, false);
    } else if (element.attachEvent) {
        element.attachEvent('on' + eventName, function () {
            handler.call(element, window.event);
        });
    }
    return;
}

addEvent(document, "DOMContentLoaded", function () {
    let sidebar = document.querySelector('.sidebar');
    let linkTexts = document.querySelectorAll('.link-text');
    let btnNotifications = document.getElementById("btn-notifications");
    let notificationsList = document.getElementById("notifications-list");
    let userInfoToggle = document.getElementById("user-info-toggle");
    let logoutSection = document.getElementById("logout-section");

    initSidebarToggle(sidebar, linkTexts);
    initSubmenus();
    initNotifications(btnNotifications, notificationsList);
    initLogoutToggle(userInfoToggle, logoutSection);
    initActiveLinks();

    return;
});

function initSidebarToggle(sidebar, linkTexts) {
    function handleDocumentClick(e) {
        let clickedInsideSidebar = e.target.closest('.sidebar');
        let isSidebarExpanded = sidebar.classList.contains('expanded');

        if (clickedInsideSidebar && !isSidebarExpanded) {
            sidebar.classList.add('expanded');
        } else if (!clickedInsideSidebar && isSidebarExpanded) {
            let i = 0;
            while (i < linkTexts.length) {
                linkTexts[i].classList.remove('show');
                i++;
            }

            sidebar.classList.remove('expanded');

            let openItems = document.querySelectorAll('.has-submenu.open');
            let j = 0;
            while (j < openItems.length) {
                openItems[j].classList.remove('open');
                j++;
            }
        }
    }

    function handleTransitionEnd(e) {
        if (e.propertyName === 'width' && sidebar.classList.contains('expanded')) {
            let i = 0;
            while (i < linkTexts.length) {
                linkTexts[i].classList.add('show');
                i++;
            }
        }
    }

    addEvent(document, 'click', handleDocumentClick);
    addEvent(sidebar, 'transitionend', handleTransitionEnd);

    return;
}

function initSubmenus() {
    let submenuParents = document.querySelectorAll(".sidebar .has-submenu");
    let i = 0;

    while (i < submenuParents.length) {
        let parent = submenuParents[i];
        let toggleLink = parent.querySelector("a");

        if (toggleLink) {
            addEvent(toggleLink, "click", function (e) {
                e.preventDefault();
                parent.classList.toggle("open");
            });
        }

        i++;
    }

    return;
}

function initNotifications(btnNotifications, notificationsList) {
    if (!btnNotifications || !notificationsList) {
        return;
    }

    function toggleNotifications(e) {
        e.stopPropagation();
        notificationsList.classList.toggle("show");
    }

    function closeNotifications(e) {
        let isInsideBtn = e.target.closest("#btn-notifications");
        let isInsideList = e.target.closest("#notifications-list");
        if (!isInsideBtn && !isInsideList) {
            notificationsList.classList.remove("show");
        }
    }

    addEvent(btnNotifications, "click", toggleNotifications);
    addEvent(document, "click", closeNotifications);

    return;
}

function initLogoutToggle(userInfoToggle, logoutSection) {
    function toggleLogout(e) {
        e.stopPropagation();
        logoutSection.style.display = (logoutSection.style.display === "none" || logoutSection.style.display === "")
            ? "block"
            : "none";
    }

    function hideLogout(e) {
        if (!e.target.closest(".user-dropdown")) {
            logoutSection.style.display = "none";
        }
    }

    addEvent(userInfoToggle, "click", toggleLogout);
    addEvent(document, "click", hideLogout);

    return;
}

function initActiveLinks() {
    let links = document.querySelectorAll('.sidebar a');
    let i = 0;

    while (i < links.length) {
        let link = links[i];
        let href = link.getAttribute('href');

        if (href && href !== '') {
            addEvent(link, 'click', function () {
                let j = 0;
                while (j < links.length) {
                    links[j].classList.remove('active');
                    j++;
                }
                this.classList.add('active');
            });
        }

        i++;
    }

    return;
}
