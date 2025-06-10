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
            console.log(botonesBaja);

        for (let btn of botonesBaja) {
            if (document.addEventListener){
                btn.addEventListener("submit", mostrarDialogConfirmacion);
            }else if (document.attachEvent){
                btn.attachEvent("onsubmit", mostrarDialogConfirmacion);
            }
        }
    }



