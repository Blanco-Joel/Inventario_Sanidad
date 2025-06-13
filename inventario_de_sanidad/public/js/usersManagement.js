    if (document.addEventListener)
        window.addEventListener("load",inicio)
    else if (document.attachEvent)
        window.attachEvent("onload",inicio);


    async function userDataRetrieve() {
        return fetch('/users/usersManagementData')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener datos');
            }
            return response.json();
        })
        .then(data => {
            window.USERDATA = data;
            return data;
        })
        .catch(error => {
            console.error('Error en fetch:', error);
            return null;
        });

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



