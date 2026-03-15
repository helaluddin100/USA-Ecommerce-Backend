<!DOCTYPE html>
<html lang="en" id="html-element">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - B2B Ecommerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Initialize theme before page loads to prevent flash
        (function() {
            const theme = localStorage.getItem('theme') || 'system';
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (theme === 'dark' || (theme === 'system' && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Component -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">@yield('title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Theme Switcher -->
                        <div class="relative" id="theme-switcher">
                            <button onclick="toggleThemeMenu()" class="p-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <svg id="theme-icon-light" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <svg id="theme-icon-dark" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <svg id="theme-icon-system" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                            <div id="theme-menu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                                <button onclick="setTheme('light')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Light
                                </button>
                                <button onclick="setTheme('dark')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    Dark
                                </button>
                                <button onclick="setTheme('system')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    System
                                </button>
                            </div>
                        </div>
                        <!-- Notification Button -->
                        <button class="p-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <!-- Notification Badge -->
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <!-- User Dropdown -->
                        @include('partials.user-dropdown')
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Theme Switcher Script -->
    <script>
        function toggleThemeMenu() {
            const menu = document.getElementById('theme-menu');
            menu.classList.toggle('hidden');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const switcher = document.getElementById('theme-switcher');
            const menu = document.getElementById('theme-menu');
            if (switcher && menu && !switcher.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        function setTheme(theme) {
            localStorage.setItem('theme', theme);
            applyTheme(theme);
            updateThemeIcon(theme);
            // Close menu after selection
            document.getElementById('theme-menu').classList.add('hidden');
        }

        function applyTheme(theme) {
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const html = document.documentElement;
            
            if (theme === 'dark' || (theme === 'system' && systemPrefersDark)) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        }

        function updateThemeIcon(theme) {
            const lightIcon = document.getElementById('theme-icon-light');
            const darkIcon = document.getElementById('theme-icon-dark');
            const systemIcon = document.getElementById('theme-icon-system');
            
            // Hide all icons first
            if (lightIcon) lightIcon.classList.add('hidden');
            if (darkIcon) darkIcon.classList.add('hidden');
            if (systemIcon) systemIcon.classList.add('hidden');
            
            // Show icon based on selected theme preference (not current display)
            if (theme === 'system') {
                if (systemIcon) systemIcon.classList.remove('hidden');
            } else if (theme === 'dark') {
                if (darkIcon) darkIcon.classList.remove('hidden');
            } else {
                // theme === 'light'
                if (lightIcon) lightIcon.classList.remove('hidden');
            }
        }

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const theme = localStorage.getItem('theme') || 'system';
            // Theme already applied in head script, just update icon
            updateThemeIcon(theme);
        });

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
            const theme = localStorage.getItem('theme') || 'system';
            if (theme === 'system') {
                applyTheme('system');
                updateThemeIcon('system');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

