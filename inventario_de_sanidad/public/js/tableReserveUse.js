if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

async function inicio() {
    initViewToggle();

    while (typeof window.HISTORICALDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader();
    allData = window.HISTORICALDATA;
    paginaActual = 0;
    
    initLoad();

    renderTable(currentLimit,paginaActual);
    renderTableCards(currentLimit,paginaActual);
}

function initViewToggle(){
  const cardViewBtn = document.getElementById('cardViewBtn');
  const tableViewBtn = document.getElementById('tableViewBtn');
  const cardView = document.getElementById('cardView');
  const tableView = document.getElementById('tableView');
  const searchInput = document.querySelector('.search-input');

  function activateCardView() {
      cardView.style.display = 'grid';
      tableView.style.display = 'none';
      cardViewBtn.classList.add('active');
      tableViewBtn.classList.remove('active');
  }

  function activateTableView() {
      cardView.style.display = 'none';
      tableView.style.display = 'block';
      tableViewBtn.classList.add('active');
      cardViewBtn.classList.remove('active');
  }

  cardViewBtn.addEventListener('click', (e) => {
      e.preventDefault();
      activateCardView();
  });

  tableViewBtn.addEventListener('click', (e) => {
      e.preventDefault();
      activateTableView();
  });

  // Filtro en tiempo real


  activateCardView();
}

function renderTableCards(limit,paginaActual) {
    let container = document.querySelector("#cardView");
    if (!container) return;
    while (container.firstChild) container.removeChild(container.firstChild);

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

function renderTable(limit,paginaActual) {
    let tbody = document.querySelector("table tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro(["name", "description", "cabinet", "shelf", "units", "min_units"]);
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

function getEditUrl(id) {
    let isAdmin = document.querySelector(".user-role").textContent.includes("admin");
    return isAdmin ? `/storages/update/${id}/edit` : `/storages/update/teacher/${id}/edit`;
}