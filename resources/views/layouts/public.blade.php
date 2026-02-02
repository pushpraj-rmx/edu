<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        @stack('meta')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col">
            @include('partials.header')

            <!-- Main Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            @include('partials.footer')
        </div>

        <script>
        (function () {
            var header = document.getElementById("site-header");
            var mobileButton = document.getElementById("mobile-menu-button");
            var mobileMenu = document.getElementById("mobile-menu");

            if (!header) return;

            var scrolledClasses = ["fixed", "!bg-white/20", "backdrop-blur-md", "shadow-sm", "border-b", "border-black/10"];
            var topClasses = ["absolute"];

            function updateHeaderScroll() {
                if (window.scrollY > 50) {
                    header.classList.remove("absolute");
                    scrolledClasses.forEach(function (c) { header.classList.add(c); });
                } else {
                    scrolledClasses.forEach(function (c) { header.classList.remove(c); });
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

            document.addEventListener("scroll", updateHeaderScroll, { passive: true });
            updateHeaderScroll();

            if (mobileButton && mobileMenu) {
                mobileButton.addEventListener("click", toggleMobileMenu);
                mobileMenu.querySelectorAll("a").forEach(function (link) {
                    link.addEventListener("click", function () {
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

            document.addEventListener("keydown", function (e) {
                if (e.key === "Escape" && mobileMenu && mobileMenu.classList.contains("block") && !mobileMenu.classList.contains("hidden")) {
                    toggleMobileMenu();
                }
            });
        })();
        </script>
    </body>
</html>
