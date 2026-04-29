@extends('layouts.main')

@section('title', 'm3alem — Artisan Dashboard')

@push('styles')
  <style>
    /* ── SHELL ── */
    .artisan-shell { flex: 1; display: grid; grid-template-columns: 220px 1fr; width: 100%; margin: 0 auto; padding: 0 32px; gap: 0; align-items: start; }

    /* ── SIDEBAR ── */
    .artisan-sidebar { position: sticky; top: 64px; height: calc(100vh - 64px); overflow-y: auto; padding: 24px 0; display: flex; flex-direction: column; gap: 4px; border-right: 1px solid var(--border); padding-right: 20px; }
    .artisan-sidebar::-webkit-scrollbar { display: none; }

    .sidebar-avatar { width:44px; height:44px; border-radius:8px; background:var(--brand); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; margin-bottom:8px; }
    .sidebar-user-name { font-size:13px; font-weight:600; color:var(--ink); }
    .sidebar-user-sub { font-size:11px; color:var(--muted); }

    .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; color: var(--muted); cursor: pointer; transition: background .15s, color .15s; margin: 2px 0; text-decoration: none; }
    .nav-item:hover { background: var(--brand-light); color: var(--brand); }
    .nav-item.active { background: var(--brand-light); color: var(--brand); font-weight: 600; }

    /* ── MAIN CONTENT AREA ── */
    .artisan-main { padding: 28px 0 60px 28px; display: flex; flex-direction: column; gap: 24px; min-width: 0; }

    /* ── STAT CARDS ── */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px; margin-bottom: 4px; }
    .card { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 18px; }
    .stat-val { font-size: 26px; font-weight: 700; color: var(--ink); }
    .stat-lbl { font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }

    .badge { display: inline-block; font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 4px; }
    .badge-green { background: #ECFDF5; color: #065F46; }
    
    .pcard { border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #fff; transition: transform .2s, box-shadow .2s; display: flex; flex-direction: column; }
    .pcard:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.06); }
    .pcard img { width: 100%; height: 220px; object-fit: cover; display: block; border-bottom: 1px solid var(--border); }

    .btn-primary-artisan { background: var(--brand); color: #fff; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; transition: background .15s; text-decoration: none; display: inline-block; }
    .btn-primary-artisan:hover { background: var(--brand-dark); }
    .btn-ghost { background: transparent; color: var(--ink-2); font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer; transition: border-color .15s; }
    .btn-ghost:hover { border-color: #9CA3AF; }

    .rbar { height: 4px; border-radius: 3px; background: var(--border); flex: 1; overflow: hidden; }
    .rbar-fill { height: 100%; border-radius: 3px; background: #F59E0B; }

    .dashboard-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
    @media (max-width: 900px) {
        .artisan-shell { grid-template-columns: 1fr; padding: 0 16px; }
        .artisan-sidebar { display: none; }
        .artisan-main { padding: 20px 0; }
        .dashboard-grid { grid-template-columns: 1fr; }
    }
  </style>
@endpush

@section('content')
<div class="artisan-shell">
  <aside class="artisan-sidebar">
 

    <nav style="flex: 1;">
      <a href="{{ route('artisan.dashboard') }}" class="nav-item active">Overview</a>
      <a href="{{ route('artisan.profile', $artisanUser->id) }}" class="nav-item" target="_blank">Public Profile</a>
      <a href="{{ route('posts.create') }}" class="nav-item">New Listing</a>
      <a href="#" class="nav-item">Reviews</a>
      <a href="{{ route('artisan.setup') }}" class="nav-item">Edit Profile</a>
    </nav>

    <div style="padding: 12px 0; border-top: 1px solid var(--border);">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item" style="width:100%; border:none; background:none; text-align:left;">Logout</button>
      </form>
    </div>
  </aside>

  <main class="artisan-main">
   
    @if(session('error'))
      <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:500;color:#DC2626;margin-bottom:16px;">
        {{ session('error') }}
      </div>
    @endif

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; flex-wrap:wrap; gap:12px;">
      <div>
        <h1 style="font-size:20px; font-weight:700;">Welcome back, {{ $artisanUser->name }}</h1>
        <p style="font-size:13px; color:var(--muted); margin-top:2px;">Here's how your profile is performing.</p>
      </div>
      <a href="{{ route('posts.create') }}" class="btn-primary-artisan">+ Add New Listing</a>
    </div>

    @php
      $avgRating    = round($artisanUser->reviewsReceived->avg('note') ?? 0, 1);
      $reviewsCount = $artisanUser->reviewsReceived->count();
      $postsCount   = $artisanUser->posts->count();
    @endphp

    <div class="stats-grid">
      <div class="card">
        <div class="stat-val">{{ $postsCount }}</div>
        <div class="stat-lbl">Active Listings</div>
      </div>
      <div class="card">
        <div class="stat-val">{{ $reviewsCount }}</div>
        <div class="stat-lbl">Total Reviews</div>
      </div>
      <div class="card">
        <div class="stat-val">{{ $avgRating > 0 ? $avgRating : '—' }}</div>
        <div class="stat-lbl">Average Rating</div>
      </div>
      <div class="card">
        <div class="stat-val">{{ $artisanUser->city ?? '—' }}</div>
        <div class="stat-lbl">Location</div>
      </div>
    </div>

    <div class="dashboard-grid">
      <div style="display:flex; flex-direction:column; gap:20px;">
        <!-- My Listings -->
        <div class="card" style="padding:20px;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h2 style="font-size:15px; font-weight:600; color:var(--ink);">My Listings</h2>
            <a href="{{ route('posts.create') }}" class="btn-ghost" style="font-size:12px; padding:6px 12px; text-decoration:none;">+ New</a>
          </div>

          @if($artisanUser->posts->isEmpty())
            <div style="text-align:center; padding:32px 0; color:var(--muted);">
              <p style="font-size:13px;">You haven't added any listings yet.</p>
              <a href="{{ route('posts.create') }}" class="btn-primary-artisan" style="margin-top:12px; padding:8px 20px;">Create First Listing</a>
            </div>
          @else
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:20px;">
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
                  <p style="font-size:12px; font-weight:600; margin-bottom:2px; color:var(--ink);">{{ Str::limit($post->title, 22) }}</p>
                  <p style="font-size:11px; color:var(--muted);">{{ $post->category ?? 'Craft' }}</p>
                  <div style="display:flex; align-items:center; gap:10px; margin-top:12px;">
                    <a href="{{ route('posts.edit', $post->id) }}" style="font-size:11px; font-weight:600; color:var(--brand); text-decoration:none; background:var(--brand-pale); padding:4px 10px; border-radius:6px; transition:all 0.2s;">Update</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Delete this listing?')" style="margin:0;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" style="font-size:11px;font-weight:600;color:#DC2626;background:#FEE2E2;border:none;cursor:pointer;padding:4px 10px;border-radius:6px;transition:all 0.2s;">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          @endif
        </div>

        <!-- Delivery Assignments -->
        <div class="card" style="padding:20px;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h2 style="font-size:15px; font-weight:600; color:var(--ink);">Delivery Assignments</h2>
            <span style="font-size:12px; color:var(--muted);">{{ $deliveryTasks->count() }} active</span>
          </div>

          @forelse($deliveryTasks as $task)
            <div style="padding:15px; border:1px solid var(--border); border-radius:10px; margin-bottom:10px; background:var(--bg);">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:32px; height:32px; border-radius:50%; background:var(--brand); color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700;">
                        {{ strtoupper(substr($task->client->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px; font-weight:600; color:var(--ink);">{{ $task->client->user->name }}</p>
                        <p style="font-size:11px; color:var(--muted);">{{ $task->description }}</p>
                    </div>
                </div>
                <span class="badge" style="background:var(--brand-pale); color:var(--brand);">{{ str_replace('_', ' ', $task->status) }}</span>
              </div>
              
              <div style="display:flex; align-items:center; gap:10px; margin-top:10px;">
                @if($task->status == 'at_artisan')
                    <form action="{{ route('deliveries.update-status', $task->id) }}" method="POST" style="flex:1;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="btn-primary-artisan" style="width:100%; padding:6px; font-size:11px;">Start Work</button>
                    </form>
                @elseif($task->status == 'in_progress')
                    <form action="{{ route('deliveries.update-status', $task->id) }}" method="POST" style="flex:1;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ready_for_return">
                        <button type="submit" class="btn-primary-artisan" style="width:100%; padding:6px; font-size:11px;">Work Ready</button>
                    </form>
                @endif
              </div>
            </div>
          @empty
            <div style="text-align:center; padding:24px 0; color:var(--muted);">
              <p style="font-size:13px;">No mediation deliveries assigned to you yet.</p>
            </div>
          @endforelse
        </div>

        <!-- Recent Reviews -->
        <div class="card" style="padding:20px;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h2 style="font-size:15px; font-weight:600; color:var(--ink);">Recent Reviews</h2>
            <span style="font-size:12px; color:var(--muted);">{{ $reviewsCount }} total</span>
          </div>
          @forelse($artisanUser->reviewsReceived->take(3) as $rev)
          <div style="padding:12px 0; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:5px;">
              <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:50%; background:var(--brand-pale); color:var(--brand); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0;">
                  {{ strtoupper(substr($rev->user->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                  <p style="font-size:13px; font-weight:600; color:var(--ink);">{{ $rev->user->name ?? 'Anonymous' }}</p>
                  <p style="font-size:11px; color:var(--muted);">{{ $rev->created_at?->diffForHumans() }}</p>
                </div>
              </div>
              <span style="font-size:12px; font-weight:600; color:var(--brand);">{{ $rev->note }}/5</span>
            </div>
            <p style="font-size:13px; color:var(--ink-2); line-height:1.6;">{{ Str::limit($rev->comment, 120) }}</p>
          </div>
          @empty
          <div style="text-align:center; padding:24px 0; color:var(--muted);">
            <p style="font-size:13px;">No reviews yet — keep creating great work!</p>
          </div>
          @endforelse
        </div>
      </div>

      <div style="display:flex; flex-direction:column; gap:16px;">
        <!-- Profile Details -->
        <div class="card" style="padding:18px;">
          <h3 style="font-size:14px; font-weight:600; margin-bottom:14px; color:var(--ink);">Profile Details</h3>
          <div style="display:flex; flex-direction:column; gap:10px;">
            <div>
              <div style="font-size:11px; font-weight:500; color:var(--muted); text-transform:uppercase; letter-spacing:.04em;">Service</div>
              <div style="font-size:13px; margin-top:2px;">{{ $artisanUser->artisan->service ?? '—' }}</div>
            </div>
            <hr style="border:none; border-top:1px solid var(--border);" />
            <div>
              <div style="font-size:11px; font-weight:500; color:var(--muted); text-transform:uppercase; letter-spacing:.04em;">Working Area</div>
              <div style="font-size:13px; margin-top:2px;">{{ $artisanUser->artisan->workingArea ?? '—' }}</div>
            </div>
            <hr style="border:none; border-top:1px solid var(--border);" />
            <div>
              <div style="font-size:11px; font-weight:500; color:var(--muted); text-transform:uppercase; letter-spacing:.04em;">Workshop</div>
              <div style="font-size:13px; margin-top:2px;">{{ $artisanUser->artisan->workshopAdresse ?? '—' }}</div>
              <div style="margin-top:10px; height:120px; border-radius:8px; overflow:hidden; border:1px solid var(--border);">
                <iframe 
                  width="100%" 
                  height="100%" 
                  frameborder="0" 
                  scrolling="no" 
                  marginheight="0" 
                  marginwidth="0" 
                  src="https://maps.google.com/maps?q={{ urlencode($artisanUser->artisan->workshopAdresse ?? $artisanUser->city ?? 'Morocco') }}&t=&z=13&ie=UTF8&iwloc=&output=embed">
                </iframe>
              </div>
            </div>
            <hr style="border:none; border-top:1px solid var(--border);" />
            <div>
              <div style="font-size:11px; font-weight:500; color:var(--muted); text-transform:uppercase; letter-spacing:.04em;">Availability</div>
              <div style="font-size:13px; margin-top:2px;">
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
          <a href="{{ route('artisan.setup') }}" class="btn-ghost" style="display:block; margin-top:14px; width:100%; font-size:12px; text-align:center; text-decoration:none;">Edit Profile Info</a>
        </div>

        @if($reviewsCount > 0)
        @php
          $dist = $artisanUser->reviewsReceived->groupBy('note')->map->count();
          $tot  = $reviewsCount;
        @endphp
        <div class="card" style="padding:18px;">
          <h3 style="font-size:14px; font-weight:600; margin-bottom:14px; color:var(--ink);">Rating Breakdown</h3>
          <div style="text-align:center; margin-bottom:14px;">
            <div style="font-size:32px; font-weight:700; color:var(--ink);">{{ $avgRating }}</div>
            <div style="font-size:11px; color:var(--muted); margin-top:2px;">Rating Score</div>
            <div style="font-size:11px; color:var(--muted);">{{ $reviewsCount }} reviews</div>
          </div>
          <div style="display:flex; flex-direction:column; gap:6px;">
            @foreach([5,4,3,2,1] as $star)
            @php $count = $dist->get($star, 0); @endphp
            <div style="display:flex; align-items:center; gap:8px;">
              <span style="font-size:11px; color:var(--muted); width:10px;">{{ $star }}</span>
              <div class="rbar"><div class="rbar-fill" style="width:{{ $tot > 0 ? round(($count/$tot)*100) : 0 }}%;"></div></div>
              <span style="font-size:11px; color:var(--muted); width:24px;">{{ $tot > 0 ? round(($count/$tot)*100) : 0 }}%</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        @if($artisanUser->artisan && !empty($artisanUser->artisan->certifications))
        <div class="card" style="padding:18px;">
          <h3 style="font-size:14px; font-weight:600; margin-bottom:12px; color:var(--ink);">Skills</h3>
          <div style="display:flex; flex-wrap:wrap; gap:6px;">
            @php
              $skills = $artisanUser->artisan->certifications ?? [];
              if (is_string($skills)) {
                  $decoded = json_decode($skills, true);
                  $skills = is_array($decoded) ? $decoded : [$skills];
              }
            @endphp
            @foreach($skills as $skill)
            <span style="display:inline-block; background:var(--brand-pale); color:var(--brand); font-size:11px; font-weight:500; padding:3px 9px; border-radius:4px;">{{ $skill }}</span>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </main>
</div>
@endsection
