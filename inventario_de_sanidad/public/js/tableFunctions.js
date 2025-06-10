let allData = [];
let currentLimit = 5;
let paginatual = 0;   

function initLoad() {
    
    document.getElementById("buscarId").addEventListener("keyup", filtrarTabla);

    document.getElementsByName("filtro").forEach(radio => {
        radio.addEventListener("change", filtrarTabla);
    });

    document.getElementById("regsPorPagina").addEventListener("change", event => {
        currentLimit = parseInt(event.target.value);
        paginatual = 0;
        
        renderTable(currentLimit,paginatual);
          let url = window.location.href.split("/");
          url = url[url.length-1];
          if (url == "use" || url == "reserve") {
            renderTableCards(currentLimit,paginatual);
          }
    });

}

function filtrarTabla() {
    paginatual = 0;
    renderTable(currentLimit,paginatual);
    let url = window.location.href.split("/");
    url = url[url.length-1];
    if (url == "use" || url == "reserve") {
      renderTableCards(currentLimit,paginatual);
    }
}

function crearTD(texto) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");

    let td = document.createElement("td");
    if (isAdmin && (texto == "CAE" ||texto == "Odontología")) {
      td.rowSpan = 2;
    }
    td.textContent = texto;
    return td;
}

function crearDataLabel(td,label) {
    td.setAttribute("data-label",label);
    return td;
}

function crearLi(label, valor) {
    let li = document.createElement("li");
    let strong = document.createElement("strong");
    strong.textContent = `${label}: `;
    li.appendChild(strong);
    li.appendChild(document.createTextNode(valor ?? "-"));
    return li;
}

function getCSRFToken() {
    let tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") : "";
}
function getHiddenToken() {
    let token = document.createElement("input");
    token.type = "hidden";
    token.name = "_token";
    token.value = getCSRFToken();
    return token;
}
function getHiddenId(param,nameId) {

    let hiddenId = document.createElement("input");
    console.log(nameId);
    hiddenId.type = "hidden";
    hiddenId.name = nameId;
    hiddenId.value = param;
    return hiddenId;

}

function aplicarFiltro(campos) {
    let input = document.getElementById("buscarId").value.trim().toLowerCase();
    if (input === "") return allData;

    let filtro = document.querySelector('input[name="filtro"]:checked');
    let campo = filtro ? campos[parseInt(filtro.value) - 1] : "name";

    return allData.filter(item => {
        let valor = item[campo];
        return valor && valor.toString().toLowerCase().includes(input);
    });
}
// ["first_name", "last_name", "email", "user_type", "tion_datetime", "material_name","units","storage_type"]

function renderPaginationButtons(total, limit) {
      console.log(limit);

    let pagContainer = document.querySelector(".pagination-buttons");
    if (!pagContainer) return;
    while (pagContainer.firstChild) pagContainer.removeChild(pagContainer.firstChild);
    
    let totalPages = Math.ceil(total / limit);
    let startIdx = paginatual * limit + 1;
    let endIdx = Math.min((paginatual + 1) * limit, total);
  
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
          
          paginatual = targetPage;
          let url = window.location.href.split("/");
          url = url[url.length-1];
          if (url != "history") {
            renderTable(currentLimit,paginatual);
            if (url == "use" || url == "reserve") {
              renderTableCards(currentLimit,paginatual);
            }
          }else
          {
            renderActivityCards(currentLimit, paginatual);
          }

        });
      }
      return btn;
    };
  
    // 2. Botones de navegión
    // « Primero
    pagContainer.appendChild(
      makeBtn("«", 0, paginatual === 0)
    );
    // ‹ Anterior
    pagContainer.appendChild(
      makeBtn("‹", paginatual - 1, paginatual === 0)
    );
    // › Siguiente
    pagContainer.appendChild(
      makeBtn("›", paginatual + 1, paginatual >= totalPages - 1)
    );
    // » Último
    pagContainer.appendChild(
      makeBtn("»", totalPages - 1, paginatual >= totalPages - 1)
    );
  }

