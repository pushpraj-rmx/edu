@php
    $header = \App\Models\LayoutSetting::get('header', \App\Models\LayoutSetting::defaultHeader());
@endphp

<header id="site-header"
    class="absolute top-0 left-0 w-full z-50 bg-transparent backdrop-blur-sm text-gray-900 dark:text-gray-100 transition-all duration-300"
    role="banner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-[1fr_auto_1fr] items-center h-16 gap-4">
            <!-- Left: Logo -->
            <div class="flex justify-start">
                <a href="{{ route('home') }}"
                    class="flex items-center font-semibold focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600 rounded">
                    @if (!empty($header['logo']) || !empty($header['logo_dark']))
                        @if (!empty($header['logo']))
                            <img src="{{ Storage::url($header['logo']) }}"
                                alt="{{ $header['logo_alt'] ?? config('app.name') }}" class="h-10 w-auto dark:hidden">
                        @endif
                        @if (!empty($header['logo_dark']))
                            <img src="{{ Storage::url($header['logo_dark']) }}"
                                alt="{{ $header['logo_alt'] ?? config('app.name') }}"
                                class="h-10 w-auto hidden dark:block">
                        @elseif (!empty($header['logo']))
                            <img src="{{ Storage::url($header['logo']) }}"
                                alt="{{ $header['logo_alt'] ?? config('app.name') }}"
                                class="h-10 w-auto hidden dark:block">
                        @endif
                    @else
                        <span class="text-xl">{{ $header['logo_alt'] ?? config('app.name') }}</span>
                    @endif
                </a>
            </div>

            <!-- Center: Desktop Navigation -->
            <nav class="flex max-md:hidden justify-center items-center justify-self-center"
                aria-label="Main navigation">
                <ul class="flex items-center gap-1">
                    @foreach ($header['nav_links'] ?? [] as $index => $link)
                        @if (!empty($link['children']))
                            <li class="relative group/nav">
                                <button type="button"
                                    class="px-3 py-2 rounded-md text-sm font-medium hover:bg-black/5 dark:hover:bg-white/10 inline-flex items-center focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600 focus:bg-black/5 dark:focus:bg-white/10"
                                    aria-expanded="false" aria-haspopup="true"
                                    aria-controls="dropdown-{{ $index }}"
                                    id="nav-dropdown-trigger-{{ $index }}">
                                    {{ $link['label'] }}
                                    <svg class="ml-1 h-4 w-4 transition-transform group-hover/nav:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $index }}"
                                    class="absolute left-1/2 -translate-x-1/2 mt-1 w-48 py-1 rounded-2xl bg-white/70 backdrop-blur-md border border-black/10 shadow-lg opacity-0 invisible group-hover/nav:opacity-100 group-hover/nav:visible group-focus-within/nav:opacity-100 group-focus-within/nav:visible transition-all duration-200 z-50"
                                    role="menu" aria-orientation="vertical"
                                    aria-labelledby="nav-dropdown-trigger-{{ $index }}">
                                    @foreach ($link['children'] as $child)
                                        <a href="{{ $child['url'] }}" role="menuitem"
                                            class="block px-4 py-2 text-sm text-gray-800 hover:bg-black/5 focus:outline-none focus:bg-black/5 first:rounded-t-2xl last:rounded-b-2xl">
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @else
                            <li>
                                <a href="{{ $link['url'] }}"
                                    class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-black/5 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>

            <!-- Right: Auth link + CTA + Mobile hamburger -->
            <div class="flex justify-end items-center gap-3 justify-self-end">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="max-md:hidden md:inline-flex text-sm font-medium hover:bg-black/5 dark:hover:bg-white/10 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600">
                        Admin
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="max-md:hidden md:inline-flex text-sm font-medium hover:bg-black/5 dark:hover:bg-white/10 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600">
                        Login
                    </a>
                @endauth

                @if (!empty($header['cta_button']['visible']) && !empty($header['cta_button']['text']))
                    <a href="{{ $header['cta_button']['url'] ?? '#' }}"
                        class="max-md:hidden md:inline-flex items-center gap-2 rounded-full border border-black/20 dark:border-white/20 bg-transparent hover:bg-black/5 dark:hover:bg-white/10 px-4 py-2.5 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600">
                        <span>{{ $header['cta_button']['text'] }}</span>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-black/20 dark:border-white/20 shrink-0">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                    </a>
                @endif

                <button type="button" id="theme-toggle"
                    class="inline-flex items-center justify-center p-2 rounded-md hover:bg-black/5 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600"
                    aria-label="Toggle theme" aria-pressed="false">
                    <svg class="h-5 w-5 theme-icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"></path>
                    </svg>
                    <svg class="h-5 w-5 theme-icon-sun hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414m0-11.314L7.05 7.05m9.9 9.9 1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8z">
                        </path>
                    </svg>
                </button>

                <button type="button"
                    class="hidden max-md:inline-flex items-center justify-center p-2 rounded-md hover:bg-black/5 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600"
                    id="mobile-menu-button" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle menu">
                    <svg class="h-6 w-6 menu-open-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6 menu-close-icon hidden" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden overflow-hidden transition-all duration-300 ease-out"
            role="navigation" aria-label="Mobile menu" aria-hidden="true">
            <div
                class="pb-4 pt-2 space-y-0 border-t border-black/10 dark:border-white/10 max-h-[70vh] overflow-y-auto">
                @foreach ($header['nav_links'] ?? [] as $link)
                    @if (!empty($link['children']))
                        <div class="space-y-0">
                            <span class="block px-3 py-2 text-sm font-medium text-gray-500">
                                {{ $link['label'] }}
                            </span>
                            @foreach ($link['children'] as $child)
                                <a href="{{ $child['url'] }}"
                                    class="block pl-6 pr-3 py-2 text-sm font-medium text-gray-900 hover:bg-black/5 rounded-md">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <a href="{{ $link['url'] }}"
                            class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-black/5 rounded-md">
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-black/5 rounded-md md:hidden">
                        Admin
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-black/5 rounded-md md:hidden">
                        Login
                    </a>
                @endauth
                @if (!empty($header['cta_button']['visible']) && !empty($header['cta_button']['text']))
                    <a href="{{ $header['cta_button']['url'] ?? '#' }}"
                        class="flex items-center justify-center gap-2 mx-3 mt-3 py-2.5 rounded-full text-sm font-medium border border-black/20 text-gray-900 hover:bg-black/5">
                        <span>{{ $header['cta_button']['text'] }}</span>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-black/20 shrink-0">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

<div id="header-spacer" class="h-16" aria-hidden="true"></div>
