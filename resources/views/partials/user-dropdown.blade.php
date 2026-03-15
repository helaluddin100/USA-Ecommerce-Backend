@php
    $user = auth()->user();
    if ($user) {
        $userInitial = strtoupper(substr($user->contact_name ?? $user->username ?? 'A', 0, 1));
        $userName = $user->contact_name ?? $user->username ?? 'Admin User';
        $userEmail = $user->email ?? 'admin@example.com';
    } else {
        $userInitial = 'A';
        $userName = 'Admin User';
        $userEmail = 'admin@example.com';
    }
@endphp

<!-- User Dropdown -->
<div class="relative" id="user-dropdown">
    <button onclick="toggleUserDropdown()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
            {{ $userInitial }}
        </div>
    </button>
    
    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
        <!-- User Info -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-lg shadow-md">
                    {{ $userInitial }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $userName }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $userEmail }}</p>
                </div>
            </div>
        </div>
        
        <!-- Menu Items -->
        <div class="py-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profile
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Settings
            </a>
        </div>
        
        <!-- Logout -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleUserDropdown() {
        const menu = document.getElementById('user-dropdown-menu');
        menu.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('user-dropdown');
        const menu = document.getElementById('user-dropdown-menu');
        if (dropdown && menu && !dropdown.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>

