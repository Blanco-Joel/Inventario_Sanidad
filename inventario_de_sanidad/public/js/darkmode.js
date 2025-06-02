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
    let darkmode = localStorage.getItem('darkmode');
    let themeSwitch = document.getElementById('theme-switch');

    if (darkmode === "active") {
        enableDarkMode();
    }

    addEvent(themeSwitch, "click", toggleTheme);

    return;
});

function toggleTheme() {
    darkmode = localStorage.getItem('darkmode');
    if (darkmode !== "active") 
        enableDarkMode();
    else
        disableDarkMode();
    
    return;
}

function enableDarkMode() {
    document.body.classList.add('darkmode');
    localStorage.setItem('darkmode', 'active');
    return;
}

function disableDarkMode() {
    document.body.classList.remove('darkmode');
    localStorage.setItem('darkmode', null);
    return;
}