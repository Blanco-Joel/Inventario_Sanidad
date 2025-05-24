if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

var allData = [];
var currentLimit = 10;
var paginaActual = 0;   

async function inicio() {
    while (typeof window.MODIFICATIONSDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    allData = window.MODIFICATIONSDATA;
    paginaActual = 0;
    console.log(allData)

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
        let tr = document.createElement("tr");
        tr.appendChild(crearTD(item.first_name ?? "-"));
        tr.appendChild(crearTD(item.last_name ?? "-"));
        tr.appendChild(crearTD(item.email ?? "-"));
        tr.appendChild(crearTD(item.user_type ?? "-"));
        tr.appendChild(crearTD(item.material_name ?? "-"));
        tr.appendChild(crearTD(item.units ?? "-"));
        tr.appendChild(crearTD(item.storage_type == "reserve" ? "reserva" : "uso"));
        tr.appendChild(crearTD(item.action_datetime ?? "-"));
        tbody.appendChild(tr);

    });

    renderPaginationButtons(filtrados.length, limit);
}

function crearTD(texto) {
    let td = document.createElement("td");
    td.textContent = texto;
    return td;
}

function aplicarFiltro() {
    let input = document.getElementById("buscarId").value.trim().toLowerCase();
    if (input === "") return allData;

    let filtro = document.querySelector('input[name="filtro"]:checked');
    let campos = ["first_name", "last_name", "email", "user_type", "action_datetime", "material_name","units","storage_type"];
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
    return isAdmin ? `/storages/update/${id}/edit` : `/storages/update/teacher/${id}/edit`;
}