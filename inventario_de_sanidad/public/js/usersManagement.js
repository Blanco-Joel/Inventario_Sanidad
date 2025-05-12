if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);
    

function inicio(){
    
    userDataRetrieve();
    // let formBaja = document.getElementById("registrar");
    let buscar = document.getElementById("buscarId");
    let radiosFiltro = document.getElementsByName("filtro"); // Obtén todos los radio buttons
    let botonesVer = document.querySelectorAll("[id^='btn-ver-']") 
    let botonesBaja = document.querySelectorAll("[id^='btn-delete-']") 

    if (document.addEventListener){
        buscar.addEventListener("keyup",filtrarTabla);
    }else if (document.attachEvent){
        buscar.attachEvent("onkeyup", filtrarTabla);
    }
    for (let radio of radiosFiltro) {
        if (document.addEventListener){
            radio.addEventListener("change", filtrarTabla);
        }else if (document.attachEvent){
            radio.attachEvent("onchange", filtrarTabla);
        }
    }
    for (let btn of botonesVer) {
        if (document.addEventListener){
            btn.addEventListener("submit", showPassword);
        }else if (document.attachEvent){
            btn.attachEvent("onsubmit", showPassword);
        }
    }
    for (let btn of botonesBaja) {
        if (document.addEventListener){
            btn.addEventListener("submit", mostrarDialogConfirmacion);
        }else if (document.attachEvent){
            btn.attachEvent("onsubmit", mostrarDialogConfirmacion);
        }
    }
}

function mostrarDialogConfirmacion(event) 
{
    event.preventDefault();
    let botonConfirmar  = document.getElementById("aceptar");
    let botonCancelar = document.getElementById("cancelar");

    let dialog = document.getElementById("confirmacion");
    dialog.setAttribute("open", "true");


    // Esperamos a que el usuario confirme o cancele
    botonConfirmar.onclick = () => {
        event.target.submit(); // Envía el formulario manualmente
        cerrarDialog("confirmacion");
    };

    botonCancelar.onclick = () => {
        cerrarDialog("confirmacion");
    };
}
async function userDataRetrieve() {
    const response = await fetch('/users/usersManagementData');
    window.USERDATA = await response.json();

}
function showPassword(event) {
    event.preventDefault(); // Evita que el formulario se envíe inmediatamente
    let user = event.target.id.split("-")[2]-1;
    let password = USERDATA[user]["password"];
    let campo = event.target.querySelector("b");
    if (campo.textContent == password) 
        campo.textContent = "************";
    else
    campo.textContent = password;
    
}
function cerrarDialog(mensaje) 
{
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
        let swapIndex = -1;

        for (let i = 1; i < (rows.length - 1); i++) {
            let linea = rows[i].getElementsByTagName("TD")[columnIndex];
            let lineaSiguiente = rows[i + 1].getElementsByTagName("TD")[columnIndex];

            let lineaContent = linea.textContent.trim().toLowerCase();
            let lineaSiguienteContent = lineaSiguiente.textContent.trim().toLowerCase();

            if ((dir ==  "asc" && lineaContent > lineaSiguienteContent) ||
                (dir ==  "desc" && lineaContent < lineaSiguienteContent)) {
                if (swapIndex ==  -1) {
                    swapIndex = i;
                }
            }
        }

        if (swapIndex !== -1) {
            rows[swapIndex].parentNode.insertBefore(rows[swapIndex + 1], rows[swapIndex]);
            switching = true;
            switchcount++;
        } else if (switchcount ==  0 && dir ==  "asc") {
            dir = "desc";
            switching = true;
        }
    }
}
function filtrarTabla(event) {

    console.log(event.target.type);
    if (event.target.type == "radio" || event.target.type == "text" && (event.key.length ==  1 || event.key ==  "Backspace" || event.key ==  "Delete")) {
        let input = document.getElementById("buscarId").value.toLowerCase();
        let filas = document.querySelectorAll("#tabla-usuarios tbody tr");
        let index = document.querySelector('input[name="filtro"]:checked').value;

        filas.forEach(fila => {
            let id = fila.querySelector("td:nth-child("+index+")").textContent.toLowerCase();
            if (id.includes(input)) {
                fila.style.display = "";
            } else {
                fila.style.display = "none";
            }
        });

    }

}