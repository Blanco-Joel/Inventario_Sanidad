if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);


async function inicio() {
    while (typeof window.MODIFICATIONSDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader();

    allData = window.MODIFICATIONSDATA;
    paginaActual = 0;

    initLoad();

    renderTable(currentLimit,paginaActual);
}

function renderTable(limit,paginaActual) {
    let tbody = document.querySelector("table tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro(["first_name", "last_name", "email", "user_type", "action_datetime", "material_name","units","storage_type"]);
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach(item => {
        let tr = document.createElement("tr");
        tr.appendChild(crearDataLabel((crearTD(item.first_name ?? "-")),"Nombre"));
        tr.appendChild(crearDataLabel((crearTD(item.last_name ?? "-")),"Apellidos"));
        tr.appendChild(crearDataLabel((crearTD(item.email ?? "-")),"Email"));
        tr.appendChild(crearDataLabel((crearTD(item.user_type ?? "-")),"Tipo de usuario"));
        tr.appendChild(crearDataLabel((crearTD(item.material_name ?? "-")),"Material"));
        tr.appendChild(crearDataLabel((crearTD(item.units ?? "-")),"Unidades modificadas"));
        tr.appendChild(crearDataLabel((crearTD(item.storage_type == "reserve" ? "reserva" : "uso")),"Tipo de almacenamiento"));
        tr.appendChild(crearDataLabel((crearTD(item.action_datetime ?? "-")),"Fecha de modificación"));
        tbody.appendChild(tr);

    });

    renderPaginationButtons(filtrados.length, limit);
}


