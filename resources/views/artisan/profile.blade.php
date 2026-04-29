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

    .navbar { background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
    .hero   { height: 320px; background: linear-gradient(135deg, #111827 0%, #1F2937 100%); position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; inset: 0; background-image: radial-gradient(circle at 70% 30%, rgba(196,98,45,0.15) 0%, transparent 70%); }
    .card   { background: #fff; border: 1px solid var(--border); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }

    .btn-primary  { background: var(--brand); color: #fff; font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; transition: background .15s; }
    .btn-primary:hover { background: var(--brand-dark); transform: translateY(-1px); }
    .btn-ghost     { background: transparent; color: var(--ink-2); font-size: 13px; font-weight: 600; padding: 10px 22px; border-radius: 999px; border: 1.5px solid var(--border); cursor: pointer; transition: all .2s; }
    .btn-ghost:hover { border-color: var(--brand); color: var(--brand); }

    .tag { display: inline-block; background: rgba(196, 98, 45, 0.08); color: var(--brand); font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 999px; border: 1px solid rgba(196, 98, 45, 0.1); }

    .stat-val { font-size: 24px; font-weight: 800; line-height: 1.1; color: var(--ink); }
    .stat-lbl { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .1em; margin-top: 4px; }

    .pcard { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; cursor: pointer; transition: all .3s cubic-bezier(0.4, 0, 0.2, 1); }
    .pcard:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.06); border-color: var(--brand-pale); }
    .pcard img { width: 100%; height: 180px; object-fit: cover; display: block; }

    .rcard { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 16px; }

    .rbar { height: 5px; border-radius: 3px; background: var(--border); flex: 1; overflow: hidden; }
    .rbar-fill { height: 100%; border-radius: 3px; background: #F59E0B; }

    .tab { font-size: 13px; font-weight: 500; color: var(--muted); padding-bottom: 10px; cursor: pointer; border-bottom: 2px solid transparent; white-space: nowrap; }
    .tab.active { color: var(--ink); border-bottom-color: var(--brand); }

    .form-field { width: 100%; padding: 8px 10px; border: 1px solid var(--border); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 13px; color: var(--ink); outline: none; }
    .form-field:focus { border-color: var(--brand); }
    label { font-size: 11px; font-weight: 500; color: var(--muted); display: block; margin-bottom: 4px; }

    .avatar { width: 140px; height: 140px; border-radius: 100%; border: 2px solid #fff; object-fit: cover; box-shadow: 0 20px 40px rgba(0,0,0,.15); position: relative; z-index: 2; }

    .badge-green { display: inline-block; background: #ECFDF5; color: #065F46; font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 4px; }

    hr { border: none; border-top: 1px solid var(--border); }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 3px; }
  </style>
</head>
<body>


<header class="navbar">
  <div style="max-width:1280px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;height:64px;">
    <span style="font-size:20px;font-weight:800;color:var(--brand);letter-spacing:-0.5px;">m3alem</span>
    <nav style="display:flex;gap:24px;">
      <a href="{{ route('feed') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Feed</a>
      <a href="{{ route('artisans.index') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Artisans</a>
      <a href="#" style="font-size:13px;font-weight:600;color:var(--ink);text-decoration:none;">Profile</a>
      @auth
        @if(Auth::user()->role === 'artisan')
          <a href="{{ route('artisan.dashboard') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Dashboard</a>
        @else
          <a href="{{ route('dashboard') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Account</a>
        @endif
      @else
        <a href="{{ route('login') }}" style="font-size:13px;font-weight:500;color:var(--muted);text-decoration:none;">Login</a>
      @endauth
    </nav>
  </div>
</header>


<div class="hero">
    <div style="max-width:1280px; margin:0 auto; padding:0 24px; height:100%; display:flex; align-items:flex-end; padding-bottom:80px;">
        <div style="color:white; opacity: 0.6; font-size:12px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">Authentic Moroccan Heritage</div>
    </div>
</div>

<div style="max-width:1280px;margin:0 auto;padding:0 24px;">

  @if(session('success'))
    <div style="background: #ECFDF5; color: #065F46; padding: 12px 16px; border-radius: 8px; margin-top: 16px; font-weight: 500; font-size: 13px;">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background: #FEF2F2; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-top: 16px; font-weight: 500; font-size: 13px;">
      {{ session('error') }}
    </div>
  @endif

  <div class="card p-5 md:p-6" style="margin-top:-48px;margin-bottom:16px; position:relative; z-index:10;">
    <div style="display:flex;flex-wrap:wrap;gap:32px; align-items: flex-start;">
      <div style="position:relative; margin-top:-80px;">
          <img src="{{ asset('images/profile.webp') }}" class="avatar" />
      </div>

      <div style="flex:1;min-width:300px; padding-top:10px;">
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:12px;margin-bottom:8px;">
          <h1 style="font-size:32px;font-weight:800;letter-spacing:-1px;">{{ $artisanUser->name }}</h1>
        </div>
        <p style="color:var(--muted);margin-bottom:12px;font-size:15px; font-weight:500;">
          <span style="color:var(--brand); text-transform:uppercase; letter-spacing:1px; font-weight:700;">{{ $artisanUser->artisan->service ?? 'Artisan' }}</span>
          &nbsp;·&nbsp; {{ $artisanUser->city ?? 'Morocco' }} &nbsp;·&nbsp;
          <span style="color:#F59E0B; font-weight:700;">★ {{ $averageRating }}</span>
          <span style="color:var(--muted); font-weight:400;"> ({{ $reviewsCount }} reviews)</span>
        </p>
        <p style="color:var(--ink-2);max-width:560px;line-height:1.65;margin-bottom:14px;font-size:13px;">
          {{ $artisanUser->artisan->experience ?? 'Passionate Moroccan artisan crafting authentic pieces.' }}
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;">
          @php
             $certs = $artisanUser->artisan->certifications ?? [];
             if (is_string($certs)) {
                $decoded = json_decode($certs, true);
                $certs = is_array($decoded) ? $decoded : [$certs];
             }
          @endphp
          @foreach($certs as $tag)
             <span class="tag">{{ trim($tag, "\[\]\"'") }}</span>
          @endforeach
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <button class="btn-primary">Book Consultation</button>
        </div>
      </div>

      <div style="border-left:1px solid var(--border);padding-left:20px;display:flex;flex-direction:column;gap:14px;min-width:130px;" class="hidden md:flex">
        <div>
          <div class="stat-lbl">Response Time</div>
          <div style="font-size:14px;font-weight:600;margin-top:2px;">2 – 4 hours</div>
        </div>

        <div>
          <div class="stat-lbl">Member Since</div>
          <div style="font-size:14px;font-weight:600;margin-top:2px;">{{ $artisanUser->created_at->format('F Y') }}</div>
        </div>
      </div>

    </div>
  </div>



  <!-- COLUMNS -->
  <div style="display:grid;grid-template-columns:1fr;gap:32px;padding-bottom:60px;" class="lg:grid-cols-3-custom">

    <div style="display:grid;grid-template-columns:1fr 320px;gap:32px;align-items:start;" class="grid-main">

      <!-- LEFT -->
      <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- Tabs -->
        <div style="display:flex;gap:24px;border-bottom:1px solid var(--border);">
          <span class="tab active">Portfolio</span>
      
        </div>

        <!-- Portfolio -->
        <div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h2 style="font-size:14px;font-weight:600;">Featured Portfolio</h2>
            <a href="#" style="font-size:12px;font-weight:500;color:var(--brand);text-decoration:none;">View all</a>
          </div>
          <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
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
                  </div>
               </div>
               @empty
               <p style="grid-column: 1 / -1; color: var(--muted); padding: 20px;">No active listings found.</p>
               @endforelse
            @endif

          

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

          <!-- Submit Review Form -->
          @auth
            @if(Auth::user()->role === 'client' && Auth::id() !== $artisanUser->id)
                <div class="card p-5 mb-4" style="background:var(--brand-pale); border-color:var(--brand); margin-bottom: 16px;">
                    <h3 style="font-size:14px;font-weight:600;margin-bottom:12px;color:var(--brand-dark);">Leave a Review</h3>
                    <form action="{{ route('reviews.store', $artisanUser->id) }}" method="POST">
                        @csrf
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label style="color:var(--brand-dark);">Rating</label>
                                <select name="note" class="form-field" style="background: white;" required>
                                    <option value="5">5 ★★★★★ - Excellent</option>
                                    <option value="4">4 ★★★★☆ - Good</option>
                                    <option value="3">3 ★★★☆☆ - Average</option>
                                    <option value="2">2 ★★☆☆☆ - Poor</option>
                                    <option value="1">1 ★☆☆☆☆ - Terrible</option>
                                </select>
                            </div>
                            <div>
                                <label style="color:var(--brand-dark);">Comment (Optional)</label>
                                <textarea name="comment" class="form-field" style="height:80px; background: white;" placeholder="Tell us about your experience with this artisan..."></textarea>
                            </div>
                            <button type="submit" class="btn-primary" style="align-self:flex-start; background:var(--brand-dark);">Submit Review</button>
                        </div>
                    </form>
                </div>
            @endif
          @endauth

          <div style="display:flex;flex-direction:column;gap:10px;">
            @if(isset($artisanUser->reviewsReceived))
               @forelse($artisanUser->reviewsReceived as $rev)
               <div class="rcard">
                  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                  <div style="display:flex;align-items:center;gap:10px;">
                     <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-pale);color:var(--brand-dark);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0;">
                        {{ strtoupper(substr($rev->client->name ?? 'A', 0, 1)) }}
                     </div>
                     <div>
                        <p style="font-weight:600;font-size:13px;">{{ $rev->client->name ?? 'Anonymous' }}</p>
                        <p style="font-size:11px;color:var(--muted);">{{ $rev->created_at ? $rev->created_at->diffForHumans() : 'Recently' }}</p>
                     </div>
                  </div>
                  <span style="font-size:12px;color:#F59E0B;flex-shrink:0;">
                     {!! str_repeat('★', $rev->note ?? 5) !!}{!! str_repeat('<span style="color:#D1D5DB;">★</span>', 5 - ($rev->note ?? 5)) !!}
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

        @auth
            @if(Auth::user()->role === 'client')
                <div class="card p-5" style="border: 1px solid var(--brand); background: var(--brand-pale);">
                    <h3 style="font-size:14px;font-weight:600;margin-bottom:4px;color:var(--brand-dark);">Service de Médiation</h3>
                    <p style="font-size:12px;color:var(--ink-2);margin-bottom:14px;">Secure delivery & quality assurance by a Maalem mediator.</p>
                    
                    <form action="{{ route('deliveries.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="artisan_id" value="{{ $artisanUser->artisan->id }}">
                        
                        <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:14px;">
                            <div>
                                <label>Delivery Address</label>
                                <input type="text" name="adresse" class="form-field" placeholder="Full address..." required />
                            </div>
                            <div>
                                <label>Preferred Date</label>
                                <input type="date" name="deliveryDate" class="form-field" required />
                            </div>
                            <div>
                                <label>Project Description</label>
                                <textarea name="description" class="form-field" style="height:60px;" placeholder="What do you need handled?" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%;background:var(--brand-dark);">Request Secure Delivery</button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="card p-5">
          <h3 style="font-size:14px;font-weight:600;margin-bottom:14px;">Studio Details</h3>
          <div style="display:flex;flex-direction:column;gap:12px;">
            <div>
              <div class="stat-lbl">Location</div>
              <div style="font-size:13px;margin-top:2px;">{{ $artisanUser->artisan->workshopAdresse ?? $artisanUser->city ?? 'Morocco' }}</div>
              <div style="margin-top:12px; height:150px; border-radius:8px; overflow:hidden; border:1px solid var(--border);">
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
            <hr />
            <div>
               <div class="stat-lbl">Working On</div>
               <div style="font-size:13px;margin-top:2px;">
                  @php
                     $hours = $artisanUser->artisan->disponibility ?? 'Mon – Sat, 9am – 5pm';
                     if (is_string($hours)) {
                        $decoded = json_decode($hours, true);
                        if (is_array($decoded)) {
                           echo implode(', ', $decoded);
                        } else {
                           echo trim($hours, "[]\"'");
                        }
                     } elseif (is_array($hours)) {
                        echo implode(', ', $hours);
                     } else {
                        echo $hours;
                     }
                  @endphp
               </div>
            </div>
            <hr />
            <hr />
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

<footer style="background:#111827;border-top:1px solid #1F2937;">
  <div style="max-width:1280px;margin:0 auto;padding:40px 24px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:24px;">
    <div>
        <span style="font-size:20px;font-weight:800;color:var(--brand);display:block;margin-bottom:8px;">m3alem</span>
        <p style="font-size:13px;color:#6B7280;max-width:300px;line-height:1.6;">Celebrating Moroccan craftsmanship by connecting master artisans with the world.</p>
    </div>
    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:12px;">
        <div style="display:flex;gap:24px;">
            <a href="#" style="font-size:13px;color:#9CA3AF;text-decoration:none;">Privacy Policy</a>
            <a href="#" style="font-size:13px;color:#9CA3AF;text-decoration:none;">Terms of Service</a>
            <a href="#" style="font-size:13px;color:#9CA3AF;text-decoration:none;">Support</a>
        </div>
        <p style="font-size:13px;color:#4B5563;">© 2025 m3alem. All rights reserved.</p>
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
      grid.style.gridTemplateColumns = '1fr 320px';
      grid.style.gap = '32px';
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
