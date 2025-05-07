if (document.addEventListener) {
    window.addEventListener("load",inicio)
} else if (document.attachEvent) {
    window.attachEvent("onload",inicio);
}

function inicio() {
    let addButton = document.getElementById("addButton");
    let deleteButtons = document.getElementsByClassName("delete");

    if (document.addEventListener) {
        addButton.addEventListener("click", addMaterialDataCookie);
        for (let i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener("click", deleteMaterialDataCookie);
        }
    } else if (document.attachEvent) {
        addButton.attachEvent("onclick", addMaterialDataCookie);
        for (let i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].attachEvent("onclick", deleteMaterialDataCookie);
        }
    }

    updateTable();
}

function getCookieValue(name) {
    let cookieString = document.cookie;
    let cookies = cookieString.split(";");
    let value;
    let exist = false;
    let index = 0;

    while (!exist && index < cookies.length) {
        let cookie = cookies[index].trim();
        if (cookie.startsWith(name + '=')) {
            try {
                value = JSON.parse(decodeURIComponent(cookie.substring(name.length + 1)));
            } catch (error) {
                console.error("Error al parsear la cookie:", error);
                value = [];
            }
            exist = true;
        }
        index += 1;
    }
    return value ?? [];
}

function setCookieValue(basket) {
    let dateExpiration = new Date();
    dateExpiration.setDate(dateExpiration.getDate() + 2);
    let expiration = dateExpiration.toUTCString();
    document.cookie = "materialsBasket=" + encodeURIComponent(JSON.stringify(basket)) + "; expires=" + expiration + "; path=/";
}

function updateTable() {
    let tbody = document.querySelector("table tbody");
    let basket = getCookieValue("materialsBasket");

    while (tbody.rows.length > 1) {
        tbody.deleteRow(1);
    }

    for (let i = 0; i < basket.length; i++) {
        let newTr = document.createElement("tr");
        let nameTd = document.createElement("td");
        let unitsTd = document.createElement("td");
        let buttonTd = document.createElement("td");
        let deleteButton = document.createElement("button");

        deleteButton.setAttribute("class", "btn btn-warning delete");
        deleteButton.setAttribute("data-id", basket[i].material_id);
        deleteButton.setAttribute("type", "button");
        deleteButton.textContent = "Eliminar";

        if (document.addEventListener) {
            deleteButton.addEventListener("click", deleteMaterialDataCookie);
        } else if (document.attachEvent) {
            deleteButton.attachEvent("onclick", deleteMaterialDataCookie);
        }

        buttonTd.appendChild(deleteButton);
        unitsTd.textContent = basket[i].units;
        nameTd.textContent = basket[i].name;

        newTr.appendChild(nameTd);
        newTr.appendChild(unitsTd);
        newTr.appendChild(buttonTd);
        tbody.appendChild(newTr);
    }

    document.getElementById("materialName").value = "";
    document.getElementById("units").value = "";
    document.getElementById('materialsBasketInput').value = JSON.stringify(basket);
}

function addMaterialDataCookie() {
    let list = document.getElementById("materials");
    let options = list.getElementsByTagName("option");
    let materialName = document.getElementById("materialName").value;
    let materialUnits = document.getElementById("units").value;
    let materialId;
    let next = true;
    let index = options.length - 1;

    if (materialName != "" && materialUnits != "") {
        while (next || index >= 0) {
            if (options[index].value === materialName) {
                materialId = options[index].getAttribute("data-id");
                materialName = options[index].value;
                next = false;
            }
            index -= 1;
        }
    
        if (!materialId) {
            alert("Material no encontrado");
        } else {
            let materialData = {
                material_id: materialId,
                name: materialName,
                units: materialUnits
            };
            let basket = getCookieValue("materialsBasket");
    
            let exists = basket.some(item => item.material_id === materialId);
            if (exists) {
                alert("El material ya está añadido");
                return;
            } else {
                basket.push(materialData);
                console.log("Nuevo basket:", basket);
                setCookieValue(basket);
                updateTable();
            }
        }
    }
}

function deleteMaterialDataCookie(event) {
    let button = event.target;
    let materialId = button.getAttribute("data-id");

    if (!materialId) {
        console.error("No se encontró material_id en el botón.");
        return;
    }

    let basket = getCookieValue("materialsBasket");
    let deleted = false;
    let index = basket.length - 1;

    while (!deleted || index >= 0) {
        if (basket[index].material_id == materialId) {
            basket.splice(i, 1);
            deleted = true;
        }
        index -= 1;
    }

    let row = button.closest("tr");

    if (row && row.parentNode) {
        row.parentNode.removeChild(row);
    }

    setCookieValue(basket);
}