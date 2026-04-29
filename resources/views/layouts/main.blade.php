<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'm3alem'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --brand:       #B85C2A;
            --brand-hover: #9A4B22;
            --brand-dark:  #9A4B22;
            --brand-light: #F2E4DA;
            --brand-pale:  #FBF0E9;
            --brand-mid:   #D97B4F;
            --ink:         #18181B;
            --ink-2:       #3F3F46;
            --muted:       #71717A;
            --muted-2:     #A1A1AA;
            --border:      #E4E4E7;
            --bg:          #F4F4F5;
            --surface:     #FFFFFF;
            --star:        #D97706;
            --green:       #16A34A;
            --green-bg:    #DCFCE7;
            --blue:        #2563EB;
            --blue-bg:     #EFF6FF;
            --amber:       #D97706;
            --amber-bg:    #FEF3C7;
            --red:         #DC2626;
            --red-bg:      #FEE2E2;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.5;
        }

        .display-font { font-family: 'Playfair Display', serif; }
        .body-font { font-family: 'DM Sans', sans-serif; }

        /* ── HEADER ── */
        header { 
            background: var(--ink); 
            height: 64px; 
            display: flex; 
            align-items: center; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .header-inner { 
            width: 100%; 
            max-width: 1440px; 
            margin: 0 auto; 
            padding: 0 24px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
        }
        .logo { 
            font-size: 22px; 
            font-weight: 700; 
            color: var(--brand-mid); 
            letter-spacing: -.5px;
            text-decoration: none;
            font-family: 'Playfair Display', serif;
        }
        .nav-links { 
            display: flex; 
            align-items: center; 
            gap: 32px; 
        }
        .nav-links a { 
            font-size: 14px; 
            font-weight: 500; 
            color: rgba(255,255,255,0.6); 
            text-decoration: none; 
            transition: color .2s; 
            position: relative;
        }
        .nav-links a:hover, .nav-links a.active { 
            color: #fff; 
        }
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0; right: 0;
            height: 2px;
            background: var(--brand);
            border-radius: 1px;
        }

        .nav-right { 
            display: flex; 
            align-items: center; 
            gap: 16px; 
        }
        .btn-auth {
            font-size: 13px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 999px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-login {
            color: #fff;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-login:hover {
            background: rgba(255,255,255,0.1);
        }
        .btn-signup {
            background: var(--brand);
            color: #fff;
        }
        .btn-signup:hover {
            background: var(--brand-hover);
        }

        .user-av {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid rgba(255,255,255,0.1);
        }

        /* ── FOOTER ── */
        footer { 
            background: var(--ink); 
            border-top: 1px solid #27272A; 
            color: #71717A;
            padding: 40px 0 20px;
            margin-top: auto;
        }
        .footer-inner { 
            max-width: 1440px; 
            margin: 0 auto; 
            padding: 0 24px; 
        }
        .footer-top {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-col h4 {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-col ul li {
            margin-bottom: 10px;
        }
        .footer-col ul li a {
            color: inherit;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }
        .footer-col ul li a:hover {
            color: var(--brand);
        }
        .footer-bottom {
            border-top: 1px solid #27272A;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .footer-copy {
            font-size: 12px;
        }

        /* ── UTILS ── */
        .container-xl {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased min-h-screen flex flex-col">
    <!-- HEADER -->
    @unless(isset($minimal) && $minimal)
    <header>
        <div class="header-inner">
            <a href="{{ url('/') }}" class="logo">m3alem</a>
            
            <nav class="nav-links hidden md:flex">
                <a href="{{ route('feed') }}" class="{{ request()->routeIs('feed') ? 'active' : '' }}">Feed</a>
                <a href="{{ route('artisans.index') }}" class="{{ request()->routeIs('artisans.index') ? 'active' : '' }}">Explore</a>

                @auth
                    @if(Auth::user()->role === 'artisan')
                        <a href="{{ route('artisan.dashboard') }}" class="{{ request()->routeIs('artisan.dashboard') ? 'active' : '' }}">Dashboard</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @endif
                @endauth
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
    </header>
    @endunless

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    @unless(isset($minimal) && $minimal)
    <footer>
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-col col-span-2">
                    <div class="logo mb-4" style="color:var(--brand-mid)">m3alem</div>
                    <p class="text-[13px] max-w-xs leading-relaxed">
                        The ultimate destination for authentic Moroccan craftsmanship. Connecting you with master artisans nationwide.
                    </p>
                </div>
                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="{{ route('feed') }}">Artisan Feed</a></li>
                        <li><a href="{{ route('artisans.index') }}">Browse Artisans</a></li>
                        <li><a href="#">How it Works</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">© {{ date('Y') }} m3alem. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-500 hover:text-white transition-colors"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>
    @endunless

    @stack('scripts')
</body>
</html>
