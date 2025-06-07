if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

async function inicio() {
    while (typeof window.STORAGEDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader()

    allData = window.STORAGEDATA;
    paginaActual = 0;

    initLoad();

    renderTable(currentLimit,paginaActual);
}

function renderTable(limit,paginaActual) {
    let tbody = document.querySelector("table tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro(["name", "description", "units", "min_units", "cabinet", "shelf","drawer"]);
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach(item => {
        let use = item.storage.find(s => s.storage_type === 'use') || {};
        let reserve = item.storage.find(s => s.storage_type === 'reserve') || {};
        let tr = document.createElement("tr");
        let nametd = crearDataLabel(crearTD(item.name ?? "-"),"Material"); 
        nametd.rowSpan =document.querySelector(".user-role").textContent.includes("admin") ? 2 : 1;
        tr.appendChild(nametd);
        tr.appendChild(crearDataLabel(crearTD("uso"),"Tipo"));
        tr.appendChild(crearDataLabel(crearTD(use.units ?? "-"),"Cantidad"));
        tr.appendChild(crearDataLabel(crearTD(use.min_units ?? "-"),"Cantidad mínima"));
        tr.appendChild(crearDataLabel(crearTD(use.cabinet ?? "-"),"Armario"));
        tr.appendChild(crearDataLabel(crearTD(use.shelf ?? "-"),"Balda"));
        tr.appendChild(crearDataLabel(crearTD(use.drawer ?? "-"),"Cajón"));


        let tdAcciones = document.createElement("td");
        let btnEditar = document.createElement("button");
        btnEditar.type = "submit";
        btnEditar.style.cssText = "background: none; border: none; cursor: pointer;";

        let iconEdit = document.createElement("i");
        iconEdit.classList.add("fa", "fa-pencil");
        btnEditar.appendChild(iconEdit);
        btnEditar.onclick = () => {
            window.location.href = getEditUrl(item.material_id);
        };
        tdAcciones.rowSpan = document.querySelector(".user-role").textContent.includes("admin") ? 2 : 1;

        tdAcciones.appendChild(btnEditar);
        tr.appendChild(tdAcciones);
        tbody.appendChild(tr);
        tr = document.createElement("tr");
        if (document.querySelector(".user-role").textContent.includes("admin"))
        {
            tr.appendChild((crearTD("reserva")));
            tr.appendChild((crearTD(reserve.units ?? "-")));
            tr.appendChild((crearTD(reserve.min_units ?? "-")));
            tr.appendChild((crearTD(reserve.cabinet ?? "-")));
            tr.appendChild((crearTD(reserve.shelf ?? "-")));
            tr.appendChild((crearTD(reserve.drawer ?? "-")));

        }
        tbody.appendChild(tr);
    });

    renderPaginationButtons(filtrados.length, limit);
}

function getEditUrl(id) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/update/${id}/edit` : `/storages/update/${id}/teacher/edit`;
}