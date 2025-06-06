if (document.addEventListener)
    window.addEventListener("load", inicio);
else if (document.attachEvent)
    window.attachEvent("onload", inicio);

// Función que retorna una promesa con los datos
function updateDataRetrieve() {
    return fetch('/materials/materialsData')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener datos');
            }
            return response.json();
        })
        .then(data => {
            window.MATERIALDATA = data;
            return data;
        })
        .catch(error => {
            console.error('Error en fetch:', error);
            return null;
        });
}

// Función inicio que espera la promesa antes de continuar
function inicio() {
    return updateDataRetrieve();
}
