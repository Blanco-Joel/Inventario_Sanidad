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

function renderTable(limit, paginaActual) {
    let tbody = document.querySelector("table tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro(["name", "description", "units", "min_units", "cabinet", "shelf", "drawer"]);
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach(item => {
        let use = item.storage.find(s => s.storage_type === 'use') || {};
        let reserve = item.storage.find(s => s.storage_type === 'reserve') || {};
        const isAdmin = document.querySelector(".user-role").textContent.includes("admin");

        // tr: Nombre del material
        const trMaterial = document.createElement("tr");
        const tdMaterial = crearTD(item.name ?? "-");
        tdMaterial.colSpan = isAdmin ? 8 : 7;
        tdMaterial.classList.add("material-title");
        trMaterial.appendChild(tdMaterial);
        tbody.appendChild(trMaterial);

        // tr: Uso
        const trUso = document.createElement("tr");
        trUso.appendChild(crearDataLabel(crearTD("uso"), "Tipo"));
        trUso.appendChild(crearDataLabel(crearTD(use.units ?? "-"), "Cantidad"));
        trUso.appendChild(crearDataLabel(crearTD(use.min_units ?? "-"), "Cantidad mínima"));
        trUso.appendChild(crearDataLabel(crearTD(use.cabinet ?? "-"), "Armario"));
        trUso.appendChild(crearDataLabel(crearTD(use.shelf ?? "-"), "Balda"));
        trUso.appendChild(crearDataLabel(crearTD(use.drawer ?? "-"), "Cajón"));
        if (!isAdmin) {
            const tdAcciones = crearAccionesTd(item.material_id);
            trUso.appendChild(tdAcciones);
        }
        tbody.appendChild(trUso);

        // tr: Reserva (solo admin)
        if (isAdmin) {
            const trReserva = document.createElement("tr");
            trReserva.appendChild(crearDataLabel(crearTD("reserva"), "Tipo"));
            trReserva.appendChild(crearDataLabel(crearTD(reserve.units ?? "-"), "Cantidad"));
            trReserva.appendChild(crearDataLabel(crearTD(reserve.min_units ?? "-"), "Cantidad mínima"));
            trReserva.appendChild(crearDataLabel(crearTD(reserve.cabinet ?? "-"), "Armario"));
            trReserva.appendChild(crearDataLabel(crearTD(reserve.shelf ?? "-"), "Balda"));
            trReserva.appendChild(crearDataLabel(crearTD(reserve.drawer ?? "-"), "Cajón"));

            const tdAcciones = crearAccionesTd(item.material_id);
            trReserva.appendChild(tdAcciones);

            tbody.appendChild(trReserva);
        }
    });

    renderPaginationButtons(filtrados.length, limit);
}


function crearAccionesTd(id) {
    const tdAcciones = document.createElement("td");
    tdAcciones.classList.add("acciones");

    const btnEditar = document.createElement("button");
    btnEditar.type = "submit";
    btnEditar.style.cssText = "background: none; border: none; cursor: pointer;";

    const iconEdit = document.createElement("i");
    iconEdit.classList.add("fa", "fa-pencil");
    btnEditar.appendChild(iconEdit);

    btnEditar.onclick = () => {
        window.location.href = getEditUrl(id);
    };

    tdAcciones.appendChild(btnEditar);
    return tdAcciones;
}

function getEditUrl(id) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/update/${id}/edit` : `/storages/update/${id}/teacher/edit`;
}