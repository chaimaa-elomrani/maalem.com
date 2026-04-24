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
            <div class="flex items-center gap-4">
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
