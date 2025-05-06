document.addEventListener("DOMContentLoaded", () => {
    /* 1) Slider automático */
    const slides = document.querySelectorAll(".carousel .slide");
    let current = 0;
    function showSlide(idx) {
        slides.forEach((s, i) => s.classList.toggle("active", i === idx));
    }
    function nextSlide() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }
    if (slides.length) {
        showSlide(0);
        setInterval(nextSlide, 5000);
    }

    /* Controles manuales */
    document.querySelectorAll(".carousel .controls button").forEach((btn) => {
        btn.addEventListener("click", () => {
            clearInterval(); // detiene el automático al interaccionar
            if (btn.id === "prev") {
                current = (current - 1 + slides.length) % slides.length;
            } else {
                current = (current + 1) % slides.length;
            }
            showSlide(current);
        });
    });

    /* 2) Scroll reveal */
    const reveals = document.querySelectorAll(".reveal");
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add("visible");
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.2 }
    );
    reveals.forEach((el) => io.observe(el));

    /* 3) Mobile nav toggle (si usas un botón #nav-toggle) */
    const navToggle = document.getElementById("nav-toggle");
    const navMenu = document.getElementById("nav-menu");
    if (navToggle && navMenu) {
        navToggle.addEventListener("click", () => {
            navMenu.classList.toggle("active");
        });
    }
});
