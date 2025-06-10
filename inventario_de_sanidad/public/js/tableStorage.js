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

    let filtrados = aplicarFiltro(["storage","name", "description", "units", "min_units", "cabinet", "shelf", "drawer"]);
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach(item => {
        let useCAE = item.storage.find(s => s.storage_type === 'use' && s.storage === "CAE") || {};
        let reserveCAE = item.storage.find(s => s.storage_type === 'reserve' && s.storage === "CAE") || {};
        let useOd = item.storage.find(s => s.storage_type === 'use' && s.storage === "odontology") || {};
        let reserveOd = item.storage.find(s => s.storage_type === 'reserve' && s.storage === "odontology") || {};
        let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
        console.log(isNaN(reserveOd.material_id));
        // tr: Nombre del material
        let trMaterial = document.createElement("tr");
        let tdMaterial = crearTD(item.name ?? "-");
        tdMaterial.colSpan = 8;
        tdMaterial.classList.add("material-title");
        trMaterial.appendChild(tdMaterial);
        tbody.appendChild(trMaterial);
        if (!isNaN(useCAE.material_id) ||  !isNaN(reserveCAE.material_id) ) {

            // tr: Uso
            let trUsoCAE = document.createElement("tr");

            trUsoCAE.appendChild(crearDataLabel(crearTD("CAE"), "Localizacíon"));
            trUsoCAE.appendChild(crearDataLabel(crearTD("uso"), "Tipo"));
            trUsoCAE.appendChild(crearDataLabel(crearTD(useCAE.units ?? "0"), "Cantidad"));
            trUsoCAE.appendChild(crearDataLabel(crearTD(useCAE.min_units ?? "0"), "Cantidad mínima"));
            trUsoCAE.appendChild(crearDataLabel(crearTD(useCAE.cabinet ?? "0"), "Armario"));
            trUsoCAE.appendChild(crearDataLabel(crearTD(useCAE.shelf ?? "0"), "Balda"));
            trUsoCAE.appendChild(crearDataLabel(crearTD(useCAE.drawer ?? "0"), "Cajón"));
            if (!isAdmin) {
                let tdAcciones = crearAccionesTd(item.material_id,"CAE");
                trUsoCAE.appendChild(tdAcciones);
            }
            tbody.appendChild(trUsoCAE);

            // tr: Reserva (solo admin)
            if (isAdmin) {
                let trReservaCAE = document.createElement("tr");
                trReservaCAE.appendChild(crearDataLabel(crearTD("reserva"), "Tipo"));
                trReservaCAE.appendChild(crearDataLabel(crearTD(reserveCAE.units ?? "0"), "Cantidad"));
                trReservaCAE.appendChild(crearDataLabel(crearTD(reserveCAE.min_units ?? "0"), "Cantidad mínima"));
                trReservaCAE.appendChild(crearDataLabel(crearTD(reserveCAE.cabinet ?? "0"), "Armario"));
                trReservaCAE.appendChild(crearDataLabel(crearTD(reserveCAE.shelf ?? "0"), "Balda"));
                trReservaCAE.appendChild(crearDataLabel(crearTD(reserveCAE.drawer ?? "0"), "Cajón"));

                let tdAcciones = crearAccionesTd(item.material_id,"CAE");
                trReservaCAE.appendChild(tdAcciones);

                tbody.appendChild(trReservaCAE);
            }
        }
        if (!isNaN(useOd.material_id) ||  !isNaN(reserveOd.material_id) ) {
            
            // tr: Uso
            let trUsoOd = document.createElement("tr");
            trUsoOd.appendChild(crearDataLabel(crearTD("Odontología"), "Localizacíon"));
            trUsoOd.appendChild(crearDataLabel(crearTD("uso"), "Tipo"));
            trUsoOd.appendChild(crearDataLabel(crearTD(useOd.units ?? "0"), "Cantidad"));
            trUsoOd.appendChild(crearDataLabel(crearTD(useOd.min_units ?? "0"), "Cantidad mínima"));
            trUsoOd.appendChild(crearDataLabel(crearTD(useOd.cabinet ?? "0"), "Armario"));
            trUsoOd.appendChild(crearDataLabel(crearTD(useOd.shelf ?? "0"), "Balda"));
            trUsoOd.appendChild(crearDataLabel(crearTD(useOd.drawer ?? "0"), "Cajón"));
            if (!isAdmin) {
                let tdAcciones = crearAccionesTd(item.material_id,"odontology");
                trUsoOd.appendChild(tdAcciones);
            }
            tbody.appendChild(trUsoOd);

            // tr: Reserva (solo admin)
            if (isAdmin) {
                let trReservaOd = document.createElement("tr");
                trReservaOd.appendChild(crearDataLabel(crearTD("reserva"), "Tipo"));
                trReservaOd.appendChild(crearDataLabel(crearTD(reserveOd.units ?? "0"), "Cantidad"));
                trReservaOd.appendChild(crearDataLabel(crearTD(reserveOd.min_units ?? "0"), "Cantidad mínima"));
                trReservaOd.appendChild(crearDataLabel(crearTD(reserveOd.cabinet ?? "0"), "Armario"));
                trReservaOd.appendChild(crearDataLabel(crearTD(reserveOd.shelf ?? "0"), "Balda"));
                trReservaOd.appendChild(crearDataLabel(crearTD(reserveOd.drawer ?? "0"), "Cajón"));
                
                let tdAcciones = crearAccionesTd(item.material_id,"odontology");
                trReservaOd.appendChild(tdAcciones);

                tbody.appendChild(trReservaOd);
        }
        }
    });

    renderPaginationButtons(filtrados.length, limit);
}


function crearAccionesTd(id,storage) {
    let tdAcciones = document.createElement("td");
    tdAcciones.classList.add("acciones");

    let btnEditar = document.createElement("button");
    btnEditar.type = "submit";
    btnEditar.style.cssText = "background: none; border: none; cursor: pointer;";

    let iconEdit = document.createElement("i");
    iconEdit.classList.add("fa", "fa-pencil");
    btnEditar.appendChild(iconEdit);

    btnEditar.onclick = () => {
        window.location.href = getEditUrl(id,storage);
    };

    tdAcciones.appendChild(btnEditar);
    return tdAcciones;
}

function getEditUrl(id,storage) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/update/${id}/${storage}/edit` : `/storages/update/${id}/${storage}/teacher/edit`;
}