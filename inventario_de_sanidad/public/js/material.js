const COOKIE_NAME = "materialsAddBasket";
const storageUrl = new URL('/storage/', window.location).href;

if (document.addEventListener) {
    window.addEventListener("load",inicio)
} else if (document.attachEvent) {
    window.attachEvent("onload",inicio);
}

function inicio() {
    let addButton = document.form.add;

    if (document.addEventListener) {
        addButton.addEventListener("click", getMaterialData);
    } else if (document.attachEvent) {
        addButton.attachEvent("onclick", getMaterialData);
    }

    renderBasket();
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
                /* Parsear el valor de la cookie */
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

function setCookieValue(basket, name) {
    let dateExpiration = new Date();

    /* Definir la fecha de expiración en 2 días */
    dateExpiration.setDate(dateExpiration.getDate() + 2);

    /* Obtener la fecha de expiración en formato UTC */
    let expiration = dateExpiration.toUTCString();

    /* Guardar el valor de la cookie */
    document.cookie = name + "=" + encodeURIComponent(JSON.stringify(basket)) + "; expires=" + expiration + "; path=/";
}

function createRow(content, trElement, label) {
    let td = document.createElement("td");
    td.textContent = content;
    if (label) {
        td.setAttribute("data-label", label);
    }
    trElement.appendChild(td);
}

function renderBasket() {
    let basket = getCookieValue(COOKIE_NAME);
    let tbody = document.querySelector("table tbody");

    while (tbody.rows.length > 0) {
        tbody.deleteRow(0);
    }

    if (basket && basket.length > 0) {
        for (let i = 0; i < basket.length; i++) {
            let newTr = document.createElement("tr");

            createRow(basket[i].name, newTr, "Nombre");
            createRow(basket[i].description, newTr, "Descripción");
            createRow(basket[i].storage, newTr, "Localización");
            createRow(basket[i].use.units, newTr, "Cant. Uso");
            createRow(basket[i].use.min_units, newTr, "Mín. Uso");
            createRow(basket[i].use.cabinet, newTr, "Armario Uso");
            createRow(basket[i].use.shelf, newTr, "Balda Uso");
            createRow(basket[i].use.drawer, newTr, "Cajón Uso");
            createRow(basket[i].reserve.units, newTr, "Cant. Reserva");
            createRow(basket[i].reserve.min_units, newTr, "Mín. Reserva");
            createRow(basket[i].reserve.cabinet, newTr, "Armario Reserva");
            createRow(basket[i].reserve.shelf, newTr, "Balda Reserva");

            // Imagen
            let imageTd = document.createElement("td");
            imageTd.setAttribute("data-label", "Imagen");
            let newImg = document.createElement("img");
            newImg.className = "cell-img";
            newImg.src = storageUrl + (basket[i].image_temp || "no_image.jpg");
            newImg.alt = basket[i].name;
            imageTd.appendChild(newImg);
            newTr.appendChild(imageTd);

            // Botón eliminar
            let buttonTd = document.createElement("td");
            buttonTd.setAttribute("data-label", "Acciones");
            let newButton = document.createElement("input");
            newButton.type = "button";
            newButton.className = "btn btn-primary delete-btn";
            newButton.setAttribute("tempId", basket[i].id);
            newButton.value = "Eliminar";

            if (document.addEventListener) {
                newButton.addEventListener("click", deleteMaterialData);
            } else if (document.attachEvent) {
                newButton.attachEvent("onclick", deleteMaterialData);
            }

            buttonTd.appendChild(newButton);
            newTr.appendChild(buttonTd);

            tbody.appendChild(newTr);
        }

        document.getElementById(COOKIE_NAME).value = JSON.stringify(basket);
    }
}

async function getMaterialData(event) {
    event.target.disabled = true;
    let errors = [];
    let tempPath = null;

    let name = document.form.name.value.trim();
    if (!name) {
        errors.push("El nombre es obligatorio.");
    }

    let description = document.form.description.value.trim();
    if (!description) {
        errors.push("La descripción es obligatoria.");
    }

    let storage = document.form.storage.value;
    if (!storage) {
        errors.push("Debes seleccionar un almacenamiento.");
    }

    let units_use = document.form.units_use.value;
    if (isNaN(units_use) || units_use <= 0) {
        errors.push("La cantidad de unidades de uso debe ser un número mayor que 0.");
    }

    let min_units_use = document.form.min_units_use.value;
    if (isNaN(min_units_use) || min_units_use <= 0) {
        errors.push("La cantidad mínima de unidades de uso debe ser un número mayor que 0.");
    }

    let cabinet_use = document.form.cabinet_use.value;
    if (!cabinet_use) {
        errors.push("El armario de uso es obligatorio.");
    }

    let shelf_use = document.form.shelf_use.value;
    if (isNaN(shelf_use) || shelf_use <= 0) {
        errors.push("La balda de uso debe ser un número mayor que 0.");
    }

    let drawer = document.form.drawer.value;
    if (drawer && isNaN(parseInt(drawer, 10))) {
        errors.push("El cajón de uso debe ser un número mayor que 0.");
    }

    let units_reserve = document.form.units_reserve.value;
    if (isNaN(units_reserve) || units_reserve <= 0) {
        errors.push("La cantidad de unidades de reserva debe ser un número mayor que 0.");
    }

    let min_units_reserve = document.form.min_units_reserve.value;
    if (isNaN(min_units_reserve) || min_units_reserve <= 0) {
        errors.push("La cantidad mínima de unidades de reserva debe ser un número mayor que 0.");
    }

    let cabinet_reserve = document.form.cabinet_reserve.value.trim();
    if (!cabinet_reserve) {
        errors.push("El armario de reserva es obligatorio.");
    }

    let shelf_reserve = document.form.shelf_reserve.value;
    if (isNaN(shelf_reserve) || shelf_reserve <= 0) {
        errors.push("La balda de reserva debe ser un número mayor que 0.");
    }

    let image = document.form.image.files[0];
    if (image) {
        let validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg'];
        if (!validTypes.includes(image.type)) {
            errors.push('Formato de imagen inválido (solo JPG, PNG o GIF)');
        } else {
            tempPath = await uploadTempImage(image);
        }
    }

    if (errors.length > 0) {
        displayErrors(errors);
    } else {
        let newMaterial = {
            id: Date.now(),
            name: name,
            description: description,
            storage: storage,
            image_temp: tempPath,
            use: {
                units: units_use,
                min_units: min_units_use,
                cabinet: cabinet_use,
                shelf: shelf_use,
                drawer: drawer
            },
            reserve: {
                units: units_reserve,
                min_units: min_units_reserve,
                cabinet: cabinet_reserve,
                shelf: shelf_reserve,
                drawer: null
            }
        };

        let basket = getCookieValue(COOKIE_NAME);
        basket.push(newMaterial);
        setCookieValue(basket, COOKIE_NAME);
        renderBasket();
        console.log(basket);
        document.form.reset();
        document.getElementById("imgPreview").src = "";
        document.getElementById("file-name").textContent = "Ningún archivo seleccionado";
    }

    event.target.disabled = false;
}

function displayErrors(errors) {
    let message = "";

    if (errors.length > 0) {
        for (let i = 0; i < errors.length; i++) {
            message += "- " + errors[i] + "\n";
        }

        window.alert(message);
    }
}

async function uploadTempImage(image) {
    let formData = new FormData();
    formData.append('image', image);

    return fetch('/materials/upload-temp', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.form._token.value
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        console.log(data.tempPath);
        return data.tempPath;
    })
    .catch(error => {
        console.error('Error en la subida:', error);
        return null;
    });
}

function deleteMaterialData(event) {
    console.log("eliminar");
    let button = event.target;
    let materialId = button.getAttribute("tempId");

    if (!materialId) {
        console.error("No se encontró material_id en el botón.");
        return;
    }

    let basket = getCookieValue(COOKIE_NAME);
    let deleted = false;
    let index = basket.length - 1;

    while (!deleted || index >= 0) {
        if (basket[index].id == materialId) {
            basket.splice(index, 1);
            deleted = true;
        }
        index -= 1;
    }

    let row = button.closest("tr");

    if (row && row.parentNode) {
        row.parentNode.removeChild(row);
    }

    if (basket.length > 0) {
        setCookieValue(basket, COOKIE_NAME);
    } else {
        deleteCookie(COOKIE_NAME);
    }
}

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}
