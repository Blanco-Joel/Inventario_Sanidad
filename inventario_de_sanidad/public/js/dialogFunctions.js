    function mostrarDialogConfirmacion(event) 
    {
        event.preventDefault();
        let botonConfirmar
        let botonCancelar
        let dialog
        console.log(event.target.id.split("-")[1])
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