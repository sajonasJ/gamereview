document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggle-btn");
    const navContainer = document.getElementById("nav-container");

    toggleBtn.addEventListener("click", () => {
        const toggleI = toggleBtn.querySelector("i");

        navContainer.classList.toggle("collapsed");

        const isCollapsed = navContainer.classList.contains("collapsed");
        toggleI.classList.toggle("bi-arrow-right", !isCollapsed);
        toggleI.classList.toggle("bi-arrow-left", isCollapsed);
    });
});

