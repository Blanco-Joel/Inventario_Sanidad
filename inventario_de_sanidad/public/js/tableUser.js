if (document.addEventListener)
    window.addEventListener("DOMContentLoaded", inicio);
else if (document.attachEvent)
    window.attachEvent("DOMContentLoaded", inicio);



async function inicio () {
    while (typeof window.USERDATA === 'undefined') {
        await new Promise(resolve => setTimeout(resolve, 100));
    }
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

// function sortTable(columnIndex) {
//     let table = document.getElementById("tabla-usuarios");
//     let switching = true;
//     let dir = "asc";
//     let switchcount = 0;

//     while (switching) {
//         switching = false;
//         let rows = table.rows;
//         let swapIndex = -1;

//         for (let i = 1; i < (rows.length - 1); i++) {
//             let linea = rows[i].getElementsByTagName("TD")[columnIndex];
//             let lineaSiguiente = rows[i + 1].getElementsByTagName("TD")[columnIndex];

//             let lineaContent = linea.textContent.trim().toLowerCase();
//             let lineaSiguienteContent = lineaSiguiente.textContent.trim().toLowerCase();

//             if ((dir == "asc" && lineaContent > lineaSiguienteContent) ||
//                 (dir == "desc" && lineaContent < lineaSiguienteContent)) {
//                 if (swapIndex == -1) {
//                     swapIndex = i;
//                 }
//             }
//         }

//         if (swapIndex !== -1) {
//             rows[swapIndex].parentNode.insertBefore(rows[swapIndex + 1], rows[swapIndex]);
//             switching = true;
//             switchcount++;
//         } else if (switchcount == 0 && dir == "asc") {
//             dir = "desc";
//             switching = true;
//         }
//     }
// }

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

    datosPagina.forEach((usuario, index) => {
        let tr = document.createElement("tr");

        let tdNombre = crearTD(usuario.first_name);
        let tdApellidos = crearTD(usuario.last_name);
        let tdEmail = crearTD(usuario.email);
        let tdTipo = crearTD(usuario.user_type);
        let tdFecha = crearTD(usuario.created_at);

        tr.appendChild(tdNombre);
        tr.appendChild(tdApellidos);
        tr.appendChild(tdEmail);
        tr.appendChild(tdTipo);
        tr.appendChild(tdFecha);

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
        tr.appendChild(tdVer);

        let tdDel = document.createElement("td");
        if (usuario.user_id != getUserIdFromCookie()) {
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

function getUserIdFromCookie() {
    let name = "USERPASS=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
}