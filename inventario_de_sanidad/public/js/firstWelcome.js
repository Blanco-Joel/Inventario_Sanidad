if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);

// Función para obtener los datos del usuario
async function userDataRetrieve() {
    var response = await fetch('/firstLogData');
    var data = await response.json();
    console.log("📦 Datos del usuario:", data);
    return data;
}

// Función para iniciar la página
async function inicio(){
    var userdata =  await userDataRetrieve();
    if (!userdata["first_log"])
        mostrarDialogInicio();
}

// Función para mostrar el dialogo de cambio de contraseña
function mostrarDialogInicio(e) {
    let dialog = document.getElementById("firstLogDialog");
    dialog.setAttribute("open", "true");
    console.log("💬 Diálogo abierto.");

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
    cerrarDialog(dialog);
}

// Función para cerrar el dialogo
function cerrarDialog(dialog) {
    if (dialog.hasAttribute("open")) {
        dialog.removeAttribute("open");
    }
}