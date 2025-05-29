if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

var allData = [];
var currentLimit = 5;
var paginaActual = 0;   

async function inicio() {
    while (typeof window.MODIFICATIONSDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader();

    allData = window.MODIFICATIONSDATA;
    paginaActual = 0;

    document.getElementById("buscarId").addEventListener("keyup", filtrarTabla);

    document.getElementsByName("filtro").forEach(radio => {
        radio.addEventListener("change", filtrarTabla);
    });

    document.getElementById("regsPorPagina").addEventListener("change", event => {
        currentLimit = parseInt(event.target.value);
        paginaActual = 0;
        renderTable(currentLimit);
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
    let campos = ["first_name", "last_name", "email", "user_type", "action_datetime", "material_name","units","storage_type"];
    let campo = filtro ? campos[parseInt(filtro.value) - 1] : "name";

    return allData.filter(item => {
        let valor = item[campo];
        return valor && valor.toString().toLowerCase().includes(input);
    });
}


function renderPaginationButtons(total, limit) {
    let pagContainer = document.querySelector(".pagination-buttons");
    if (!pagContainer) return;
    pagContainer.innerHTML = "";
  
    let totalPages = Math.ceil(total / limit);
    let startIdx = paginaActual * limit + 1;
    let endIdx = Math.min((paginaActual + 1) * limit, total);
  
    // 1. Texto resumen
    let summary = document.createElement("span");
    summary.classList.add("pagination-summary");
    summary.textContent = startIdx +  " – "+ endIdx+ " de "+ total;
    pagContainer.appendChild(summary);
  
    // Helper para crear botón
    let makeBtn = (text, targetPage, disabled) => {
      let btn = document.createElement("button");
      btn.textContent = text;
      if (disabled) {
        btn.disabled = true;
      } else {
        btn.addEventListener("click", () => {
          paginaActual = targetPage;
          renderTable(currentLimit);
          renderTableCards(currentLimit);
        });
      }
      return btn;
    };
  
    // 2. Botones de navegación
    // « Primero
    pagContainer.appendChild(
      makeBtn("«", 0, paginaActual === 0)
    );
    // ‹ Anterior
    pagContainer.appendChild(
      makeBtn("‹", paginaActual - 1, paginaActual === 0)
    );
    // › Siguiente
    pagContainer.appendChild(
      makeBtn("›", paginaActual + 1, paginaActual >= totalPages - 1)
    );
    // » Último
    pagContainer.appendChild(
      makeBtn("»", totalPages - 1, paginaActual >= totalPages - 1)
    );
  }

