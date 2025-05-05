if (document.addEventListener)
    window.addEventListener("load", inicio);
else if (document.attachEvent)
    window.attachEvent("onload", inicio);

async function userDataRetrieve() {
    const response = await fetch('/gestionUsuariosData');
    window.USERDATA = await response.json();
}

function inicio() {
    userDataRetrieve();

    let buscar = document.getElementById("buscarId");
    let confirmacion = document.getElementById("confirmacion");
    let radiosFiltro = document.getElementsByName("filtro");
    let botonesVer = document.querySelectorAll("[id^='btn-ver-']");
    let botonesBaja = document.querySelectorAll("[id^='btn-delete-']");

    if (document.addEventListener) {
        buscar.addEventListener("keyup", filtrarTabla);
        confirmacion.addEventListener("submit", confirmaciónAdmin);
    } else if (document.attachEvent) {
        buscar.attachEvent("onkeyup", filtrarTabla);
        confirmacion.attachEvent("onsubmit", confirmaciónAdmin);
    }

    for (let radio of radiosFiltro) {
        if (document.addEventListener) {
            radio.addEventListener("change", filtrarTabla);
        } else if (document.attachEvent) {
            radio.attachEvent("onchange", filtrarTabla);
        }
    }

    for (let btn of botonesVer) {
        if (document.addEventListener) {
            btn.addEventListener("submit", mostrarDialogConfirmacion);
        } else if (document.attachEvent) {
            btn.attachEvent("onsubmit", mostrarDialogConfirmacion);
        }
    }

    for (let btn of botonesBaja) {
        if (document.addEventListener) {
            btn.addEventListener("submit", mostrarDialogConfirmacion);
        } else if (document.attachEvent) {
            btn.attachEvent("onsubmit", mostrarDialogConfirmacion);
        }
    }

    // También lanzar confirmaciónAdmin al pulsar Enter
    document.getElementById("adminUser").addEventListener("keydown", function (e) {
        if (e.key === "Enter") confirmaciónAdmin(e);
    });
    document.getElementById("adminPass").addEventListener("keydown", function (e) {
        if (e.key === "Enter") confirmaciónAdmin(e);
    });
}

function mostrarDialogConfirmacion(event) {
    event.preventDefault();
    let dialog = document.getElementById("confirmacionAdmin");
    dialog.setAttribute("open", "true");
    let date = new Date();
    document.cookie = event.target.id.split("-")[1] + "=" + event.target.id.split("-")[2] +
        ";expires=" + (date.setTime(date.getTime() + (366 * 24 * 60 * 60 * 1000))) + ";path=/";
}

function confirmaciónAdmin(event) {
    event.preventDefault();
    let botonConfirmar = document.getElementById("aceptar");
    let botonCancelar = document.getElementById("cancelar");
    let user = document.getElementById("adminUser").value;
    let password = document.getElementById("adminPass").value;
    let allCookies = document.cookie.split("; ");
    let index = 0;
    let inexiste = true;

    while (inexiste && index < allCookies.length) {
        if (allCookies[index].startsWith("delete=") || allCookies[index].startsWith("ver="))
            inexiste = false;
        index += 1;
    }

    botonConfirmar.onclick = () => {
        actionDialog(allCookies[index - 1].split("="));
    };

    botonCancelar.onclick = () => {
        cerrarDialog("confirmacionAdmin");
    };
}

function actionDialog(cookie) {
    let user = document.getElementById("adminUser").value;
    let password = document.getElementById("adminPass").value;

    if ((password.length > 0 && user.length > 0)
        && USERDATA[user - 1]["password"] == password
        && USERDATA[user - 1]["user_type"] == "admin") {

        let boton = document.getElementById("btn-" + cookie[0] + "-" + cookie[1]);
        cerrarDialog("confirmacionAdmin");

        if (cookie[0] === "ver") {
            showPasswordById(cookie[1]);
        }else if (cookie[0] === "delete") {
                boton.submit();
                // Opcional: ocultar la fila al instante
                // document.getElementById("fila-user-" + id).style.display = "none";
            }

    } else {
        document.getElementById("errorAdmin").textContent = "CREDENCIALES INCORRECTAS.";
    }
}

function showPasswordById(id) {
    let boton = document.getElementById("btn-ver-" + id);
    let userIndex = parseInt(id) - 1;
    let password = USERDATA[userIndex]["password"];
    let campo = boton.querySelector("b");

    if (campo) {
        campo.textContent = password;
    }
}

function cerrarDialog(mensaje) {
    let dialog = document.getElementById(mensaje);
    dialog.removeAttribute("open");
}

function sortTable(columnIndex) {
    let table = document.getElementById("tabla-usuarios");
    let switching = true;
    let dir = "asc";
    let switchcount = 0;

    while (switching) {
        switching = false;
        let rows = table.rows;

        for (let i = 1; i < (rows.length - 1); i++) {
            let shouldSwitch = false;
            let x = rows[i].getElementsByTagName("TD")[columnIndex];
            let y = rows[i + 1].getElementsByTagName("TD")[columnIndex];

            if (dir == "asc") {
                if (x.innerText.toLowerCase() > y.innerText.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerText.toLowerCase() < y.innerText.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function filtrarTabla(event) {
    if (event.target.type == "radio" || event.target.type == "text" && (event.key.length === 1 || event.key === "Backspace" || event.key === "Delete")) {
        let input = document.getElementById("buscarId").value.toLowerCase();
        let filas = document.querySelectorAll("#tabla-usuarios tbody tr");
        let index = document.querySelector('input[name="filtro"]:checked').value;

        filas.forEach(fila => {
            let id = fila.querySelector("td:nth-child(" + index + ")").textContent.toLowerCase();
            if (id.includes(input)) {
                fila.style.display = "";
            } else {
                fila.style.display = "none";
            }
        });
    }
}
