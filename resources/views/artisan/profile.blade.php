<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — {{ $artisanUser->name }}</title>
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
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--ink); font-size: 14px; line-height: 1.5; }

    .navbar { background: #fff; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50; }
    .hero   { height: 190px; background: linear-gradient(130deg, #C4622D 0%, #9E4E24 100%); }
    .card   { background: #fff; border: 1px solid var(--border); border-radius: 10px; }

    .btn-primary  { background: var(--brand); color: #fff; font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; transition: background .15s; }
    .btn-primary:hover { background: var(--brand-dark); }
    .btn-ghost     { background: transparent; color: var(--ink-2); font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 6px; border: 1px solid var(--border); cursor: pointer; transition: border-color .15s; }
    .btn-ghost:hover { border-color: #9CA3AF; }

    .tag { display: inline-block; background: var(--brand-pale); color: var(--brand-dark); font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 4px; }

    .stat-val { font-size: 22px; font-weight: 700; line-height: 1.15; }
    .stat-lbl { font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-top: 3px; }

    .pcard { background: #fff; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow .18s; }
    .pcard:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
    .pcard img { width: 100%; height: 155px; object-fit: cover; display: block; }

    .rcard { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 16px; }

    .rbar { height: 5px; border-radius: 3px; background: var(--border); flex: 1; overflow: hidden; }
    .rbar-fill { height: 100%; border-radius: 3px; background: #F59E0B; }

    .tab { font-size: 13px; font-weight: 500; color: var(--muted); padding-bottom: 10px; cursor: pointer; border-bottom: 2px solid transparent; white-space: nowrap; }
    .tab.active { color: var(--ink); border-bottom-color: var(--brand); }

    .form-field { width: 100%; padding: 8px 10px; border: 1px solid var(--border); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 13px; color: var(--ink); outline: none; }
    .form-field:focus { border-color: var(--brand); }
    label { font-size: 11px; font-weight: 500; color: var(--muted); display: block; margin-bottom: 4px; }

    .avatar { width: 84px; height: 84px; border-radius: 8px; border: 3px solid #fff; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,.14); }

    .badge-green { display: inline-block; background: #ECFDF5; color: #065F46; font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 4px; }

    hr { border: none; border-top: 1px solid var(--border); }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 3px; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <div style="max-width:960px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;height:56px;">
    <span style="font-size:16px;font-weight:700;color:var(--brand);">m3alem</span>
    <nav style="display:flex;gap:24px;">
      <a href="{{ route('feed') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Feed</a>
      <a href="#" style="font-size:13px;font-weight:600;color:var(--ink);text-decoration:none;">Profile</a>
      <a href="{{ route('dashboard') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Account</a>
    </nav>
  </div>
</header>

<!-- HERO -->
<div class="hero"></div>

<div style="max-width:960px;margin:0 auto;padding:0 16px;">

  <!-- PROFILE CARD -->
  <div class="card p-5 md:p-6" style="margin-top:-48px;margin-bottom:16px;">
    <div style="display:flex;flex-wrap:wrap;gap:20px;">

      <div class="avatar" style="background-color: var(--brand); color: white; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: bold;">
        {{ strtoupper(substr($artisanUser->name, 0, 1)) }}
      </div>

      <div style="flex:1;min-width:240px;">
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:6px;">
          <h1 style="font-size:18px;font-weight:700;">{{ $artisanUser->name }}</h1>
          <span class="badge-green">Available</span>
        </div>
        <p style="color:var(--muted);margin-bottom:10px;font-size:13px;">
          {{ $artisanUser->artisan->service ?? 'Artisan' }} &nbsp;·&nbsp; {{ $artisanUser->city ?? 'Morocco' }} &nbsp;·&nbsp;
          <span style="color:#F59E0B;">★★★★★</span>
          <span style="font-weight:600;color:var(--ink);"> {{ $averageRating }}</span>
          <span style="color:var(--muted);"> ({{ $reviewsCount }} reviews)</span>
        </p>
        <p style="color:var(--ink-2);max-width:560px;line-height:1.65;margin-bottom:14px;font-size:13px;">
          {{ $artisanUser->artisan->experience ?? 'Passionate Moroccan artisan crafting authentic pieces.' }}
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;">
          @if($artisanUser->artisan && !empty($artisanUser->artisan->certifications))
             @php
                $certifications = is_array($artisanUser->artisan->certifications) ? $artisanUser->artisan->certifications : json_decode($artisanUser->artisan->certifications, true) ?? [];
             @endphp
             @foreach($certifications as $tag)
                <span class="tag">{{ trim($tag, "\[\]\"'") }}</span>
             @endforeach
          @endif
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <button class="btn-primary">Book Consultation</button>
          <button class="btn-ghost">Follow</button>
          <button class="btn-ghost">Message</button>
        </div>
      </div>

      <div style="border-left:1px solid var(--border);padding-left:20px;display:flex;flex-direction:column;gap:14px;min-width:130px;" class="hidden md:flex">
        <div>
          <div class="stat-lbl">Response Time</div>
          <div style="font-size:14px;font-weight:600;margin-top:2px;">2 – 4 hours</div>
        </div>
        <div>
          <div class="stat-lbl">Followers</div>
          <div style="font-size:14px;font-weight:600;margin-top:2px;">{{ rand(100, 5000) }}</div>
        </div>
        <div>
          <div class="stat-lbl">Member Since</div>
          <div style="font-size:14px;font-weight:600;margin-top:2px;">{{ $artisanUser->created_at->format('F Y') }}</div>
        </div>
      </div>

    </div>
  </div>

  <!-- STATS -->
  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:16px;" class="md:grid-cols-4">
    <div class="card p-4">
      <div class="stat-val">892</div>
      <div class="stat-lbl">Completed Orders</div>
    </div>
    <div class="card p-4">
      <div class="stat-val">{{ (isset($artisanUser->posts) && $artisanUser->posts) ? $artisanUser->posts->count() : 0 }}</div>
      <div class="stat-lbl">Active Listings</div>
    </div>
    <div class="card p-4">
      <div class="stat-val">{{ $averageRating }} <span style="font-size:13px;font-weight:400;color:var(--muted);">/ 5</span></div>
      <div class="stat-lbl">Average Rating</div>
    </div>
    <div class="card p-4">
      <div class="stat-val">{{ rand(95, 100) }}%</div>
      <div class="stat-lbl">On-Time Delivery</div>
    </div>
  </div>

  <!-- COLUMNS -->
  <div style="display:grid;grid-template-columns:1fr;gap:16px;padding-bottom:60px;" class="lg:grid-cols-3-custom">

    <div style="display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;" class="grid-main">

      <!-- LEFT -->
      <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- Tabs -->
        <div style="display:flex;gap:24px;border-bottom:1px solid var(--border);">
          <span class="tab active">Portfolio</span>
          <span class="tab">About</span>
          <span class="tab">Reviews</span>
        </div>

        <!-- Portfolio -->
        <div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h2 style="font-size:14px;font-weight:600;">Featured Portfolio</h2>
            <a href="#" style="font-size:12px;font-weight:500;color:var(--brand);text-decoration:none;">View all</a>
          </div>
          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
            @if(isset($artisanUser->posts))
               @forelse($artisanUser->posts as $post)
               <div class="pcard">
                  @php
                        $firstImage = null;
                        if ($post->images && is_array($post->images) && count($post->images) > 0) {
                           $firstImage = $post->images[0];
                        } elseif ($post->images && is_string($post->images) && ($decoded = json_decode($post->images, true)) && count($decoded) > 0) {
                           $firstImage = $decoded[0];
                        }
                        $isSeederPlaceholder = $firstImage && str_contains($firstImage, 'unsplash.com');
                        
                        $defaultImages = ['image 26.png', 'image 34.png', 'Broderie de Fez.jpeg', 'Pottery Painting, Morocco.jpeg'];
                        $fallback = $defaultImages[($post->id ?? 0) % count($defaultImages)];
                  @endphp
                  
                  @if($firstImage && !$isSeederPlaceholder)
                        @if(str_starts_with($firstImage, 'http'))
                           <img src="{{ $firstImage }}" alt="{{ $post->title }}" />
                        @else
                           <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $post->title }}" />
                        @endif
                  @else
                        <img src="{{ asset('images/' . $fallback) }}" alt="{{ $post->title }}" />
                  @endif
                  <div style="padding:12px;">
                     <p style="font-weight:600;font-size:13px;margin-bottom:2px;">{{ Str::limit($post->title, 20) }}</p>
                     <p style="font-size:11px;color:var(--muted);margin-bottom:6px;">{{ Str::limit($post->description, 35) }}</p>
                     <p style="font-weight:700;color:var(--brand);font-size:13px;">Contact for Price</p>
                  </div>
               </div>
               @empty
               <p style="grid-column: 1 / -1; color: var(--muted); padding: 20px;">No active listings found.</p>
               @endforelse
            @endif

            <div class="pcard" style="display:flex;align-items:center;justify-content:center;min-height:210px;background:var(--bg);border-style:dashed;box-shadow:none;">
              <div style="text-align:center;color:var(--muted);">
                <div style="font-size:22px;line-height:1;margin-bottom:6px;">+</div>
                <p style="font-size:12px;">Add listing</p>
              </div>
            </div>

          </div>
        </div>

        <!-- Reviews -->
        <div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h2 style="font-size:14px;font-weight:600;">Customer Reviews</h2>
            <span style="font-size:12px;color:var(--muted);">{{ $reviewsCount }} reviews</span>
          </div>

          <!-- Summary -->
          @php
               $c5 = isset($ratingDistribution) ? collect($ratingDistribution)->get(5, 0) : 0;
               $c4 = isset($ratingDistribution) ? collect($ratingDistribution)->get(4, 0) : 0;
               $c3 = isset($ratingDistribution) ? collect($ratingDistribution)->get(3, 0) : 0;
               $c2 = isset($ratingDistribution) ? collect($ratingDistribution)->get(2, 0) : 0;
               $c1 = isset($ratingDistribution) ? collect($ratingDistribution)->get(1, 0) : 0;
               $tot = $reviewsCount > 0 ? $reviewsCount : 1;
          @endphp
          <div class="card p-4" style="display:flex;flex-wrap:wrap;gap:16px;align-items:center;margin-bottom:12px;">
            <div style="text-align:center;min-width:70px;">
              <div style="font-size:32px;font-weight:700;line-height:1;">{{ $averageRating }}</div>
              <div style="color:#F59E0B;font-size:13px;margin:4px 0;">★★★★★</div>
              <div style="font-size:11px;color:var(--muted);">{{ $reviewsCount }} reviews</div>
            </div>
            <div style="flex:1;min-width:160px;display:flex;flex-direction:column;gap:6px;">
              <div style="display:flex;align-items:center;gap:8px;"><span style="font-size:11px;color:var(--muted);width:8px;">5</span><div class="rbar" style="flex:1;"><div class="rbar-fill" style="width:{{ ($c5/$tot)*100 }}%;"></div></div><span style="font-size:11px;color:var(--muted);width:28px;">{{ round(($c5/$tot)*100) }}%</span></div>
              <div style="display:flex;align-items:center;gap:8px;"><span style="font-size:11px;color:var(--muted);width:8px;">4</span><div class="rbar" style="flex:1;"><div class="rbar-fill" style="width:{{ ($c4/$tot)*100 }}%;"></div></div><span style="font-size:11px;color:var(--muted);width:28px;">{{ round(($c4/$tot)*100) }}%</span></div>
              <div style="display:flex;align-items:center;gap:8px;"><span style="font-size:11px;color:var(--muted);width:8px;">3</span><div class="rbar" style="flex:1;"><div class="rbar-fill" style="width:{{ ($c3/$tot)*100 }}%;"></div></div><span style="font-size:11px;color:var(--muted);width:28px;">{{ round(($c3/$tot)*100) }}%</span></div>
              <div style="display:flex;align-items:center;gap:8px;"><span style="font-size:11px;color:var(--muted);width:8px;">2</span><div class="rbar" style="flex:1;"><div class="rbar-fill" style="width:{{ ($c2/$tot)*100 }}%;"></div></div><span style="font-size:11px;color:var(--muted);width:28px;">{{ round(($c2/$tot)*100) }}%</span></div>
              <div style="display:flex;align-items:center;gap:8px;"><span style="font-size:11px;color:var(--muted);width:8px;">1</span><div class="rbar" style="flex:1;"><div class="rbar-fill" style="width:{{ ($c1/$tot)*100 }}%;"></div></div><span style="font-size:11px;color:var(--muted);width:28px;">{{ round(($c1/$tot)*100) }}%</span></div>
            </div>
          </div>

          <div style="display:flex;flex-direction:column;gap:10px;">
            @if(isset($artisanUser->reviewsReceived))
               @forelse($artisanUser->reviewsReceived as $rev)
               <div class="rcard">
                  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                  <div style="display:flex;align-items:center;gap:10px;">
                     <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-pale);color:var(--brand-dark);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0;">
                        {{ strtoupper(substr($rev->user->name ?? 'A', 0, 1)) }}
                     </div>
                     <div>
                        <p style="font-weight:600;font-size:13px;">{{ $rev->user->name ?? 'Anonymous' }}</p>
                        <p style="font-size:11px;color:var(--muted);">{{ $rev->created_at ? $rev->created_at->diffForHumans() : 'Recently' }}</p>
                     </div>
                  </div>
                  <span style="font-size:12px;color:#F59E0B;flex-shrink:0;">
                     {!! str_repeat('★', $rev->rating) !!}{!! str_repeat('<span style="color:#D1D5DB;">★</span>', 5 - $rev->rating) !!}
                  </span>
                  </div>
                  <p style="font-size:13px;color:var(--ink-2);line-height:1.65;">{{ $rev->comment }}</p>
               </div>
               @empty
               <p style="color:var(--muted); text-align:center;">No reviews yet.</p>
               @endforelse
            @endif
          </div>

        </div>

      </div>

      <!-- RIGHT SIDEBAR -->
      <div style="display:flex;flex-direction:column;gap:14px;">

        <div class="card p-5">
          <h3 style="font-size:14px;font-weight:600;margin-bottom:4px;">Book a Consultation</h3>
          <p style="font-size:12px;color:var(--muted);margin-bottom:14px;">Get a custom piece designed for you.</p>
          <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:14px;">
            <div><label>Date</label><input type="date" class="form-field" /></div>
            <div>
              <label>Project type</label>
              <select class="form-field">
                <option>Custom Pottery</option>
                <option>Tile Commission</option>
                <option>Tableware Set</option>
                <option>Decorative Piece</option>
              </select>
            </div>
          </div>
          <button class="btn-primary" style="width:100%;">Request Consultation</button>
        </div>

        <div class="card p-5">
          <h3 style="font-size:14px;font-weight:600;margin-bottom:14px;">Studio Details</h3>
          <div style="display:flex;flex-direction:column;gap:12px;">
            <div><div class="stat-lbl">Location</div><div style="font-size:13px;margin-top:2px;">{{ $artisanUser->artisan->workshopAdresse ?? $artisanUser->city ?? 'Morocco' }}</div></div>
            <hr />
            <div>
               <div class="stat-lbl">Working Hours</div>
               <div style="font-size:13px;margin-top:2px;">
                  @php
                     $hours = $artisanUser->artisan->disponibility ?? 'Mon – Sat, 9am – 5pm';
                     if(is_array($hours)) {
                        echo implode(', ', $hours);
                     } elseif(is_string($hours) && json_decode($hours, true)) {
                        $arr = json_decode($hours, true);
                        echo implode(', ', $arr);
                     } else {
                        echo trim($hours, "[]\"'");
                     }
                  @endphp
               </div>
            </div>
            <hr />
            <div><div class="stat-lbl">Shipping</div><div style="font-size:13px;margin-top:2px;">Worldwide · 7–14 business days</div></div>
            <hr />
            <div><div class="stat-lbl">Response Time</div><div style="font-size:13px;margin-top:2px;">Usually within 2–4 hours</div></div>
          </div>
        </div>

        <div class="card p-5">
          <h3 style="font-size:14px;font-weight:600;margin-bottom:12px;">Share Profile</h3>
          <div style="display:flex;gap:8px;">
            <button class="btn-ghost" style="flex:1;">Copy Link</button>
            <button class="btn-ghost" style="flex:1;">Share</button>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

<!-- FOOTER -->
<footer style="background:#111827;border-top:1px solid #1F2937;">
  <div style="max-width:960px;margin:0 auto;padding:20px 24px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;">
    <span style="font-size:15px;font-weight:700;color:var(--brand);">m3alem</span>
    <p style="font-size:12px;color:#6B7280;">© 2025 m3alem · Connect with Moroccan Artisans. All rights reserved.</p>
    <div style="display:flex;gap:16px;">
      <a href="#" style="font-size:12px;color:#6B7280;text-decoration:none;">Privacy</a>
      <a href="#" style="font-size:12px;color:#6B7280;text-decoration:none;">Terms</a>
      <a href="#" style="font-size:12px;color:#6B7280;text-decoration:none;">Support</a>
    </div>
  </div>
</footer>

<script>
  // Responsive sidebar layout
  function applyLayout() {
    const grid = document.querySelector('.grid-main');
    if (!grid) return;
    if (window.innerWidth >= 768) {
      grid.style.display = 'grid';
      grid.style.gridTemplateColumns = '1fr 280px';
    } else {
      grid.style.display = 'flex';
      grid.style.flexDirection = 'column';
    }
  }
  applyLayout();
  window.addEventListener('resize', applyLayout);

  // Stats grid
  const statsGrid = document.querySelector('[style*="grid-template-columns:repeat(2"]');
  function applyStatsGrid() {
    if (!statsGrid) return;
    statsGrid.style.gridTemplateColumns = window.innerWidth >= 640 ? 'repeat(4,1fr)' : 'repeat(2,1fr)';
  }
  applyStatsGrid();
  window.addEventListener('resize', applyStatsGrid);

  // Tabs
  document.querySelectorAll('.tab').forEach(t => {
    t.addEventListener('click', () => {
      document.querySelectorAll('.tab').forEach(x => x.classList.remove('active'));
      t.classList.add('active');
    });
  });
</script>
</body>
</html>
