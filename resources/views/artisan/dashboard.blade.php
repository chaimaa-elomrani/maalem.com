<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — My Dashboard</title>
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
      --bg:         #F3F4F6;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--ink); min-height: 100vh; display: flex; flex-direction: column; }

    .sidebar { width: 220px; background: #fff; border-right: 1px solid var(--border); min-height: 100vh; flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; display: flex; flex-direction: column; }
    .main-area { margin-left: 220px; flex: 1; padding: 32px; }

    .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; color: var(--muted); cursor: pointer; transition: background .15s, color .15s; margin: 2px 8px; text-decoration: none; }
    .nav-item:hover { background: var(--bg); color: var(--ink); }
    .nav-item.active { background: var(--brand-pale); color: var(--brand); }

    .card { background: #fff; border: 1px solid var(--border); border-radius: 12px; }
    .stat-val { font-size: 26px; font-weight: 700; }
    .stat-lbl { font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }

    .badge { display: inline-block; font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 4px; }
    .badge-green { background: #ECFDF5; color: #065F46; }
    .badge-orange { background: var(--brand-pale); color: var(--brand-dark); }

    .pcard { border: 1px solid var(--border); border-radius: 8px; overflow: hidden; background: #fff; transition: box-shadow .18s; }
    .pcard:hover { box-shadow: 0 4px 14px rgba(0,0,0,.08); }
    .pcard img { width: 100%; height: 120px; object-fit: cover; display: block; }

    .btn-primary { background: var(--brand); color: #fff; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; transition: background .15s; }
    .btn-primary:hover { background: var(--brand-dark); }
    .btn-ghost { background: transparent; color: var(--ink-2); font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer; transition: border-color .15s; }
    .btn-ghost:hover { border-color: #9CA3AF; }

    .rbar { height: 4px; border-radius: 3px; background: var(--border); flex: 1; overflow: hidden; }
    .rbar-fill { height: 100%; border-radius: 3px; background: #F59E0B; }

    hr { border: none; border-top: 1px solid var(--border); }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div style="padding: 20px 16px 12px;">
    <span style="font-size:16px;font-weight:700;color:var(--brand);">m3alem</span>
  </div>

  <!-- Artisan Avatar / Info -->
  <div style="padding: 12px 16px 16px; border-bottom: 1px solid var(--border);">
    <div style="width:44px;height:44px;border-radius:8px;background:var(--brand);color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;margin-bottom:8px;">
      {{ strtoupper(substr($artisanUser->name, 0, 1)) }}
    </div>
    <p style="font-size:13px;font-weight:600;color:var(--ink);">{{ $artisanUser->name }}</p>
    <p style="font-size:11px;color:var(--muted);">{{ $artisanUser->artisan->service ?? 'Artisan' }}</p>
    <span class="badge badge-green" style="margin-top:5px;">Active</span>
  </div>

  <!-- Nav -->
  <nav style="padding: 12px 0; flex: 1;">
    <a href="{{ route('artisan.dashboard') }}" class="nav-item active">
      Overview
    </a>
    <a href="{{ route('artisan.profile', $artisanUser->id) }}" class="nav-item" target="_blank">
      Public Profile
    </a>
    <a href="{{ route('posts.create') }}" class="nav-item">
      New Listing
    </a>
    <a href="#" class="nav-item">
      Reviews
    </a>
    <a href="#" class="nav-item">
      Messages
    </a>
    <a href="{{ route('artisan.setup') }}" class="nav-item">
      Edit Profile
    </a>
  </nav>

  <!-- Logout -->
  <div style="padding: 12px 8px; border-top: 1px solid var(--border);">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;border:none;background:none;text-align:left;">
        Logout
      </button>
    </form>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main-area">

  <!-- Header -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <div>
      <h1 style="font-size:20px;font-weight:700;">Welcome back, {{ $artisanUser->name }}</h1>
      <p style="font-size:13px;color:var(--muted);margin-top:2px;">Here's how your profile is performing.</p>
    </div>
    <a href="{{ route('posts.create') }}">
      <button class="btn-primary">+ Add New Listing</button>
    </a>
  </div>

  <!-- Stats Row -->
  @php
    $avgRating    = round($artisanUser->reviewsReceived->avg('rating') ?? 0, 1);
    $reviewsCount = $artisanUser->reviewsReceived->count();
    $postsCount   = $artisanUser->posts->count();
  @endphp
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:14px;margin-bottom:28px;">
    <div class="card" style="padding:18px;">
      <div class="stat-val">{{ $postsCount }}</div>
      <div class="stat-lbl">Active Listings</div>
    </div>
    <div class="card" style="padding:18px;">
      <div class="stat-val">{{ $reviewsCount }}</div>
      <div class="stat-lbl">Total Reviews</div>
    </div>
    <div class="card" style="padding:18px;">
      <div class="stat-val">{{ $avgRating > 0 ? $avgRating : '—' }}</div>
      <div class="stat-lbl">Average Rating</div>
    </div>
    <div class="card" style="padding:18px;">
      <div class="stat-val">{{ $artisanUser->city ?? '—' }}</div>
      <div class="stat-lbl">Location</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;" id="dashboard-grid">

    <!-- LEFT COLUMN -->
    <div style="display:flex;flex-direction:column;gap:20px;">

      <!-- Portfolio -->
      <div class="card" style="padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
          <h2 style="font-size:15px;font-weight:600;">My Listings</h2>
          <a href="{{ route('posts.create') }}">
            <button class="btn-ghost" style="font-size:12px;padding:6px 12px;">+ New</button>
          </a>
        </div>

        @if($artisanUser->posts->isEmpty())
          <div style="text-align:center;padding:32px 0;color:var(--muted);">
            <p style="font-size:13px;">You haven't added any listings yet.</p>
            <a href="{{ route('posts.create') }}">
              <button class="btn-primary" style="margin-top:12px;width:auto;padding:8px 20px;">Create First Listing</button>
            </a>
          </div>
        @else
          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
            @foreach($artisanUser->posts->take(6) as $post)
            <div class="pcard">
              @php
                $defaultImages = ['image 26.png', 'image 34.png', 'Broderie de Fez.jpeg', 'Pottery Painting, Morocco.jpeg'];
                $fallback = $defaultImages[$post->id % count($defaultImages)];
                $img = $post->images[0] ?? null;
              @endphp
              @if($img && !str_contains($img, 'unsplash'))
                <img src="{{ str_starts_with($img,'http') ? $img : asset('storage/'.$img) }}" alt="{{ $post->title }}" />
              @else
                <img src="{{ asset('images/'.$fallback) }}" alt="{{ $post->title }}" />
              @endif
              <div style="padding:10px;">
                <p style="font-size:12px;font-weight:600;margin-bottom:2px;">{{ Str::limit($post->title, 22) }}</p>
                <p style="font-size:11px;color:var(--muted);">{{ $post->category ?? 'Craft' }}</p>
              </div>
            </div>
            @endforeach
          </div>
        @endif
      </div>

      <!-- Recent Reviews -->
      <div class="card" style="padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
          <h2 style="font-size:15px;font-weight:600;">Recent Reviews</h2>
          <span style="font-size:12px;color:var(--muted);">{{ $reviewsCount }} total</span>
        </div>
        @forelse($artisanUser->reviewsReceived->take(3) as $rev)
        <div style="padding:12px 0;{{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;">
            <div style="display:flex;align-items:center;gap:8px;">
              <div style="width:28px;height:28px;border-radius:50%;background:var(--brand-pale);color:var(--brand-dark);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">
                {{ strtoupper(substr($rev->user->name ?? 'A', 0, 1)) }}
              </div>
              <div>
                <p style="font-size:13px;font-weight:600;">{{ $rev->user->name ?? 'Anonymous' }}</p>
                <p style="font-size:11px;color:var(--muted);">{{ $rev->created_at?->diffForHumans() }}</p>
              </div>
            </div>
            <span style="font-size:12px;font-weight:600;color:var(--brand);">{{ $rev->rating }}/5</span>
          </div>
          <p style="font-size:13px;color:var(--ink-2);line-height:1.6;">{{ Str::limit($rev->comment, 120) }}</p>
        </div>
        @empty
        <div style="text-align:center;padding:24px 0;color:var(--muted);">
          <p style="font-size:13px;">No reviews yet — keep creating great work!</p>
        </div>
        @endforelse
      </div>

    </div>

    <!-- RIGHT COLUMN -->
    <div style="display:flex;flex-direction:column;gap:16px;">

      <!-- Profile Completeness -->
      <div class="card" style="padding:18px;">
        <h3 style="font-size:14px;font-weight:600;margin-bottom:14px;">Profile Details</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <div>
            <div style="font-size:11px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Service</div>
            <div style="font-size:13px;margin-top:2px;">{{ $artisanUser->artisan->service ?? '—' }}</div>
          </div>
          <hr />
          <div>
            <div style="font-size:11px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Working Area</div>
            <div style="font-size:13px;margin-top:2px;">{{ $artisanUser->artisan->workingArea ?? '—' }}</div>
          </div>
          <hr />
          <div>
            <div style="font-size:11px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Workshop</div>
            <div style="font-size:13px;margin-top:2px;">{{ $artisanUser->artisan->workshopAdresse ?? '—' }}</div>
          </div>
          <hr />
          <div>
            <div style="font-size:11px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">Availability</div>
            <div style="font-size:13px;margin-top:2px;">
              @php
                $days = $artisanUser->artisan->disponibility ?? [];
                if (is_string($days)) {
                  $decoded = json_decode($days, true);
                  $days = is_array($decoded) ? $decoded : [$days];
                }
                echo is_array($days) ? implode(', ', $days) : $days;
              @endphp
            </div>
          </div>
        </div>
        <a href="{{ route('artisan.setup') }}" style="display:block;margin-top:14px;">
          <button class="btn-ghost" style="width:100%;font-size:12px;">Edit Profile Info</button>
        </a>
      </div>

      <!-- Rating Breakdown -->
      @if($reviewsCount > 0)
      @php
        $dist = $artisanUser->reviewsReceived->groupBy('rating')->map->count();
        $tot  = $reviewsCount;
      @endphp
      <div class="card" style="padding:18px;">
        <h3 style="font-size:14px;font-weight:600;margin-bottom:14px;">Rating Breakdown</h3>
        <div style="text-align:center;margin-bottom:14px;">
          <div style="font-size:32px;font-weight:700;">{{ $avgRating }}</div>
          <div style="font-size:11px;color:var(--muted);margin-top:2px;">Rating Score</div>
          <div style="font-size:11px;color:var(--muted);">{{ $reviewsCount }} reviews</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:6px;">
          @foreach([5,4,3,2,1] as $star)
          @php $count = $dist->get($star, 0); @endphp
          <div style="display:flex;align-items:center;gap:8px;">
            <span style="font-size:11px;color:var(--muted);width:10px;">{{ $star }}</span>
            <div class="rbar"><div class="rbar-fill" style="width:{{ $tot > 0 ? round(($count/$tot)*100) : 0 }}%;"></div></div>
            <span style="font-size:11px;color:var(--muted);width:24px;">{{ $tot > 0 ? round(($count/$tot)*100) : 0 }}%</span>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Skills -->
      @if($artisanUser->artisan && !empty($artisanUser->artisan->certifications))
      <div class="card" style="padding:18px;">
        <h3 style="font-size:14px;font-weight:600;margin-bottom:12px;">Skills</h3>
        <div style="display:flex;flex-wrap:wrap;gap:6px;">
          @php
            $skills = $artisanUser->artisan->certifications ?? [];
            if (is_string($skills)) {
                $decoded = json_decode($skills, true);
                $skills = is_array($decoded) ? $decoded : [$skills];
            }
          @endphp
          @foreach($skills as $skill)
          <span style="display:inline-block;background:var(--brand-pale);color:var(--brand-dark);font-size:11px;font-weight:500;padding:3px 9px;border-radius:4px;">{{ $skill }}</span>
          @endforeach
        </div>
      </div>
      @endif

    </div>
  </div>
</main>

<script>
  function applyLayout() {
    const grid = document.getElementById('dashboard-grid');
    if (!grid) return;
    if (window.innerWidth < 900) {
      grid.style.gridTemplateColumns = '1fr';
    } else {
      grid.style.gridTemplateColumns = '1fr 300px';
    }
  }
  applyLayout();
  window.addEventListener('resize', applyLayout);
</script>
</body>
</html>
