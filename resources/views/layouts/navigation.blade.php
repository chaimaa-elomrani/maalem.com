<div class="header-inner">
    <a href="{{ url('/') }}" class="logo">m3alem</a>
    
    <nav class="nav-links hidden md:flex">
        <a href="{{ route('feed') }}" class="{{ request()->routeIs('feed') ? 'active' : '' }}">Feed</a>
        <a href="{{ route('artisans.index') }}" class="{{ request()->routeIs('artisans.index') ? 'active' : '' }}">Explore</a>
        <a href="#" class="{{ request()->routeIs('messages') ? 'active' : '' }}">Messages</a>
        @auth
            @if(Auth::user()->role === 'artisan')
                <a href="{{ route('artisan.dashboard') }}" class="{{ request()->routeIs('artisan.dashboard') ? 'active' : '' }}">Dashboard</a>
            @elseif(Auth::user()->role === 'mediateur')
                <a href="{{ route('mediateur.dashboard') }}" class="{{ request()->routeIs('mediateur.dashboard') ? 'active' : '' }}">Dashboard</a>
            @else
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            @endif
        @endauth
        <a href="#" class="{{ request()->routeIs('saved') ? 'active' : '' }}">Saved</a>
    </nav>

    <div class="nav-right">
        @auth
            <div class="flex items-center gap-4 relative">
                <!-- Notifications Bell -->
                <div class="relative">
                    <button class="text-gray-400 hover:text-white pt-2" onclick="document.getElementById('notif-dropdown').classList.toggle('hidden'); event.stopPropagation();">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full" style="line-height: normal;">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    <!-- Dropdown -->
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg py-2 z-50 border border-gray-200" onclick="event.stopPropagation();">
                        <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-md text-gray-800">
                            <span class="font-bold text-sm">Notifications</span>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-xs text-[#C4622D] hover:underline font-medium">Mark all read</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @forelse(Auth::user()->unreadNotifications as $notification)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-0 text-left">
                                    <p class="text-[13px] text-gray-800 leading-snug">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                    <p class="text-[11px] text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </a>
                            @empty
                                <div class="px-4 py-4 text-[13px] text-gray-500 text-center">No new notifications</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="hidden sm:block text-right">
                    <div class="text-[13px] font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-gray-400 capitalize">{{ Auth::user()->role ?? 'Client' }}</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="user-av">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0" id="logout-form">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-auth btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-auth btn-signup">Sign up</a>
        @endauth
    </div>
</div>

<script>
    document.addEventListener('click', function() {
        const dropdown = document.getElementById('notif-dropdown');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
        }
    });
</script>
