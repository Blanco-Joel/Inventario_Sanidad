function hideLoader() {
    setTimeout(() => {
        const loader = document.getElementById("loader-overlay");
        if (!loader) return;

        loader.classList.add("fade-out");

        loader.addEventListener("animationend", () => {
            loader.style.display = "none";
        }, { once: true });
    }, 2000);
}