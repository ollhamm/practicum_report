import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();


const toggle = document.getElementById("profile-menu-toggle");
const dropdown = document.getElementById("profile-dropdown");

toggle.addEventListener("click", function (e) {
    e.stopPropagation();
    dropdown.classList.toggle("hidden");
});

document.addEventListener("click", function (e) {
    if (!toggle.contains(e.target)) {
        dropdown.classList.add("hidden");
    }
});

// Sidebar Toggle
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector("aside");
    const toggleButton = document.getElementById("sidebar-toggle");
    const mainContent = document.getElementById("main-content");
    const userInfoSidebar = document.getElementById("user-info-sidebar");
    const sidebarItems = document.querySelectorAll(
        "aside nav span, aside label, aside .ml-3"
    );
    const logoContainer = document.querySelector(
        "aside .flex.flex-row.items-center.gap-2"
    );
    const toggleNav = document.getElementById("toogle-nav");

    // Immediately apply saved state before DOM is fully loaded to prevent flash
    (function () {
        const savedStateCollapsed =
            sessionStorage.getItem("sidebarExpanded") === "false";
        if (savedStateCollapsed) {
            // Add a class to the body that we can use to style elements immediately
            document.body.classList.add("sidebar-collapsed");
        }
    })();

    // Load sidebar state from sessionStorage
    let sidebarExpanded =
        sessionStorage.getItem("sidebarExpanded") === "false" ? false : true;

    // Initialize sidebar state based on stored value
    function initializeSidebarState() {
        if (!sidebarExpanded) {
            // Start with collapsed sidebar if that was the last state
            sidebar.classList.remove("w-52");
            sidebar.classList.add("w-16", "items-center");
            userInfoSidebar?.classList.add("hidden");

            sidebarItems.forEach((item) => item.classList.add("hidden"));

            toggleButton.innerHTML = `
                <i class="fas fa-chevron-left text-gray-600 text-sm"></i>

    `;

            // Reposition toggle button
            toggleButton.classList.remove(
                "absolute",
                "top-4",
                "right-1",
                "self-end"
            );
            toggleButton.classList.add("self-start", "mb-2");

            logoContainer?.classList.add("justify-center");
            logoContainer?.querySelector(".ml-3")?.classList.add("hidden");

            updateMainContentMargin(false);
            updateNavPosition(false);
        }
    }

    function toggleSidebar() {
        if (sidebarExpanded) {
            // Collapse sidebar
            sidebar.classList.remove("w-52");
            sidebar.classList.add("w-16", "items-center");
            userInfoSidebar?.classList.add("hidden");

            sidebarItems.forEach((item) => item.classList.add("hidden"));

            toggleButton.innerHTML = `
                <i class="fas fa-chevron-right text-gray-600 text-sm"></i>

    `;

            // Reposition toggle button
            toggleButton.classList.remove(
                "absolute",
                "top-4",
                "right-1",
                "self-end"
            );
            toggleButton.classList.add("self-start", "mb-2");

            logoContainer?.classList.add("justify-center");
            logoContainer?.querySelector(".ml-3")?.classList.add("hidden");

            updateMainContentMargin(false);
            updateNavPosition(false);
            document.body.classList.add("sidebar-collapsed");
        } else {
            // Expand sidebar
            sidebar.classList.remove("w-16", "items-center");
            sidebar.classList.add("w-52");
            userInfoSidebar?.classList.remove("hidden");

            sidebarItems.forEach((item) => item.classList.remove("hidden"));

            toggleButton.innerHTML = `
        <i class="fas fa-chevron-left text-gray-600 text-sm"></i>
    `;

            // Reposition toggle button
            toggleButton.classList.remove("self-start", "mb-2");
            toggleButton.classList.add(
                "absolute",
                "top-4",
                "right-1",
                "self-end"
            );

            logoContainer?.classList.remove("justify-center");
            logoContainer?.querySelector(".ml-3")?.classList.remove("hidden");

            updateMainContentMargin(true);
            updateNavPosition(true);
            document.body.classList.remove("sidebar-collapsed");
        }

        sidebarExpanded = !sidebarExpanded;

        // Save the current state to sessionStorage
        sessionStorage.setItem("sidebarExpanded", sidebarExpanded.toString());
    }

    function updateMainContentMargin(expanded) {
        if (mainContent) {
            mainContent.classList.toggle("lg:ml-52", expanded);
            mainContent.classList.toggle("md:ml-48", expanded);
            mainContent.classList.toggle("lg:ml-16", !expanded);
            mainContent.classList.toggle("md:ml-16", !expanded);
        }
    }

    function updateNavPosition(expanded) {
        if (toggleNav) {
            // Update the left position of the navigation bar
            toggleNav.classList.toggle("left-52", expanded);
            toggleNav.classList.toggle("left-16", !expanded);
        }
    }

    function handleResponsiveLayout() {
        if (window.innerWidth < 768 && sidebarExpanded) {
            toggleSidebar();
        }
    }

    // Initialize sidebar based on saved state
    initializeSidebarState();

    toggleButton.addEventListener("click", toggleSidebar);
    handleResponsiveLayout();
    window.addEventListener("resize", handleResponsiveLayout);
});

// Dropdown
document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk menutup semua dropdown
    function closeAllDropdowns() {
        document
            .querySelectorAll(".dropdown-menu")
            .forEach(function (dropdown) {
                dropdown.classList.add("hidden");
            });
    }

    // Event listener untuk semua tombol kebab-menu
    document.querySelectorAll(".kebab-menu").forEach(function (button) {
        button.addEventListener("click", function (e) {
            e.stopPropagation();

            // Deteksi ID secara dinamis - cek semua atribut data-*-id
            let targetId = null;
            let dropdownPrefix = "dropdown-";

            // Loop melalui semua atribut pada button
            for (const attr of button.attributes) {
                if (
                    attr.name.startsWith("data-") &&
                    attr.name.endsWith("-id")
                ) {
                    targetId = attr.value;
                    // Opsional: tambahkan prefix khusus jika ingin membedakan jenis dropdown
                    // contoh: dropdownPrefix = attr.name.replace('data-', '').replace('-id', '') + '-';
                    break;
                }
            }

            // Jika ID ditemukan, manipulasi dropdown
            if (targetId) {
                const dropdown = document.getElementById(
                    dropdownPrefix + targetId
                );

                // Pastikan dropdown ditemukan
                if (dropdown) {
                    closeAllDropdowns();
                    dropdown.classList.toggle("hidden");
                }
            }
        });
    });

    // Menutup dropdown ketika mengklik di luar dropdown
    document.addEventListener("click", function () {
        closeAllDropdowns();
    });
});