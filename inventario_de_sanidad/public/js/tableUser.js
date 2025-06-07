if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);



async function inicio () {
    while (typeof window.USERDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }
    hideLoader();
    currentLimit = 5;
    paginaActual = 0;
    allData = window.USERDATA;

    initLoad();

    renderTable(currentLimit,paginaActual);
}



function renderTable(limit, paginaActual) {
    let tbody = document.querySelector("#tabla-usuarios tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);
    let filtrados = aplicarFiltro(["first_name", "last_name", "email", "user_type", "updated_at", "created_at"]);
    console.log()
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach((usuario) => {
        let tr = document.createElement("tr");

        tr.appendChild(crearDataLabel(crearTD(usuario.first_name),"Nombre"));
        tr.appendChild(crearDataLabel(crearTD(usuario.last_name),"Apellidos"));
        tr.appendChild(crearDataLabel(crearTD(usuario.email),"Email"));
        tr.appendChild(crearDataLabel(crearTD(usuario.user_type),"Tipo de usuario"));
        tr.appendChild(crearDataLabel(crearTD(usuario.created_at),"Fecha de alta"));

        let tdAc = document.createElement("td");
        let formAc = document.createElement("form");
        formAc.method = "POST";
        formAc.action = "/users/management/password";
        formAc.id = `btn-ver-${usuario.user_id}`;
        
        let formToken = getHiddenToken();
        let formId = getHiddenId(usuario.user_id,"user_id");
        let btnAc = document.createElement("button");
        btnAc.type = "submit";
        btnAc.classList = "btn btn-primary";
        btnAc.textContent = "Generar contraseña"

        formAc.appendChild(formToken);
        formAc.appendChild(formId);
        formAc.appendChild(btnAc);
        tdAc.appendChild(formAc);
        


        tr.appendChild(tdAc);

        let tdDel = document.createElement("td");
        if ((usuario.first_name + " " + usuario.last_name) != document.getElementsByClassName("user-name")[0].textContent) {
            let formDel = document.createElement("form");
            formDel.method = "POST";
            formDel.action = "/users/management/delete";
            formDel.id = `btn-delete-${usuario.user_id}`;
            
            let formToken = getHiddenToken();
            let formId = getHiddenId(usuario.user_id,"user_id");
            let btn = document.createElement("button");
            btn.type = "submit";
            btn.style.cssText = "background: none; border: none; cursor: pointer;";
            let icon = document.createElement("i");
            icon.classList.add("fa", "fa-trash" );

            btn.appendChild(icon);
            formDel.appendChild(formToken);
            formDel.appendChild(formId);
            formDel.appendChild(btn);
            tdDel.appendChild(formDel);
        }

        tr.appendChild(tdDel);
        tbody.appendChild(tr);
    });

    renderPaginationButtons(filtrados.length, limit);
    rebindDynamicEvents();
}

function rebindDynamicEvents() {
    document.querySelectorAll("[id^='btn-ver-']").forEach(form => {
        form.addEventListener("submit", mostrarDialogConfirmacion);
    });

    document.querySelectorAll("[id^='btn-delete-']").forEach(form => {
        form.addEventListener("submit", mostrarDialogConfirmacion);
    });
}

function getCSRFToken() {
    let tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") : "";
}
