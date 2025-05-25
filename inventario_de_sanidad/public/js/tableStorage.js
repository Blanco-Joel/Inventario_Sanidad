if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

var allData = [];
var currentLimit = 10;
var paginaActual = 0;   

async function inicio() {
    while (typeof window.STORAGEDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader()

    allData = window.STORAGEDATA;
    paginaActual = 0;

    document.getElementById("buscarId").addEventListener("keyup", filtrarTabla);

    document.getElementsByName("filtro").forEach(radio => {
        radio.addEventListener("change", filtrarTabla);
    });

    document.getElementsByName("regs").forEach(radio => {
        radio.addEventListener("change", event => {
            currentLimit = parseInt(event.target.value);
            paginaActual = 0;
            renderTable(currentLimit);
        });
    });

    renderTable(currentLimit);
}

function filtrarTabla() {
    paginaActual = 0;
    renderTable(currentLimit);
}

function renderTable(limit) {
    let tbody = document.querySelector("table tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro();
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
        let btnEditar = document.createElement("input");
        btnEditar.type = "submit";
        btnEditar.value = "Editar";
        btnEditar.className = "btn btn-primary";
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
            tr.appendChild(crearDataLabel(crearTD("reserva"),"Tipo"));
            tr.appendChild(crearDataLabel(crearTD(reserve.units ?? "-"),"Cantidad"));
            tr.appendChild(crearDataLabel(crearTD(reserve.min_units ?? "-"),"Cantidad mínima"));
            tr.appendChild(crearDataLabel(crearTD(reserve.cabinet ?? "-"),"Armario"));
            tr.appendChild(crearDataLabel(crearTD(reserve.shelf ?? "-"),"Balda"));
            tr.appendChild(crearDataLabel(crearTD(reserve.drawer ?? "-"),"Cajón"));

        }
        tbody.appendChild(tr);
    });

    renderPaginationButtons(filtrados.length, limit);
}

function crearTD(texto) {
    let td = document.createElement("td");
    td.textContent = texto;
    return td;
}
function crearDataLabel(td,label) {
    td.setAttribute("data-label",label);
    return td;
}

function aplicarFiltro() {
    let input = document.getElementById("buscarId").value.trim().toLowerCase();
    if (input === "") return allData;

    let filtro = document.querySelector('input[name="filtro"]:checked');
    let campos = ["name", "description", "units", "min_units", "cabinet", "shelf","drawer"];
    let campo = filtro ? campos[parseInt(filtro.value) - 1] : "name";

    return allData.filter(item => {
        let valor = item[campo];
        return valor && valor.toString().toLowerCase().includes(input);
    });
}

function renderPaginationButtons(total, limit) {
    let paginacion = document.getElementById("paginacion");
    if (!paginacion) return;

    while (paginacion.firstChild) paginacion.removeChild(paginacion.firstChild);

    let totalPaginas = Math.ceil(total / limit);
    for (let i = 0; i < totalPaginas; i++) {
        let btn = document.createElement("button");
        btn.textContent = i + 1;
        if (i === paginaActual) btn.classList.add("active");

        btn.addEventListener("click", () => {
            paginaActual = i;
            renderTable(currentLimit);
        });

        paginacion.appendChild(btn);
    }
}
function getEditUrl(id) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/update/${id}/edit` : `/storages/update/${id}/teacher/edit`;
}