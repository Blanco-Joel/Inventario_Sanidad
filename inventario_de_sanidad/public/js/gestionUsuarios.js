if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);
    

function inicio(){
    
    let formBaja = document.getElementById("registrar");

    
    if (document.addEventListener){
        formBaja.addEventListener("submit", mostrarDialogConfirmacion);
    }else if (document.attachEvent){
        formBaja.attachEvent("onsubmit", mostrarDialogConfirmacion);
    }
}

function mostrarDialogConfirmacion(e) 
{
    e.preventDefault(); // Evita que el formulario se envíe inmediatamente

    let botonConfirmar  = document.getElementById("aceptar");
    let botonCancelar = document.getElementById("cancelar");

    let dialog = document.getElementById("confirmacion");
    dialog.setAttribute("open", "true");


    // Esperamos a que el usuario confirme o cancele
    botonConfirmar.onclick = () => {
        e.target.submit(); // Envía el formulario manualmente
        cerrarDialog("confirmacion");
    };

    botonCancelar.onclick = () => {
        cerrarDialog("confirmacion");
    };
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
    if (event.key.length === 1 || event.key === "Backspace" || event.key === "Delete") {
        let input = document.getElementById("buscarId").value.toLowerCase();
        let filas = document.querySelectorAll("#tabla-usuarios tbody tr");

        filas.forEach(fila => {
            let id = fila.querySelector("td").textContent.toLowerCase();
            if (id.includes(input)) {
                fila.style.display = "";
            } else {
                fila.style.display = "none";
            }
        });
    }else
    {
        filas.forEach(fila => {
            let id = fila.querySelector("td").textContent.toLowerCase();
            if (id.includes(input)) {
                fila.style.display = "";
            }
        });
    }
}
