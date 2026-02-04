<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @stack('meta')

    <script>
        (function() {
            try {
                var stored = localStorage.getItem("theme");
                var theme = (stored === "light" || stored === "dark") ?
                    stored :
                    (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");

                document.documentElement.setAttribute("data-theme", theme);
                document.documentElement.style.colorScheme = theme;
            } catch (e) {}
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100 scheme-light dark:scheme-dark">
    <div class="min-h-screen flex flex-col">
        @include('partials.header')

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <script>
        (function() {
            function getStoredTheme() {
                try {
                    var stored = localStorage.getItem("theme");
                    if (stored === "light" || stored === "dark") return stored;
                } catch (e) {}
                return null;
            }

            function getPreferredTheme() {
                return (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) ? "dark" :
                    "light";
            }

            function applyTheme(theme) {
                document.documentElement.setAttribute("data-theme", theme);
                document.documentElement.style.colorScheme = theme;

                var toggle = document.getElementById("theme-toggle");
                if (!toggle) return;

                var isDark = theme === "dark";
                toggle.setAttribute("aria-pressed", isDark ? "true" : "false");

                var sun = toggle.querySelector(".theme-icon-sun");
                var moon = toggle.querySelector(".theme-icon-moon");
                if (sun) sun.classList.toggle("hidden", !isDark);
                if (moon) moon.classList.toggle("hidden", isDark);
            }

            function setTheme(theme) {
                applyTheme(theme);
                try {
                    localStorage.setItem("theme", theme);
                } catch (e) {}
            }

            function toggleTheme() {
                var current = document.documentElement.getAttribute("data-theme") || getStoredTheme() ||
                    getPreferredTheme();
                setTheme(current === "dark" ? "light" : "dark");
            }

            applyTheme(document.documentElement.getAttribute("data-theme") || getStoredTheme() || getPreferredTheme());

            var themeToggle = document.getElementById("theme-toggle");
            if (themeToggle) {
                themeToggle.addEventListener("click", toggleTheme);
            }

            try {
                var mq = window.matchMedia("(prefers-color-scheme: dark)");
                if (mq && mq.addEventListener) {
                    mq.addEventListener("change", function() {
                        if (!getStoredTheme()) {
                            applyTheme(getPreferredTheme());
                        }
                    });
                }
            } catch (e) {}

            var header = document.getElementById("site-header");
            var mobileButton = document.getElementById("mobile-menu-button");
            var mobileMenu = document.getElementById("mobile-menu");

            if (!header) return;

            var scrolledClasses = ["fixed", "!bg-white/80", "dark:!bg-gray-900/80", "backdrop-blur-md", "shadow-sm",
                "border-b",
                "border-black/10", "dark:border-white/10"
            ];
            var topClasses = ["absolute"];

            function updateHeaderScroll() {
                if (window.scrollY > 50) {
                    header.classList.remove("absolute");
                    scrolledClasses.forEach(function(c) {
                        header.classList.add(c);
                    });
                } else {
                    scrolledClasses.forEach(function(c) {
                        header.classList.remove(c);
                    });
                    header.classList.add("absolute");
                }
            }

            function toggleMobileMenu() {
                var isOpen = mobileMenu.classList.contains("block") && !mobileMenu.classList.contains("hidden");
                mobileMenu.classList.toggle("block", !isOpen);
                mobileMenu.classList.toggle("hidden", isOpen);
                mobileMenu.setAttribute("aria-hidden", isOpen ? "true" : "false");
                mobileButton.setAttribute("aria-expanded", !isOpen);
                var openIcon = document.querySelector(".menu-open-icon");
                var closeIcon = document.querySelector(".menu-close-icon");
                if (openIcon) openIcon.classList.toggle("hidden", !isOpen);
                if (closeIcon) closeIcon.classList.toggle("hidden", isOpen);
            }

            document.addEventListener("scroll", updateHeaderScroll, {
                passive: true
            });
            updateHeaderScroll();

            if (mobileButton && mobileMenu) {
                mobileButton.addEventListener("click", toggleMobileMenu);
                mobileMenu.querySelectorAll("a").forEach(function(link) {
                    link.addEventListener("click", function() {
                        mobileMenu.classList.add("hidden");
                        mobileMenu.classList.remove("block");
                        mobileMenu.setAttribute("aria-hidden", "true");
                        mobileButton.setAttribute("aria-expanded", "false");
                        var openIcon = document.querySelector(".menu-open-icon");
                        var closeIcon = document.querySelector(".menu-close-icon");
                        if (openIcon) openIcon.classList.remove("hidden");
                        if (closeIcon) closeIcon.classList.add("hidden");
                    });
                });
            }

            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape" && mobileMenu && mobileMenu.classList.contains("block") && !mobileMenu
                    .classList.contains("hidden")) {
                    toggleMobileMenu();
                }
            });
        })();
    </script>
</body>

</html>
