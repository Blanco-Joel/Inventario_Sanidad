if (document.addEventListener)
    window.addEventListener("load", inicio);
else if (document.attachEvent)
    window.attachEvent("onload", inicio);

async function updateDataRetrieveModifications() {
    let response = await fetch('/historical/modificationsHistoricalData');
    window.MODIFICATIONSDATA = await response.json();
}

async function updateDataRetrieve() {
    let url = window.location.href.split("/");
    url = url[url.length-1];
    console.log(url);
    let response = await fetch('/historical/historicalData?request='+url);
    window.HISTORICALDATA = await response.json();
}

async function inicio() {
    updateDataRetrieveModifications();
    updateDataRetrieve();
}
