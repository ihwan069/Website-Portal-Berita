document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const dropdownMenu = document.getElementById("dropdown-menu");

    // Event untuk toggle dropdown menu (buka/close)
    menuToggle.addEventListener("click", () => {
        dropdownMenu.classList.toggle("hidden");
    });

    // 1. Tutup menu saat user scroll
    window.addEventListener("scroll", () => {
        if (!dropdownMenu.classList.contains("hidden")) {
            dropdownMenu.classList.add("hidden");
        }
    });

    // 2. Tutup menu saat layar berubah ukuran (misalnya rotate HP atau buka versi desktop)
    window.addEventListener("resize", () => {
        if (!dropdownMenu.classList.contains("hidden")) {
            dropdownMenu.classList.add("hidden");
        }
    });

    // 3. Tutup menu ketika klik di luar dropdown
    document.addEventListener("click", (e) => {
        const isClickInsideMenu = dropdownMenu.contains(e.target);
        const isClickToggle = menuToggle.contains(e.target);

        // Jika menu sedang terbuka, dan klik bukan di menu atau tombol toggle → tutup
        if (
            !dropdownMenu.classList.contains("hidden") &&
            !isClickInsideMenu &&
            !isClickToggle
        ) {
            dropdownMenu.classList.add("hidden");
        }
    });
});
