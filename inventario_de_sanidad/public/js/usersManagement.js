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
        // let formBaja = document.getElementById("registrar");
        let botonesVer = document.querySelectorAll("[id^='btn-ver-']") 
        let botonesBaja = document.querySelectorAll("[id^='btn-delete-']") 

        
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

