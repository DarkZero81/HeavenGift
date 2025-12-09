// Navbar Enhancement JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Enhanced Search Functionality
    const searchInput = document.querySelector(".search-input");
    const searchForm = document.querySelector(".search-form");

    if (searchInput && searchForm) {
        // Add search suggestions (basic implementation)
        searchInput.addEventListener("input", function () {
            const query = this.value.trim();
            if (query.length > 2) {
                // You can implement AJAX search suggestions here
                console.log("Searching for:", query);
            }
        });

        // Clear search on escape key
        searchInput.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                this.value = "";
            }
        });
    }

    // Cart Badge Animation
    function updateCartBadge(count) {
        const cartBadge = document.querySelector(".cart-badge");
        if (cartBadge) {
            cartBadge.textContent = count;
            cartBadge.style.display = count > 0 ? "flex" : "none";

            // Add animation when count changes
            if (count > 0) {
                cartBadge.style.animation = "none";
                cartBadge.offsetHeight; // Trigger reflow
                cartBadge.style.animation = "pulse 0.5s ease-in-out";
            }
        }
    }

    // Mock cart count (you can replace this with real cart data)
    updateCartBadge(0);

    // Add pulse animation for cart badge
    const style = document.createElement("style");
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);

    // Mobile Navbar Enhancements
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener("click", function () {
            const isExpanded = this.getAttribute("aria-expanded") === "true";
            this.setAttribute("aria-expanded", !isExpanded);
        });

        // Close mobile menu when clicking on a link
        const navLinks = navbarCollapse.querySelectorAll(".nav-link");
        navLinks.forEach((link) => {
            link.addEventListener("click", function () {
                if (window.innerWidth < 992) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        hide: true,
                    });
                }
            });
        });
    }

    // User Dropdown Enhancements
    const userDropdown = document.querySelector(".user-dropdown");
    const dropdownMenu = document.querySelector(".user-dropdown-menu");

    if (userDropdown && dropdownMenu) {
        // Add hover effect for desktop
        if (window.innerWidth >= 992) {
            let hoverTimeout;

            userDropdown.addEventListener("mouseenter", function () {
                clearTimeout(hoverTimeout);
                const dropdown = new bootstrap.Dropdown(this);
                dropdown.show();
            });

            userDropdown.addEventListener("mouseleave", function () {
                hoverTimeout = setTimeout(() => {
                    const dropdown = bootstrap.Dropdown.getInstance(this);
                    if (dropdown) {
                        dropdown.hide();
                    }
                }, 300);
            });
        }
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });

    // Add loading state to forms
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function () {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                submitBtn.disabled = true;
            }
        });
    });

    // Navbar scroll effect
    let lastScrollTop = 0;
    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", function () {
        const scrollTop =
            window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            navbar.style.transform = "translateY(-100%)";
        } else {
            // Scrolling up
            navbar.style.transform = "translateY(0)";
        }

        lastScrollTop = scrollTop;
    });

    // Add transition for navbar
    navbar.style.transition = "transform 0.3s ease-in-out";
});
