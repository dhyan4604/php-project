document.addEventListener("DOMContentLoaded", function () {
    const btns = document.querySelectorAll(".btn");
    btns.forEach(btn => {
        btn.addEventListener("click", function () {
            btn.classList.add("active");
            setTimeout(() => btn.classList.remove("active"), 200);
        });
    });
});
