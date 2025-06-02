document.getElementById("image").addEventListener("change", function () {
    const fileName = this.files[0]?.name || "Ningún archivo seleccionado";
    document.getElementById("file-name").textContent = fileName;
});

function previewImage(event, previewElement) {
    let input = event.target;
    let imgPreview = document.querySelector(previewElement);

    if(!input.files.length) return;

    let file = input.files[0];

    let objectURL = URL.createObjectURL(file);
    imgPreview.src = objectURL;
}
