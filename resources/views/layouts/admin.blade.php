<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>@yield('title', 'm3alem Admin')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --terracotta: #B85C2A;
      --terracotta-h: #9A4B22;
      --sand: #F2E4DA;
      --sand-dark: #E6D5C8;
      --ink: #0A0A0A;
      --ink-muted: #666666;
      --bg: #F9F7F4;
      --surface: #FFFFFF;
      --border: #E5E1DB;
      --green: #10B981;
      --red: #EF4444;
      --gold: #D4AF37;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--ink);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 240px;
      background: var(--ink);
      display: flex;
      flex-direction: column;
      height: 100vh;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .sidebar-header {
      padding: 32px 24px;
    }

    .sidebar-logo {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      color: var(--gold);
      text-decoration: none;
    }

    .nav {
      flex: 1;
      padding: 12px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      font-size: 13px;
      font-weight: 500;
      color: #999;
      text-decoration: none;
      border-radius: 12px;
      transition: all 0.2s;
    }

    .nav-item:hover {
      color: #fff;
      background: rgba(255,255,255,0.05);
    }

    .nav-item.active {
      background: var(--terracotta);
      color: #fff;
    }

    .nav-item svg {
      width: 18px;
      height: 18px;
      opacity: 0.7;
    }

    .nav-item.active svg {
      opacity: 1;
    }

    .sidebar-footer {
      padding: 24px;
      border-top: 1px solid rgba(255,255,255,0.05);
    }

    /* ── CONTENT AREA ── */
    .shell {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .header {
      padding: 32px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-title h1 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .header-title p {
      font-size: 14px;
      color: var(--ink-muted);
    }

    .main {
      padding: 0 40px 60px;
      flex: 1;
    }

    /* ── COMPONENTS ── */
    .card {
      background: var(--surface);
      border-radius: 20px;
      border: 1px solid var(--border);
      padding: 32px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .stat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 24px;
    }

    .stat-card-label {
      font-size: 12px;
      font-weight: 600;
      color: var(--ink-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 8px;
    }

    .stat-card-value {
      font-size: 32px;
      font-weight: 800;
      margin-bottom: 12px;
      color: var(--ink);
    }

    .stat-card-trend {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      font-weight: 600;
    }

    .trend-up { color: var(--green); }
    .trend-down { color: var(--red); }

    .grid-2 {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 24px;
      margin-bottom: 32px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* ── TABLES ── */
    .table-container {
      background: var(--surface);
      border-radius: 20px;
      border: 1px solid var(--border);
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      text-align: left;
      padding: 16px 24px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--ink-muted);
      background: #F8F9FA;
      border-bottom: 1px solid var(--border);
    }

    td {
      padding: 16px 24px;
      font-size: 14px;
      border-bottom: 1px solid var(--border);
    }

    tr:last-child td {
      border-bottom: none;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 12px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
    }

    .badge-success { background: #ECFDF5; color: #059669; }
    .badge-warning { background: #FFFBEB; color: #D97706; }
    .badge-danger { background: #FEF2F2; color: #DC2626; }

    /* ── BUTTONS ── */
    .btn-action {
      background: var(--terracotta);
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-action:hover {
      background: var(--terracotta-h);
    }

    /* ── SCROLLBAR ── */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #D1D1D1; border-radius: 10px; border: 2px solid var(--bg); }
  </style>
  @stack('styles')
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">m3alem</a>
  </div>

  <nav class="nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
      Dashboard
    </a>
    <a href="{{ route('admin.validation') }}" class="nav-item {{ request()->routeIs('admin.validation') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      Users Management
    </a>
    <a href="{{ route('admin.deliveries') }}" class="nav-item {{ request()->routeIs('admin.deliveries') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
      Statistics
    </a>
    <a href="#" class="nav-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
      Reports
    </a>
    <a href="{{ route('feed') }}" class="nav-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Back to Site
    </a>
  </nav>

  <div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        Logout
      </button>
    </form>
  </div>
</aside>

<div class="shell">
  <header class="header">
    <div class="header-title">
      <h1>@yield('header_title', 'Dashboard')</h1>
      <p>@yield('header_subtitle', 'Welcome back, Admin. Here\'s your platform overview.')</p>
    </div>
    <div class="header-actions">
      @yield('header_actions')
    </div>
  </header>

  <main class="main">
    @if(session('success'))
        <div style="background:#ECFDF5; color:#059669; padding:16px 24px; border-radius:16px; margin-bottom:32px; font-weight:600; border:1px solid #10B981;">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
  </main>
</div>

@stack('scripts')
</body>
</html>
