<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-gray-800 text-white flex flex-col transition-all duration-300">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-lg font-semibold">{{ config('app.name') }}</h2>
                <p class="text-xs text-gray-400">Admin Panel</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <!-- Main Navigation -->
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('pages.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 {{ request()->routeIs('pages.*') ? 'bg-gray-700' : '' }}">
                        <span>Pages</span>
                    </a>
                    <a href="{{ route('offerings.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 {{ request()->routeIs('offerings.*') ? 'bg-gray-700' : '' }}">
                        <span>Offerings</span>
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 {{ request()->routeIs('categories.*') ? 'bg-gray-700' : '' }}">
                        <span>Categories</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700">
                        <span>Tags</span>
                    </a>
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 {{ request()->routeIs('posts.*') ? 'bg-gray-700' : '' }}">
                        <span>Posts</span>
                    </a>
                </div>

                <!-- Settings Section -->
                <div class="mt-8 pt-4 border-t border-gray-700">
                    <details class="group" open>
                        <summary
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 cursor-pointer">
                            <span>Settings</span>
                        </summary>
                        <div class="ml-4 mt-1 space-y-1">
                            <a href="{{ route('layout-settings.edit') }}"
                                class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-gray-700 {{ request()->routeIs('layout-settings.*') ? 'bg-gray-700' : '' }}">
                                <span>Layout Settings</span>
                            </a>
                        </div>
                    </details>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 h-12 flex items-center justify-between px-4">
                <div class="flex items-center space-x-4">
                    <!-- Sidebar Toggle -->
                    <button id="sidebar-toggle" class="p-1 rounded-md hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Admin Dashboard')</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle (Placeholder) -->
                    <button class="p-1 rounded-md hover:bg-gray-100 text-gray-600" title="Toggle Theme">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                    </button>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                        <a href="{{ route('profile.edit') }}"
                            class="text-sm text-gray-600 hover:text-gray-900">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Status Bar -->
            <footer
                class="bg-gray-200 border-t border-gray-300 h-6 flex items-center justify-between px-4 text-xs text-gray-600">
                <div class="flex items-center space-x-4">
                    <span>Connected to database</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>v1.0.0</span>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-ml-64');
        });
    </script>
</body>

</html>
