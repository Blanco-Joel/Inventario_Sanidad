if (document.addEventListener)
    window.addEventListener("load",inicio)
else if (document.attachEvent)
    window.attachEvent("onload",inicio);
    

function inicio(){
    let nameLine = document.getElementById("name");

    let firstLogName ="firstLog"+ nameLine.textContent.split(":")[1].trim();
    let allCookies=document.cookie.split("; ");
    let index=0;
    let inexiste = true;
    while (inexiste && index < allCookies.length){
        if (allCookies[index].startsWith(firstLogName))
            inexiste=false;
        
        index+=1;
    }  
    if (inexiste) 
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

    
    console.log(inputs[2].value);
    console.log(inputs[1].value);
    if (inputs[2].value == inputs[1].value) {
        
        let nameLine = document.getElementById("name");
        let date = new Date();
        
        document.cookie ="firstLog"+ nameLine.textContent.split(":")[1].trim() +"=true"+ ";expires=" +(date.setTime(date.getTime() + (366 * 24 * 60 * 60 * 1000)))+";path=/";
        e.target.submit();  
        cerrarDialog(dialog);
    }else
    {
        let error = document.getElementById("error");
        console.log(error);
        error.textContent = "Las contraseñas no coincdiden.";
    }
    
}

function cerrarDialog(dialog) 
{
    dialog.removeAttribute("open");
}