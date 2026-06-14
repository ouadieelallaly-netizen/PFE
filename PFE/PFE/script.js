console.log("JS LOADED");

/* =========================
   DARK MODE
========================= */

const toggle = document.getElementById("theme-toggle");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
}

toggle.addEventListener("click", () => {

    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }

});


/* =========================
   FILTER PAR CATEGORIE
========================= */

const buttons = document.querySelectorAll(".filter-btn");
const products = document.querySelectorAll(".produit-card");

buttons.forEach(button => {

    button.addEventListener("click", () => {

        const category = button.dataset.category;

        buttons.forEach(btn => {
            btn.classList.remove("active");
        });

        button.classList.add("active");

        products.forEach(product => {

            if (product.dataset.category === category) {

                product.style.display = "block";

            } else {

                product.style.display = "none";

            }

        });

        document.querySelector(".pieces-grid")
        .scrollIntoView({
            behavior: "smooth"
        });

    });

});