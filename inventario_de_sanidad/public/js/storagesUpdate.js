if (document.addEventListener)
    window.addEventListener("load", inicio);
else if (document.attachEvent)
    window.attachEvent("onload", inicio);

let allData = [];
let currentLimit = 10;

async function updateDataRetrieve() {
    let response = await fetch('/storages/updateData');
    return await response.json();
}

async function inicio() {
    allData = await updateDataRetrieve();
    renderTable(currentLimit);

    let radios = document.getElementsByName("regs");
    radios.forEach(radio => {
        radio.addEventListener("change", () => {
            currentLimit = parseInt(radio.value);
            renderTable(currentLimit);
        });
    });
}

function renderTable(limit) {
    let tbody = document.querySelector("table tbody");
    tbody.innerHTML = ''; // Limpieza previa

    let dataToShow = allData.slice(0, limit);

    dataToShow.forEach(material => {
        let use = material.storage.find(s => s.storage_type === 'use') || {};
        let reserve = material.storage.find(s => s.storage_type === 'reserve') || {};

        // Primera fila (uso)
        let row1 = document.createElement("tr");

        let tdMaterial = document.createElement("td");
        tdMaterial.rowSpan = 2;
        tdMaterial.textContent = material.name;
        tdMaterial.setAttribute("data-label", "Material");

        let tdTipoUso = document.createElement("td");
        tdTipoUso.textContent = "Uso";
        tdTipoUso.setAttribute("data-label", "Tipo");

        let tdCantidadUso = document.createElement("td");
        tdCantidadUso.textContent = use.units ?? "-";
        tdCantidadUso.setAttribute("data-label", "Cantidad");

        let tdMinUso = document.createElement("td");
        tdMinUso.textContent = use.min_units ?? "-";
        tdMinUso.setAttribute("data-label", "Mínimo");

        let tdArmarioUso = document.createElement("td");
        tdArmarioUso.textContent = use.cabinet ?? "-";
        tdArmarioUso.setAttribute("data-label", "Armario");

        let tdBaldaUso = document.createElement("td");
        tdBaldaUso.textContent = use.shelf ?? "-";
        tdBaldaUso.setAttribute("data-label", "Balda");

        let tdAcciones = document.createElement("td");
        tdAcciones.rowSpan = 2;
        tdAcciones.setAttribute("data-label", "Acciones");

        let enlace = document.createElement("a");
        enlace.href = getEditUrl(material.id);
        enlace.className = "btn btn-outine";
        enlace.textContent = "Editar";
        tdAcciones.appendChild(enlace);

        row1.appendChild(tdMaterial);
        row1.appendChild(tdTipoUso);
        row1.appendChild(tdCantidadUso);
        row1.appendChild(tdMinUso);
        row1.appendChild(tdArmarioUso);
        row1.appendChild(tdBaldaUso);
        row1.appendChild(tdAcciones);

        // Segunda fila (reserva)
        let row2 = document.createElement("tr");

        let tdTipoReserva = document.createElement("td");
        tdTipoReserva.textContent = "Reserva";
        tdTipoReserva.setAttribute("data-label", "Tipo");

        let tdCantidadReserva = document.createElement("td");
        tdCantidadReserva.textContent = reserve.units ?? "-";
        tdCantidadReserva.setAttribute("data-label", "Cantidad");

        let tdMinReserva = document.createElement("td");
        tdMinReserva.textContent = reserve.min_units ?? "-";
        tdMinReserva.setAttribute("data-label", "Mínimo");

        let tdArmarioReserva = document.createElement("td");
        tdArmarioReserva.textContent = reserve.cabinet ?? "-";
        tdArmarioReserva.setAttribute("data-label", "Armario");

        let tdBaldaReserva = document.createElement("td");
        tdBaldaReserva.textContent = reserve.shelf ?? "-";
        tdBaldaReserva.setAttribute("data-label", "Balda");

        row2.appendChild(tdTipoReserva);
        row2.appendChild(tdCantidadReserva);
        row2.appendChild(tdMinReserva);
        row2.appendChild(tdArmarioReserva);
        row2.appendChild(tdBaldaReserva);

        // Agregamos ambas filas
        tbody.appendChild(row1);
        tbody.appendChild(row2);
    });
}

function getEditUrl(id) {
    console.log(id);
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/${id}/edit` : `/storages/teacher/${id}/edit`;
}