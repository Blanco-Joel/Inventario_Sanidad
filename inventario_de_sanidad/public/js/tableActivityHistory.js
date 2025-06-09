if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

async function inicio() {
    while (typeof window.ACTIVITYDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    allData = window.ACTIVITYDATA;
    console.log(allData);

    hideLoader();
    paginaActual = 0;
    currentLimit = parseInt(document.getElementById("regsPorPagina").value);

    renderActivityCards(currentLimit, paginaActual);

    document.getElementById("regsPorPagina").addEventListener("change", event => {
        currentLimit = parseInt(event.target.value);
        paginaActual = 0;
        renderActivityCards(currentLimit, paginaActual);
    });
}

function renderActivityCards(limit, paginaActual) {
    const container = document.querySelector("#activityCardContainer");
    if (!container) return;

    while (container.firstChild) container.removeChild(container.firstChild);

    const inicio = paginaActual * limit;
    const fin = inicio + limit;
    const datosPagina = allData.slice(inicio, fin);

    datosPagina.forEach(activity => {
        container.appendChild(crearActivityCard(activity));
    });

    renderPaginationButtons(allData.length, limit);
}

function crearActivityCard(activity) {
    const card = document.createElement("div");
    card.className = "activity-card";

    // Header con fecha
    const header = document.createElement("div");
    header.className = "activity-header";
    const fecha = new Date(activity.created_at);
    header.textContent = fecha.toLocaleDateString('es-ES') + ' ' + fecha.toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
    });
    card.appendChild(header);

    const content = document.createElement("div");

    const pDesc = document.createElement("p");
    const strong = document.createElement("strong");
    strong.textContent = "Descripción:";
    pDesc.appendChild(strong);
    pDesc.appendChild(document.createTextNode(" " + (activity.title ?? "-")));
    content.appendChild(pDesc);

    if (!activity.materials || activity.materials.length === 0) {
        const pEmpty = document.createElement("p");
        const em = document.createElement("em");
        em.textContent = "No se usaron materiales.";
        pEmpty.appendChild(em);
        content.appendChild(pEmpty);
    } else {
        const wrapper = document.createElement("div");
        wrapper.className = "table-wrapper";

        const table = document.createElement("table");
        table.className = "table activity-table";

        const thead = document.createElement("thead");
        const trHead = document.createElement("tr");
        ["Material", "Cantidad"].forEach(text => {
            const th = document.createElement("th");
            th.textContent = text;
            trHead.appendChild(th);
        });
        thead.appendChild(trHead);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");
        activity.materials.forEach(material => {
            const tr = document.createElement("tr");
            const tdMaterial = crearTD(material.name ?? "-");
            crearDataLabel(tdMaterial, "Material");
            const tdCantidad = crearTD(material.pivot.units ?? "-");
            crearDataLabel(tdCantidad, "Cantidad");
            tr.appendChild(tdMaterial);
            tr.appendChild(tdCantidad);
            tbody.appendChild(tr);
        });
        table.appendChild(tbody);

        wrapper.appendChild(table);
        content.appendChild(wrapper);
    }

    card.appendChild(content);
    return card;
}
