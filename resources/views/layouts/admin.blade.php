<!DOCTYPE html>
<html lang="en" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/css/app.css')
    <style>
        .sidebar-collapsed {
            width: 80px !important;
        }

        .sidebar-collapsed .sidebar-text {
            display: none;
        }

        .sidebar-collapsed .active-menu-item::after {
            display: none;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        /* New styles for enhanced design */
        .active-menu-item {
            position: relative;
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0) 100%);
            color: #6366f1;
            font-weight: 500;
        }

        .active-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #6366f1;
            border-radius: 0 4px 4px 0;
        }

        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, rgba(156, 163, 175, 0.2) 0%, transparent 100%);
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.4);
            border-radius: 3px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background-color: rgba(156, 163, 175, 0.6);
        }

        .logo-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .header-shadow {
            box-shadow: 0 2px 10px -3px rgba(0, 0, 0, 0.1);
        }

        .dark .header-shadow {
            box-shadow: 0 2px 10px -3px rgba(0, 0, 0, 0.3);
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="flex min-h-screen overflow-x-hidden transition-colors duration-300">

    <div id="sidebarBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden backdrop-blur-sm"></div>

    <aside id="adminSidebar" class="bg-white dark:bg-gray-800 shadow-xl w-64 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex flex-col sidebar-scroll sidebar-transition">
        <div class="p-4 border-b dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-700">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-lg bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold logo-gradient sidebar-text"> Lost & Found UiTM</span>
            </div>
            <button id="darkToggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-moon dark:hidden text-indigo-600"></i>
                <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
            </button>
        </div>

        <nav class="flex-1 mt-2 space-y-0 px-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors nav-item @if(Route::is('admin.dashboard')) active-menu-item @endif">
                <i class="fas fa-tachometer-alt mr-3 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
            <a href="{{ route('admin.moderation') }}" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors nav-item @if(Route::is('admin.moderation')) active-menu-item @endif">
                <i class="fas fa-shield-alt mr-3 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                <span class="sidebar-text">Item Moderation</span>
            </a>
            <a href="{{ route('admin.claims') }}" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors nav-item @if(Route::is('admin.claims')) active-menu-item @endif">
                <i class="fas fa-handshake mr-3 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                <span class="sidebar-text">Claim Moderation</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors nav-item @if(Route::is('admin.reports')) active-menu-item @endif">
                <i class="fas fa-chart-pie mr-3 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                <span class="sidebar-text">Reports</span>
            </a>

            <div class="border-t dark:border-gray-700 mt-4 pt-2 px-2">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <div class="p-4 border-t dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400 sidebar-text bg-gray-50 dark:bg-gray-700/30">
            <div class="flex items-center justify-between">
                <span>v1.0.0</span>
                <span id="currentYear">{{ date('Y') }}</span>
            </div>
        </div>
    </aside>

    <div class="flex-1 md:ml-64 transition-all duration-300" id="contentWrapper">
        <header class="sticky top-0 z-40 flex items-center justify-between px-6 py-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm header-shadow">
            <button id="unifiedSidebarToggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-bars text-xl text-indigo-600 dark:text-indigo-400"></i>
            </button>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                    <span class="font-medium text-indigo-700 dark:text-indigo-300">AD</span>
                </div>
            </div>
        </header>

        <main class="p-4 md:p-6 min-h-[calc(100vh-76px)] bg-gray-50 dark:bg-gray-900/50">
            @if(session('status'))
            <div class="fixed top-4 right-4 z-50 animate-slide-in">
                <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Scripts --}}
    <script>
        const sidebar = document.getElementById('adminSidebar');
        const contentWrapper = document.getElementById('contentWrapper');
        const backdrop = document.getElementById('sidebarBackdrop');
        const html = document.documentElement;
        const toggleBtn = document.getElementById('unifiedSidebarToggle');

        toggleBtn?.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            } else {
                sidebar.classList.toggle('sidebar-collapsed');
                contentWrapper.classList.toggle('md:ml-64');
                contentWrapper.classList.toggle('md:ml-20');
                const icon = toggleBtn.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-angle-double-left');
            }
        });

        backdrop?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        });

        const darkToggle = document.getElementById('darkToggle');
        const setTheme = (theme) => {
            const isDark = theme === 'dark';
            html.classList.toggle('dark', isDark);
            localStorage.setItem('theme', theme);
            darkToggle.querySelector('.fa-moon').classList.toggle('hidden', isDark);
            darkToggle.querySelector('.fa-sun').classList.toggle('hidden', !isDark);
        };

        darkToggle?.addEventListener('click', () => {
            const current = html.classList.contains('dark') ? 'light' : 'dark';
            setTheme(current);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored) setTheme(stored);
            else if (prefersDark) setTheme('dark');
            document.getElementById('currentYear').textContent = new Date().getFullYear();
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) setTheme(e.matches ? 'dark' : 'light');
        });
    </script>

    @yield('scripts')
</body>
</html>
