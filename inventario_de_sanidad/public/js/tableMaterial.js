if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);


async function inicio() {
    while (typeof window.MATERIALDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader()

    allData = window.MATERIALDATA;
    paginaActual = 0;

    initLoad();

    renderTable(currentLimit,paginaActual);
}


function renderTable(limit,paginaActual) {
    let tbody = document.querySelector("table tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro(["name", "description", "units", "min_units", "cabinet", "shelf","drawer"]);
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

        let formToken = getHiddenToken();
        let formId = getHiddenId(item.material_id,"material_id");
        let btnAc = document.createElement("button");
        btnAc.type = "submit";
        btnAc.style.cssText = "background: none; border: none; cursor: pointer;";

        let iconEdit = document.createElement("i");
        iconEdit.classList.add("fa", "fa-pencil");
        btnAc.appendChild(iconEdit);

        formAc.appendChild(formToken);
        formAc.appendChild(formId);
        formAc.appendChild(btnAc);
        tdAc.appendChild(formAc);
        


        tr.appendChild(tdAc);
        let tdDel = document.createElement("td");
        let formDel = document.createElement("form");
        formDel.method = "POST";
        formDel.action = `/materials/${item.material_id}/destroy`;
        formDel.id = `btn-delete-${item.material_id}`;

        let token = getHiddenToken();
        let hiddenId = getHiddenId(item.material_id,"material_id");

        let btn = document.createElement("button");
        btn.type = "submit";
        btn.style.cssText = "background: none; border: none; cursor: pointer;";

        let iconTrash = document.createElement("i");
        iconTrash.classList.add("fa", "fa-trash");
        btn.appendChild(iconTrash);
        
        formDel.appendChild(token);
        formDel.appendChild(hiddenId);
        formDel.appendChild(btn);
        tdDel.appendChild(formDel);
        

        tr.appendChild(tdDel);

        tbody.appendChild(tr);
    });

    renderPaginationButtons(filtrados.length, limit);
}

