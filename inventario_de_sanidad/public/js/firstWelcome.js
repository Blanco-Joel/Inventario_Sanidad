if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);

// Obtener datos del usuario (para saber si es primer login)
function userDataRetrieve() {
    let result = fetch('/firstLogData')
        .then(function (response) {
            if (!response.ok) {
                throw new Error("No se pudo obtener datos");
            }
            let jsonData = response.json();
            return jsonData;
        })
        .then(function (data) {
            //console.log("📦 Datos del usuario:", data);
            return data;
        })
        .catch(function (error) {
            console.error("Error al obtener datos de usuario:", error);
            return null;
        });

    return result;
}

// Función para iniciar la página
function inicio() {
    userDataRetrieve().then(
        function (userdata) {
            let isFirstLogin = userdata && !userdata["first_log"];
            if (isFirstLogin) mostrarDialogInicio();

            mostrarToastSuccess();
        });
}

// Función para mostrar el dialogo de cambio de contraseña
function mostrarDialogInicio(e) {
    let dialog = document.getElementById("firstLogDialog");
    
    dialog.style.display = "flex";
    // dialog.setAttribute("open", "true");
    // console.log("💬 Diálogo abierto.");

    let form = dialog.querySelector("form");
    if (document.addEventListener) {
        form.addEventListener("submit",newPass)
    } else if (document.attachEvent) {
        form.attachEvent("onsubmit",newPass);
    }
}

// Función para validar la contraseña
function newPass(e) {
    let form = e.target;
    let inputs = form.getElementsByTagName("input");
    
    let error = document.getElementById("error");

    error.textContent = "";

    // Validar contraseñas
    if (inputs[2].value !== inputs[1].value) {
        error.textContent = "Las contraseñas no coinciden.";
        e.preventDefault();
        return;
    }

    let dialog = document.getElementById("firstLogDialog");
    dialog.style.display = "none";
}

// Mostrar el toast si está presente en el DOM
function mostrarToastSuccess() {
    const toast = document.getElementById("successToast");
    if (toast) {
        toast.classList.remove("hidden");
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
            setTimeout(() => toast.classList.add("hidden"), 300);
        }, 3000);
    }
}