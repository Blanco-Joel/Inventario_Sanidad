if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);
    

function inicio(){
    
    let formBaja = document.getElementById("registrar");

    
    if (document.addEventListener){
        formBaja.addEventListener("submit", mostrarDialog);
    }else if (document.attachEvent){
        formBaja.attachEvent("onsubmit", mostrarDialog);
    }
}

function mostrarDialog(e) 
{
    e.preventDefault(); // Evita que el formulario se envíe inmediatamente

    let botonConfirmar  = document.getElementById("aceptar");
    let botonCancelar = document.getElementById("cancelar");

    let dialog = document.getElementById("confirmacion");
    dialog.setAttribute("open", "true");


    // Esperamos a que el usuario confirme o cancele
    botonConfirmar.onclick = () => {
        e.target.submit(); // Envía el formulario manualmente
        cerrarDialog();
    };

    botonCancelar.onclick = () => {
        cerrarDialog();
    };
}

function cerrarDialog() 
{
    let dialog = document.getElementById("confirmacion");
    dialog.removeAttribute("open");
}