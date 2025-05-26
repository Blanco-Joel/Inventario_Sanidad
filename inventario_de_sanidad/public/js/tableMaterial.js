if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);

var allData = [];
var currentLimit = 10;
var paginaActual = 0;   

async function inicio() {
    while (typeof window.MATERIALDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }

    hideLoader();

    allData = window.MATERIALDATA;
    console.log(allData);
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
        let form     = document.createElement("form");
        form.method  = "POST";
        form.action  = "http://127.0.0.1:8000/materials/"+item.material_id+"/update";
        form.enctype = "multipart/form-data";
        let token = document.createElement("input");
        token.type = "hidden";
        token.name = "_token";
        token.value = getCSRFToken();

        let hiddenId = document.createElement("input");
        hiddenId.type = "hidden";
        hiddenId.name = "user_id";
        hiddenId.value = item.material_id;
        form.appendChild(token);
        form.appendChild(hiddenId);


        let tr = document.createElement("tr");
        form.appendChild(crearDataLabel((crearTD(crearInput(item.name ?? "-","name","text"))),"Nombre"));
        form.appendChild(crearDataLabel((crearTD(crearInput(item.description ?? "-","description","text"))),"Descripción"));
        form.appendChild(crearDataLabel((crearTD(crearInput("","image","file"))),"Imagen")); 
        let tdAcciones = document.createElement("td");
        let btnEditar = document.createElement("input");
        btnEditar.type = "submit";
        btnEditar.value = "Editar";
        btnEditar.className = "btn btn-primary";

        tdAcciones.appendChild(btnEditar);
        form.appendChild(tdAcciones);
        tr.appendChild(form);

        form     = document.createElement("form");
        form.method  = "POST";
        form.action  = "http://127.0.0.1:8000/materials/"+item.material_id+"/update";
        form.enctype = "multipart/form-data";
        
        token = document.createElement("input");
        token.type = "hidden";
        token.name = "_token";
        token.value = getCSRFToken();

        hiddenId = document.createElement("input");
        hiddenId.type = "hidden";
        hiddenId.name = "user_id";
        hiddenId.value = item.material_id;

        form.appendChild(token);
        form.appendChild(hiddenId);
        let btnEliminar = document.createElement("input");
        btnEliminar.type = "submit";
        btnEliminar.value = "Eliminar";
        btnEliminar.className = "btn btn-danger";
        form.appendChild(btnEliminar);
        tr.appendChild(crearTD(form));

        tbody.appendChild(tr);

    });

    renderPaginationButtons(filtrados.length, limit);
}
function crearInput(texto,label,type) {
    let input = document.createElement("input");
    input.value = texto;
    input.name  = label;
    input.type = type;
      
    return input;
}

function crearTD(texto) {
    let td = document.createElement("td");
    td.appendChild(texto);
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

function getCSRFToken() {
    let tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") : "";
}
