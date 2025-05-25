if (document.addEventListener)
    window.addEventListener("load", inicio);
else if (document.attachEvent)
    window.attachEvent("onload", inicio);

async function updateDataRetrieve() {
    let response = await fetch('/storages/updateData');
    window.STORAGEDATA = await response.json();
}

async function inicio() {
    updateDataRetrieve();

}

