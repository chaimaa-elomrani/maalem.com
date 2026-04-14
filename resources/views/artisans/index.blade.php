<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — Browse Artisans</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --brand:      #C4622D;
      --brand-dark: #A34E22;
      --brand-pale: #F7EDE6;
      --ink:        #111827;
      --ink-2:      #374151;
      --muted:      #6B7280;
      --border:     #E5E7EB;
      --bg:         #F9FAFB;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--ink); }

    .navbar { background: #fff; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50; }

    .search-field {
      width: 100%; padding: 10px 16px 10px 40px; border: 1px solid var(--border); border-radius: 8px;
      font-size: 14px; outline: none; transition: border-color .15s, box-shadow .15s; background: #fff;
    }
    .search-field:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(196,98,45,.1); }

    .select-field {
      padding: 9px 14px; border: 1px solid var(--border); border-radius: 8px;
      font-size: 13px; color: var(--ink); background: #fff; outline: none; cursor: pointer;
    }
    .select-field:focus { border-color: var(--brand); }

    .acard {
      background: #fff; border: 1px solid var(--border); border-radius: 12px;
      overflow: hidden; transition: box-shadow .2s, transform .2s; display: flex; flex-direction: column;
    }
    .acard:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); transform: translateY(-3px); }

    .avatar-lg {
      width: 64px; height: 64px; border-radius: 10px; object-fit: cover;
      border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,.12); flex-shrink: 0;
    }
    .avatar-initials {
      width: 64px; height: 64px; border-radius: 10px; background: var(--brand);
      color: #fff; display: flex; align-items: center; justify-content: center;
      font-size: 24px; font-weight: 700; flex-shrink: 0;
    }

    .tag { display: inline-block; background: var(--brand-pale); color: var(--brand-dark); font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 4px; }
    .badge-green { display: inline-block; background: #ECFDF5; color: #065F46; font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 4px; }

    .btn-primary { background: var(--brand); color: #fff; font-size: 13px; font-weight: 600; padding: 8px 18px; border-radius: 8px; border: none; cursor: pointer; transition: background .15s; text-decoration: none; display: inline-block; }
    .btn-primary:hover { background: var(--brand-dark); }
    .btn-ghost { background: transparent; color: var(--ink-2); font-size: 13px; font-weight: 500; padding: 8px 18px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer; transition: border-color .15s; }

    .hero-bar { background: linear-gradient(130deg, #C4622D 0%, #9E4E24 100%); padding: 48px 24px; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .4s ease both; }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 3px; }
  </style>
</head>
<body>

<header class="navbar">
  <div style="max-width:1100px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;height:56px;">
    <span style="font-size:16px;font-weight:700;color:var(--brand);">m3alem</span>
    <nav style="display:flex;gap:24px;align-items:center;">
      <a href="{{ route('feed') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Feed</a>
      <a href="{{ route('artisans.index') }}" style="font-size:13px;font-weight:600;color:var(--ink);text-decoration:none;">Artisans</a>
      @auth
        <a href="{{ route('dashboard') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="btn-primary" style="padding:6px 16px;font-size:13px;">Login</a>
      @endauth
    </nav>
  </div>
</header>


<div class="hero-bar">
  <div style="max-width:1100px;margin:0 auto;text-align:center;">
    <h1 style="font-size:28px;font-weight:700;color:#fff;margin-bottom:8px;">Browse Moroccan Artisans</h1>
    <p style="font-size:14px;color:rgba(255,255,255,.75);margin-bottom:24px;">Discover skilled craftspeople and connect directly with the makers.</p>

    <form method="GET" action="{{ route('artisans.index') }}" style="display:flex;gap:10px;max-width:640px;margin:0 auto;flex-wrap:wrap;">
      <div style="position:relative;flex:1;min-width:200px;">
        <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;opacity:.4;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" name="search" class="search-field" placeholder="Search by name, craft, city…" value="{{ request('search') }}" />
      </div>
      <select name="city" class="select-field">
        <option value="">All Cities</option>
        @foreach($cities as $city)
          <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary">Search</button>
    </form>
  </div>
</div>

<div style="max-width:1100px;margin:0 auto;padding:32px 20px 60px;">


  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:8px;">
    <p style="font-size:14px;color:var(--muted);">
      Showing <strong style="color:var(--ink);">{{ $artisans->total() }}</strong> artisan{{ $artisans->total() !== 1 ? 's' : '' }}
      @if(request('search')) matching <strong style="color:var(--ink);">"{{ request('search') }}"</strong>@endif
      @if(request('city')) in <strong style="color:var(--ink);">{{ request('city') }}</strong>@endif
    </p>
    @if(request('search') || request('city'))
      <a href="{{ route('artisans.index') }}" style="font-size:12px;color:var(--brand);text-decoration:none;font-weight:500;">Clear filters ×</a>
    @endif
  </div>


  @if($artisans->isEmpty())
    <div style="text-align:center;padding:60px 20px;color:var(--muted);">
      <div style="font-size:40px;margin-bottom:12px;">🔍</div>
      <p style="font-size:15px;font-weight:500;margin-bottom:4px;">No artisans found</p>
      <p style="font-size:13px;">Try adjusting your search or clearing filters.</p>
    </div>
  @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
      @foreach($artisans as $i => $artisan)
      <div class="acard fade-up" style="animation-delay:{{ $i * 0.04 }}s;">


        <div style="height:6px;background:linear-gradient(90deg,#C4622D,#9E4E24);"></div>

        <div style="padding:20px;flex:1;display:flex;flex-direction:column;gap:14px;">


          <div style="display:flex;align-items:flex-start;gap:14px;">
            <div class="avatar-initials">{{ strtoupper(substr($artisan->name, 0, 1)) }}</div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin-bottom:3px;">
                <h2 style="font-size:15px;font-weight:700;">{{ $artisan->name }}</h2>
                <span class="badge-green">Active</span>
              </div>
              <p style="font-size:12px;color:var(--muted);">
                {{ $artisan->artisan->service ?? 'Artisan' }}
                @if($artisan->city) &nbsp;·&nbsp; {{ $artisan->city }} @endif
              </p>
              @php $avg = round($artisan->reviewsReceived->avg('rating') ?? 0, 1); @endphp
              @if($avg > 0)
              <p style="font-size:12px;margin-top:3px;">
                <span style="color:#F59E0B;">★</span>
                <span style="font-weight:600;color:var(--ink);">{{ $avg }}</span>
                <span style="color:var(--muted);">({{ $artisan->reviewsReceived->count() }})</span>
              </p>
              @endif
            </div>
          </div>


          @if($artisan->artisan?->experience)
          <p style="font-size:13px;color:var(--ink-2);line-height:1.6;">
            {{ Str::limit($artisan->artisan->experience, 100) }}
          </p>
          @endif


          @php
            $certs = $artisan->artisan?->certifications;
            if (is_string($certs)) {
                $certs = json_decode($certs, true) ?? [];
            }
          @endphp
          @if(is_array($certs) && count($certs) > 0)
          <div style="display:flex;flex-wrap:wrap;gap:5px;">
            @foreach(array_slice($certs, 0, 4) as $skill)
              <span class="tag">{{ $skill }}</span>
            @endforeach
            @if(count($certs) > 4)
              <span style="font-size:11px;color:var(--muted);align-self:center;">+{{ count($certs) - 4 }} more</span>
            @endif
          </div>
          @endif


          <div style="display:flex;gap:16px;padding:10px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
            <div>
              <div style="font-size:16px;font-weight:700;">{{ $artisan->posts_count ?? '—' }}</div>
              <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Listings</div>
            </div>
            <div>
              <div style="font-size:16px;font-weight:700;">{{ $artisan->reviewsReceived->count() }}</div>
              <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Reviews</div>
            </div>
            <div>
              <div style="font-size:16px;font-weight:700;">{{ $artisan->artisan?->workingArea ?? '—' }}</div>
              <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Craft</div>
            </div>
          </div>


          <a href="{{ route('artisan.profile', $artisan->id) }}" class="btn-primary" style="text-align:center;width:100%;">
            View Profile
          </a>

        </div>
      </div>
      @endforeach
    </div>


    <div style="margin-top:36px;">
      {{ $artisans->links() }}
    </div>
  @endif

</div>

<footer style="background:#111827;border-top:1px solid #1F2937;">
  <div style="max-width:1100px;margin:0 auto;padding:20px 24px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;">
    <span style="font-size:15px;font-weight:700;color:var(--brand);">m3alem</span>
    <p style="font-size:12px;color:#6B7280;">© 2025 m3alem · Connect with Moroccan Artisans.</p>
  </div>
</footer>

</body>
</html>
