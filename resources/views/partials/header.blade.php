@php
    $header = \App\Models\LayoutSetting::get('header', \App\Models\LayoutSetting::defaultHeader());
@endphp

<header
    id="site-header"
    class="fixed top-0 left-0 w-full z-50 backdrop-blur-md transition-all duration-300 bg-transparent text-white group"
    role="banner"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Name -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center text-white group-[.header-scrolled]:text-gray-900 focus:outline-none focus:ring-2 focus:ring-white/50 group-[.header-scrolled]:focus:ring-gray-400 rounded">
                    @if(!empty($header['logo']))
                        <img src="{{ Storage::url($header['logo']) }}" alt="{{ $header['logo_alt'] ?? config('app.name') }}" class="h-10 w-auto">
                    @else
                        <span class="text-xl font-semibold">{{ $header['logo_alt'] ?? config('app.name') }}</span>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation: visible from md breakpoint up, hidden on mobile -->
            <nav class="max-md:hidden md:flex items-center space-x-1" aria-label="Main navigation">
                @foreach($header['nav_links'] ?? [] as $index => $link)
                    @if(!empty($link['children']))
                        <div class="relative group/nav">
                            <button
                                type="button"
                                class="nav-link text-white group-[.header-scrolled]:text-gray-900 hover:opacity-90 px-3 py-2 rounded-md text-sm font-medium inline-flex items-center focus:outline-none focus:ring-2 focus:ring-white/50 group-[.header-scrolled]:focus:ring-gray-400"
                                aria-expanded="false"
                                aria-haspopup="true"
                                aria-controls="dropdown-{{ $index }}"
                                id="nav-dropdown-trigger-{{ $index }}"
                            >
                                {{ $link['label'] }}
                                <svg class="ml-1 h-4 w-4 transition-transform group-hover/nav:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div
                                id="dropdown-{{ $index }}"
                                class="absolute left-0 mt-0 w-48 py-1 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 shadow-xl opacity-0 invisible group-hover/nav:opacity-100 group-hover/nav:visible group-focus-within/nav:opacity-100 group-focus-within/nav:visible transition-all duration-200 z-50 group-[.header-scrolled]:bg-white/95 group-[.header-scrolled]:border-gray-200 group-[.header-scrolled]:backdrop-blur-md"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="nav-dropdown-trigger-{{ $index }}"
                            >
                                @foreach($link['children'] as $child)
                                    <a
                                        href="{{ $child['url'] }}"
                                        role="menuitem"
                                        class="block px-4 py-2 text-sm text-white/95 hover:bg-white/20 group-[.header-scrolled]:text-gray-700 group-[.header-scrolled]:hover:bg-gray-100 first:rounded-t-xl last:rounded-b-xl focus:outline-none focus:bg-white/20 group-[.header-scrolled]:focus:bg-gray-100"
                                    >
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a
                            href="{{ $link['url'] }}"
                            class="nav-link text-white group-[.header-scrolled]:text-gray-900 hover:opacity-90 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-white/50 group-[.header-scrolled]:focus:ring-gray-400"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- CTA Button & Auth -->
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="max-md:hidden md:inline-flex text-white group-[.header-scrolled]:text-gray-900 hover:opacity-90 px-3 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-white/50 group-[.header-scrolled]:focus:ring-gray-400 rounded-md">
                        Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="max-md:hidden md:inline-flex text-white group-[.header-scrolled]:text-gray-900 hover:opacity-90 px-3 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-white/50 group-[.header-scrolled]:focus:ring-gray-400 rounded-md">
                        Login
                    </a>
                @endauth

                @if(!empty($header['cta_button']['visible']) && !empty($header['cta_button']['text']))
                    <a
                        href="{{ $header['cta_button']['url'] ?? '#' }}"
                        class="max-md:hidden md:inline-flex items-center px-5 py-2.5 rounded-full text-sm font-medium bg-white/20 hover:bg-white/30 text-white border border-white/30 group-[.header-scrolled]:bg-indigo-600 group-[.header-scrolled]:hover:bg-indigo-700 group-[.header-scrolled]:border-transparent group-[.header-scrolled]:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-white/50"
                    >
                        {{ $header['cta_button']['text'] }}
                    </a>
                @endif

                <!-- Mobile menu button: visible only below md breakpoint (768px) -->
                <button
                    type="button"
                    class="hidden max-md:inline-flex items-center justify-center p-2 rounded-md text-white group-[.header-scrolled]:text-gray-900 hover:bg-white/10 group-[.header-scrolled]:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white/50 group-[.header-scrolled]:focus:ring-gray-400"
                    id="mobile-menu-button"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    aria-label="Toggle menu"
                >
                    <svg class="h-6 w-6 menu-open-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6 menu-close-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation: only visible below md when toggled open -->
        <div
            id="mobile-menu"
            class="hidden md:!hidden overflow-hidden transition-all duration-300 ease-out"
            role="navigation"
            aria-label="Mobile menu"
            aria-hidden="true"
        >
            <div class="pb-4 pt-2 space-y-1 border-t border-white/10 group-[.header-scrolled]:border-gray-200">
                @foreach($header['nav_links'] ?? [] as $link)
                    @if(!empty($link['children']))
                        <div class="space-y-0">
                            <span class="block px-3 py-2 text-sm font-medium text-white/80 group-[.header-scrolled]:text-gray-500">
                                {{ $link['label'] }}
                            </span>
                            @foreach($link['children'] as $child)
                                <a
                                    href="{{ $child['url'] }}"
                                    class="block pl-6 pr-3 py-2 text-sm font-medium text-white hover:bg-white/10 group-[.header-scrolled]:text-gray-700 group-[.header-scrolled]:hover:bg-gray-100 rounded-md"
                                >
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <a
                            href="{{ $link['url'] }}"
                            class="block px-3 py-2 text-sm font-medium text-white hover:bg-white/10 group-[.header-scrolled]:text-gray-700 group-[.header-scrolled]:hover:bg-gray-100 rounded-md"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-white hover:bg-white/10 group-[.header-scrolled]:text-gray-700 group-[.header-scrolled]:hover:bg-gray-100 rounded-md md:hidden">
                        Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-white hover:bg-white/10 group-[.header-scrolled]:text-gray-700 group-[.header-scrolled]:hover:bg-gray-100 rounded-md md:hidden">
                        Login
                    </a>
                @endauth
                @if(!empty($header['cta_button']['visible']) && !empty($header['cta_button']['text']))
                    <a href="{{ $header['cta_button']['url'] ?? '#' }}" class="block mx-3 mt-2 py-2.5 text-center rounded-full text-sm font-medium bg-white/20 text-white group-[.header-scrolled]:bg-indigo-600 group-[.header-scrolled]:text-white">
                        {{ $header['cta_button']['text'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

<!-- Spacer so content is not hidden under fixed header -->
<div class="h-16" aria-hidden="true"></div>

<script>
(function () {
    var header = document.getElementById("site-header");
    var mobileButton = document.getElementById("mobile-menu-button");
    var mobileMenu = document.getElementById("mobile-menu");

    if (!header) return;

    function updateHeaderScroll() {
        if (window.scrollY > 50) {
            header.classList.add("header-scrolled", "!bg-white/20", "shadow-md");
            header.classList.add("border-b", "border-white/10");
        } else {
            header.classList.remove("header-scrolled", "!bg-white/20", "shadow-md");
            header.classList.remove("border-b", "border-white/10");
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

    // Keyboard: Escape closes mobile menu
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && mobileMenu && mobileMenu.classList.contains("block") && !mobileMenu.classList.contains("hidden")) {
            toggleMobileMenu();
        }
    });
})();
</script>
