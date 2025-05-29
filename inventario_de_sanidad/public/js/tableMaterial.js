if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

var allData = [];
var currentLimit = 5;
var paginaActual = 0;   

async function inicio() {
    while (typeof window.MATERIALDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader()

    allData = window.MATERIALDATA;
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
        tr.appendChild(crearDataLabel(crearTD(item.name ?? "-"),"Material")); 
        tr.appendChild(crearDataLabel(crearTD(item.description ?? "-"),"Cantidad mínima"));
        let td = document.createElement("td");
        let img = document.createElement("img");
        img.src = new URL('/storage/', window.location).href + (item.image_path ?? "no_image.jpg");
        img.style.maxWidth = "100px";
        td.appendChild(img);

        tr.appendChild(td);

          let tdAc = document.createElement("td");
            let formAc = document.createElement("form");
            formAc.method = "GET";
            formAc.action = `/materials/${item.material_id}/edit`;
            formAc.id = `btn-delete-${item.material_id}`;

            let tokenAc = document.createElement("input");
            tokenAc.type = "hidden";
            tokenAc.name = "_token";
            tokenAc.value = getCSRFToken();

            let hiddenIdAc = document.createElement("input");
            hiddenIdAc.type = "hidden";
            hiddenIdAc.name = "material_id";
            hiddenIdAc.value = item.material_id;

            let btnAc = document.createElement("button");
            btnAc.type = "submit";
            btnAc.className = "btn btn-primary";

              btnAc.textContent = "Editar";

            formAc.appendChild(tokenAc);
            formAc.appendChild(hiddenIdAc);
            formAc.appendChild(btnAc);
            tdAc.appendChild(formAc);
        


        tr.appendChild(tdAc);
            let tdDel = document.createElement("td");
            let formDel = document.createElement("form");
            formDel.method = "POST";
            formDel.action = `/materials/${item.material_id}/destroy`;
            formDel.id = `btn-delete-${item.material_id}`;

            // let token = document.createElement("input");
            // token.type = "hidden";
            // token.name = "_token";
            // token.value = getCSRFToken();

            // let hiddenId = document.createElement("input");
            // hiddenId.type = "hidden";
            // hiddenId.name = "material_id";
            // hiddenId.value = item.material_id;

            let btn = document.createElement("button");
            btn.type = "submit";
            btn.className = "btn btn-danger";

            btn.textContent = "Eliminar";

            // formDel.appendChild(token);
            // formDel.appendChild(hiddenId);
            formDel.appendChild(btn);
            tdDel.appendChild(formDel);
        

        tr.appendChild(tdDel);

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
    let pagContainer = document.querySelector(".pagination-buttons");
    if (!pagContainer) return;
    pagContainer.innerHTML = "";
  
    let totalPages = Math.ceil(total / limit);
    let startIdx = paginaActual * limit + 1;
    let endIdx = Math.min((paginaActual + 1) * limit, total);
  
    // 1. Texto resumen
    let summary = document.createElement("span");
    summary.classList.add("pagination-summary");
    summary.textContent = startIdx +  " – "+ endIdx+ " of "+ total;
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

function getCSRFToken() {
    let tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") : "";
}
