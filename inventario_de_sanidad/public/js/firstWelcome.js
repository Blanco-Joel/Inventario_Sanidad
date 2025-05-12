if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);

async function userDataRetrieve() {
    var response = await fetch('/firstLogData');
    return await response.json();
}

async function inicio(){
    var userdata =  await userDataRetrieve();
    if (!userdata["first_log"]) 
        mostrarDialogInicio();
        
    
}
function mostrarDialogInicio(e) 
{
    let dialog = document.getElementById("firstLogDialog");
    dialog.setAttribute("open", "true");

    let form = dialog.querySelector("form");
    if (document.addEventListener)
        form.addEventListener("submit",newPass)
    else if (document.attachEvent)
        form.attachEvent("onsubmit",newPass);
        
    
    
}

function newPass(e) {
    e.preventDefault();
    let inputs = e.target.getElementsByTagName("input");
    let dialog = document.getElementById("firstLogDialog");

    if (inputs[2].value == inputs[1].value) {
        e.target.submit();  
        cerrarDialog(dialog);
    }else
    {
        let error = document.getElementById("error");
        error.textContent = "Las contraseñas no coincdiden.";
    }
    
}

function cerrarDialog(dialog) 
{
    dialog.removeAttribute("open");
}