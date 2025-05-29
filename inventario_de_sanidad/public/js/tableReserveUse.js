if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

var allData = [];
var currentLimit = 5;
var paginaActual = 0;   

async function inicio() {
    while (typeof window.HISTORICALDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader();
    
    allData = window.HISTORICALDATA;
    paginaActual = 0;
    console.log(HISTORICALDATA)
    document.getElementById("buscarId").addEventListener("keyup", filtrarTabla);

    document.getElementsByName("filtro").forEach(radio => {
        radio.addEventListener("change", filtrarTabla);
    });

    document.getElementById("regsPorPagina").addEventListener("change", event => {
        currentLimit = parseInt(event.target.value);
        paginaActual = 0;
        renderTable(currentLimit);
        renderTableCards(currentLimit);

    });

    renderTable(currentLimit);
    renderTableCards(currentLimit);

}

function filtrarTabla() {
    paginaActual = 0;
    renderTable(currentLimit);
    renderTableCards(currentLimit);
}
function renderTableCards(limit) {
    let container = document.querySelector("#cardView");
    if (!container) return;

    container.innerHTML = ""; // Limpia las tarjetas actuales

    let filtrados = aplicarFiltro();
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach(material => {
        container.appendChild(crearMaterialCard(material));
    });

    renderPaginationButtons(filtrados.length, limit);
}
function crearMaterialCard(material) {
    let card = document.createElement("div");
    card.className = "material-card";

    let img = document.createElement("img");
    img.src = material.image_path ? `/storage/${material.image_path}` : "/storage/no_image.jpg";
    img.alt = material.name ?? "Sin nombre";
    card.appendChild(img);

    let body = document.createElement("div");
    body.className = "material-card-body";

    let h5 = document.createElement("h5");
    h5.textContent = material.name ?? "-";
    body.appendChild(h5);

    let p = document.createElement("p");
    p.textContent = material.description ?? "-";
    body.appendChild(p);

    let ul = document.createElement("ul");
    ul.appendChild(crearLi("Armario", material.cabinet));
    ul.appendChild(crearLi("Balda", material.shelf));
    ul.appendChild(crearLi("Unidades", material.units));
    ul.appendChild(crearLi("Mínimo", material.min_units));
    body.appendChild(ul);

    card.appendChild(body);
    return card;

  }
  function crearLi(label, valor) {
    let li = document.createElement("li");
    let strong = document.createElement("strong");
    strong.textContent = `${label}: `;
    li.appendChild(strong);
    li.appendChild(document.createTextNode(valor ?? "-"));
    return li;
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
        let td = document.createElement("td");
        let img = document.createElement("img");
        img.src = new URL('/storage/', window.location).href + (item.image_path ?? "no_image.jpg");
        img.style.maxWidth = "100px";
        td.appendChild(img);
        tr.appendChild(td);

        tr.appendChild(crearDataLabel((crearTD(item.name ?? "-")),"Nombre"));
        tr.appendChild(crearDataLabel((crearTD(item.description ?? "-")),"Descripción"));
        tr.appendChild(crearDataLabel((crearTD(item.cabinet ?? "-")),"Armario"));
        tr.appendChild(crearDataLabel((crearTD(item.shelf ?? "-")),"Balda"));
        tr.appendChild(crearDataLabel((crearTD(item.units ?? "-")),"Unidades"));
        tr.appendChild(crearDataLabel((crearTD(item.min_units ?? "-")),"Mínimo"));
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
    let campos = ["name", "description", "cabinet", "shelf", "units", "min_units"];
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
function getEditUrl(id) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/update/${id}/edit` : `/storages/update/teacher/${id}/edit`;
}