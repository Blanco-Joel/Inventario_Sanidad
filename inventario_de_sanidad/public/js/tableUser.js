if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);



async function inicio () {
    while (typeof window.USERDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }
    hideLoader();
    currentLimit = 10;
    paginaActual = 0;
    allData = window.USERDATA;

    document.getElementById("buscarId").addEventListener("keyup", filtrarTabla);
    document.getElementsByName("filtro").forEach(
        radio => {
            radio.addEventListener("change", filtrarTabla);
        }
    );

    document.getElementsByName("regs").forEach(
        radio => {
            radio.addEventListener("change", event => {
                currentLimit = parseInt(event.target.value);
                paginaActual = 0;
                renderTable(currentLimit);
            });
        }
    );

    renderTable(currentLimit);
}


function filtrarTabla(event) {
    if (event.target.type == "radio" || event.target.type == "text" && (event.key.length == 1 || event.key == "Backspace" || event.key == "Delete")) {
        renderTable(currentLimit);
    }
}

function renderTable(limit) {
    let tbody = document.querySelector("#tabla-usuarios tbody");
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    let filtrados = aplicarFiltro();
    let inicio = paginaActual * limit;
    let fin = inicio + limit;
    let datosPagina = filtrados.slice(inicio, fin);

    datosPagina.forEach((usuario) => {
        let tr = document.createElement("tr");

        tr.appendChild(crearDataLabel(crearTD(usuario.first_name),"Nombre"));
        tr.appendChild(crearDataLabel(crearTD(usuario.last_name),"Apellidos"));
        tr.appendChild(crearDataLabel(crearTD(usuario.email),"Email"));
        tr.appendChild(crearDataLabel(crearTD(usuario.user_type),"Tipo de usuario"));
        tr.appendChild(crearDataLabel(crearTD(usuario.created_at),"Fecha de alta"));

        let tdVer = document.createElement("td");
        let formVer = document.createElement("form");
        formVer.id = `btn-ver-${usuario.user_id}`;
        let b = document.createElement("b");
        b.textContent = "************";
        let btnVer = document.createElement("button");
        btnVer.type = "submit";
        btnVer.style.cssText = "background: none; border: none; cursor: pointer;";
        let iconEye = document.createElement("i");
        iconEye.classList.add("fa", "fa-eye");
        btnVer.appendChild(iconEye);
        formVer.appendChild(b);
        formVer.appendChild(btnVer);
        tdVer.appendChild(formVer);
        tr.appendChild(crearDataLabel(tdVer,"Acciones"));

        let tdDel = document.createElement("td");
        if ((usuario.first_name + " " + usuario.last_name) != document.getElementsByClassName("user-name")[0].textContent) {
            let formDel = document.createElement("form");
            formDel.method = "POST";
            formDel.action = "/users/baja";
            formDel.id = `btn-delete-${usuario.user_id}`;

            let token = document.createElement("input");
            token.type = "hidden";
            token.name = "_token";
            token.value = getCSRFToken();

            let hiddenId = document.createElement("input");
            hiddenId.type = "hidden";
            hiddenId.name = "user_id";
            hiddenId.value = usuario.user_id;

            let btn = document.createElement("button");
            btn.type = "submit";
            btn.style.cssText = "background: none; border: none; cursor: pointer;";
            let icon = document.createElement("i");
            icon.classList.add("fa", "fa-trash");

            btn.appendChild(icon);
            formDel.appendChild(token);
            formDel.appendChild(hiddenId);
            formDel.appendChild(btn);
            tdDel.appendChild(formDel);
        }

        tr.appendChild(tdDel);
        tbody.appendChild(tr);
    });

    renderPaginationButtons(filtrados.length, limit);
    rebindDynamicEvents();
}

// function formatearFecha(fechaISO) {
//     let fecha = new Date(fechaISO);

//     let dia = String(fecha.getDate()).padStart(2, '0');
//     let mes = String(fecha.getMonth() + 1).padStart(2, '0');
//     let anio = fecha.getFullYear();

//     let horas = String(fecha.getHours()).padStart(2, '0');
//     let minutos = String(fecha.getMinutes()).padStart(2, '0');
//     let segundos = String(fecha.getSeconds()).padStart(2, '0');

//     return `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
// }

function crearTD(texto) {
    let td = document.createElement("td");
    td.textContent = texto;
    return td;
}
function crearDataLabel(td,label) {
    td.setAttribute("data-label",label);
    return td;
}

function renderPaginationButtons(total, limit) {
    let paginacion = document.getElementById("paginacion");
    if (!paginacion) {
        paginacion = document.createElement("div");
        paginacion.id = "paginacion";
        document.querySelector("#tab2").appendChild(paginacion);
    }
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

function aplicarFiltro() {
    let input = document.getElementById("buscarId").value.toLowerCase();
    let filtro = document.querySelector('input[name="filtro"]:checked').value;
    let campos = ["first_name", "last_name", "email", "user_type", "updated_at", "created_at"];
    let campo = campos[parseInt(filtro) - 1];

    return allData.filter(u => {
        return u[campo] && u[campo].toLowerCase().includes(input);
    });
}

function rebindDynamicEvents() {
    document.querySelectorAll("[id^='btn-ver-']").forEach(form => {
        form.addEventListener("submit", showPassword);
    });

    document.querySelectorAll("[id^='btn-delete-']").forEach(form => {
        form.addEventListener("submit", mostrarDialogConfirmacion);
    });
}

function getCSRFToken() {
    let tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") : "";
}
