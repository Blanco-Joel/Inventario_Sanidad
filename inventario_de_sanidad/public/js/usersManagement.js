    if (document.addEventListener)
        window.addEventListener("load",inicio)
    else if (document.attachEvent)
        window.attachEvent("onload",inicio);
        
    async function userDataRetrieve() {
        const response = await fetch('/users/usersManagementData');
        window.USERDATA = await response.json();

    }
    function inicio(){
        
        userDataRetrieve();
        let botonesVer = document.querySelectorAll("[id^='btn-ver-']") 
        let botonesBaja = document.querySelectorAll("[id^='btn-delete-']") 

        
        for (let btn of botonesVer) {
            if (document.addEventListener){
                btn.addEventListener("submit", mostrarDialogConfirmacion);
            }else if (document.attachEvent){
                btn.attachEvent("onsubmit", mostrarDialogConfirmacion);
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
        let botonConfirmar
        let botonCancelar
        let dialog
        if (event.target.id.split("-")[1] == "ver") {
            botonConfirmar  = document.getElementById("aceptarContra");
            botonCancelar = document.getElementById("cancelarContra");
            dialog = document.getElementById("confirmacionContra");       
        } else
        {
            botonConfirmar  = document.getElementById("aceptar");
            botonCancelar = document.getElementById("cancelar");
            dialog = document.getElementById("confirmacion");
        }
        dialog.setAttribute("open", "true");


        // Esperamos a que el usuario confirme o cancele
        botonConfirmar.onclick = () => {
            event.target.submit(); // Envía el formulario manualmente
            cerrarDialog(dialog);
        };

        botonCancelar.onclick = () => {
            cerrarDialog(dialog);
        };
    }

    function cerrarDialog(dialog) 
    {
        dialog.removeAttribute("open");
        
    }

