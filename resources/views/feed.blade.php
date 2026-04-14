<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — Artisan Feed</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root {
      --terracotta: #C4622D;
      --terracotta-light: #E8855A;
      --terracotta-dark: #A04E22;
      --sand: #F5ECD7;
      --sand-dark: #E8D9BE;
      --ink: #1C1612;
      --ink-muted: #6B5B4E;
      --cream: #FAF6EF;
      --tile-blue: #2E5E8E;
      --gold: #C9A84C;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: var(--cream);
      color: var(--ink);
    }
    .display-font { font-family: 'Playfair Display', serif; }

    /* Zellige tile pattern bg for header */
    .zellige-bg {
      background-color: var(--ink);
      background-image:
        radial-gradient(circle at 25% 25%, rgba(196,98,45,0.15) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(201,168,76,0.1) 0%, transparent 50%);
    }

    /* Card hover effect */
    .craft-card {
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
    }
    .craft-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 60px rgba(28,22,18,0.15);
    }
    .craft-card:hover .card-image img {
      transform: scale(1.06);
    }
    .card-image {
      overflow: hidden;
      border-radius: 12px 12px 0 0;
    }
    .card-image img {
      transition: transform 0.5s ease;
      width: 100%;
      height: 450px;
      object-fit: cover;
      display: block;
      flex-shrink: 0;
      scroll-snap-align: start;
    }

    /* Multi-image scroller */
    .image-scroller {
      display: flex;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      scrollbar-width: none; /* Firefox */
      -ms-overflow-style: none; /* IE/Edge */
      border-radius: 12px 12px 0 0;
    }
    .image-scroller::-webkit-scrollbar {
      display: none; /* Chrome/Safari */
    }
    .scroller-image {
      width: 100%;
      height: 450px;
      object-fit: cover;
      flex-shrink: 0;
      scroll-snap-align: start;
    }

    /* Pill tag */
    .tag {
      display: inline-block;
      padding: 3px 12px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 500;
      letter-spacing: 0.03em;
      border: 1px solid var(--sand-dark);
      color: var(--ink-muted);
      background: var(--sand);
    }

    /* Active filter pill */
    .filter-active {
      background: var(--terracotta);
      color: white;
      border-color: var(--terracotta);
    }

    /* Search bar */
    .search-bar:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(196,98,45,0.2);
    }

    /* Trending hashtag */
    .trending-item {
      position: relative;
      padding-left: 0;
      transition: padding-left 0.2s ease;
    }
    .trending-item:hover { padding-left: 6px; }

    /* Avatar ring */
    .avatar-ring {
      box-shadow: 0 0 0 2px white, 0 0 0 4px var(--terracotta);
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--sand); }
    ::-webkit-scrollbar-thumb { background: var(--terracotta-light); border-radius: 3px; }

    /* Stagger animation */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.5s ease both; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.10s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.20s; }
    .delay-5 { animation-delay: 0.25s; }
    .delay-6 { animation-delay: 0.30s; }

    /* Sidebar section divider */
    .section-divider {
      height: 1px;
      background: linear-gradient(90deg, var(--sand-dark), transparent);
    }

    /* Price badge */
    .price-badge {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      color: var(--terracotta);
      font-size: 1.1rem;
    }

    /* Nav underline */
    .nav-link-active {
      position: relative;
    }
    .nav-link-active::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0; right: 0;
      height: 2px;
      background: var(--terracotta);
      border-radius: 1px;
    }

    /* Ornament */
    .ornament {
      font-size: 10px;
      letter-spacing: 4px;
      color: var(--terracotta);
      opacity: 0.6;
    }

    /* Featured artisan hover */
    .featured-artisan {
      transition: background 0.2s;
      border-radius: 10px;
      padding: 8px 10px;
      margin: 0 -10px;
    }
    .featured-artisan:hover { background: var(--sand); }

    .card-overlay {
      background: linear-gradient(to top, rgba(28,22,18,0.5) 0%, transparent 50%);
      position: absolute;
      inset: 0;
      border-radius: 12px 12px 0 0;
      pointer-events: none;
    }
  </style>
</head>
<body>

<header class="zellige-bg sticky top-0 z-50 shadow-lg">
  <div class="max-w-[1440px] mx-auto px-6 flex items-center justify-between h-16">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="display-font text-2xl font-bold tracking-tight" style="color: var(--terracotta-light);">
      m3alem
    </a>

    <!-- Nav Links -->
    <nav class="hidden md:flex items-center gap-8">
      <a href="{{ route('feed') }}" class="nav-link-active text-sm font-medium" style="color:white;">Feed</a>
      <a href="{{ route('artisans.index') }}" class="text-sm font-medium opacity-60 hover:opacity-100 transition-opacity" style="color:white;">Explore</a>
      <a href="#" class="text-sm font-medium opacity-60 hover:opacity-100 transition-opacity" style="color:white;">Messages</a>
      <a href="#" class="text-sm font-medium opacity-60 hover:opacity-100 transition-opacity" style="color:white;">Saved</a>
    </nav>

    <!-- User -->
    <div class="flex items-center gap-3">
      @auth
      <button class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold avatar-ring" style="background:var(--terracotta);color:white;">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
      </button>
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="text-xs font-semibold px-4 py-2 rounded-full border transition-all hover:bg-white hover:text-gray-900" style="border-color:rgba(255,255,255,0.3);color:white;">
            Logout
          </button>
      </form>
      @else
      <a href="{{ route('login') }}" class="text-xs font-semibold px-4 py-2 rounded-full border transition-all hover:bg-white hover:text-gray-900" style="border-color:rgba(255,255,255,0.3);color:white;">
        Login
      </a>
      @endauth
    </div>
  </div>
</header>


<div class="max-w-[1440px] mx-auto px-6 py-8 grid grid-cols-12 gap-6">

  <aside class="col-span-2 hidden lg:block">
    <div class="sticky top-24 space-y-6">

      <!-- Navigation -->
      <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <p class="text-xs font-semibold uppercase tracking-widest mb-4" style="color:var(--ink-muted);">Navigation</p>
        <nav class="space-y-1">
          <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all" style="background:var(--sand);color:var(--terracotta);">
            <span>🏠</span> Home
          </a>
          <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            <span>🔍</span> Explore
          </a>
          <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            <span>💬</span> Messages
          </a>
          <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            <span>🔖</span> Saved
          </a>
          <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            <span>👤</span> Profile
          </a>
        </nav>
      </div>

      <!-- Quick Links -->
      <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <p class="text-xs font-semibold uppercase tracking-widest mb-4" style="color:var(--ink-muted);">Quick Links</p>
        <div class="space-y-2">
          <a href="#" class="block text-sm py-1.5 transition-colors hover:text-terracotta" style="color:var(--ink-muted);">Browse All Artisans</a>
          <a href="#" class="block text-sm py-1.5 transition-colors hover:text-terracotta" style="color:var(--ink-muted);">How It Works</a>
          <a href="#" class="block text-sm py-1.5 transition-colors hover:text-terracotta" style="color:var(--ink-muted);">Support</a>
        </div>
      </div>
    </div>
  </aside>


  <main class="col-span-12 lg:col-span-7 space-y-6">

    <!-- Search + Filters -->
    <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
      <div class="relative mb-4">
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 opacity-40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input
          type="text"
          placeholder="Search artisans, crafts, materials…"
          class="search-bar w-full pl-11 pr-4 py-3 rounded-xl text-sm border transition-all"
          style="border-color:var(--sand-dark);background:var(--cream);color:var(--ink);"
        />
      </div>
      <div class="flex gap-2 flex-wrap">
        <button class="filter-active tag">All</button>
        <button class="tag hover:border-terracotta transition-colors" style="cursor:pointer;">Pottery</button>
        <button class="tag hover:border-terracotta transition-colors" style="cursor:pointer;">Weaving</button>
        <button class="tag hover:border-terracotta transition-colors" style="cursor:pointer;">Leather</button>
        <button class="tag hover:border-terracotta transition-colors" style="cursor:pointer;">Metalwork</button>
        <button class="tag hover:border-terracotta transition-colors" style="cursor:pointer;">Ceramics</button>
        <button class="tag hover:border-terracotta transition-colors" style="cursor:pointer;">Woodwork</button>
      </div>
    </div>

    <!-- Single Column Feed -->
    <div class="max-w-xl mx-auto space-y-8">

      @forelse($posts as $post)
      <div class="craft-card fade-up delay-1 rounded-2xl overflow-hidden" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.07);">
        <div class="card-image relative">
          @php
              $defaultImages = [
                  'Artisan Woman Weaving Traditional Moroccan Baskets.jpeg',
                  'Broderie de Fez.jpeg',
                  'L’Artisanat Marocain _ Un Héritage de Savoir-Faire Authentique.jpeg',
                  'Pottery Painting, Morocco.jpeg',
                  'Tapis Marocaine.jpeg',
                  'artisanat au maroc - Page 7.jpeg',
                  'image 26.png', 'image 34.png', 'image 35.png', 'image 36.png', 'image 37.png', 
                  'image 38.png', 'image 39.png', 'image 40.png', 'image 41.png', 'image 42.png',
                  'Кожевенные красильни Марракеша.jpeg',
                  'Разноцветье Марокко рядом.jpeg'
              ];
              $imageIndex = (int) $post->id % count($defaultImages);
              $placeholderImage = $defaultImages[$imageIndex];
              
              // Get all images
              $allImages = [];
              if ($post->images && is_array($post->images)) {
                  $allImages = $post->images;
              } elseif ($post->images && is_string($post->images)) {
                  $allImages = json_decode($post->images, true) ?? [];
              }
          @endphp

          <div class="image-scroller">
            @if(count($allImages) > 0)
              @foreach($allImages as $img)
                @php $isSeederPlaceholder = $img && str_contains($img, 'unsplash.com'); @endphp
                @if(!$isSeederPlaceholder)
                  @php
                    $imgPath = 'storage/' . $img;
                    if (!str_starts_with($img, 'http') && file_exists(public_path('images/' . $img))) {
                        $imgPath = 'images/' . $img;
                    }
                  @endphp
                  <img src="{{ str_starts_with($img, 'http') ? $img : asset($imgPath) }}" class="scroller-image" alt="{{ $post->title }}" />
                @else
                  <img src="{{ asset('images/' . $placeholderImage) }}" class="scroller-image" alt="{{ $post->title }}" />
                @endif
              @endforeach
            @else
              <img src="{{ asset('images/' . $placeholderImage) }}" class="scroller-image" alt="{{ $post->title }}" />
            @endif
          </div>
          
          @if(count($allImages) > 1)
            <div class="absolute bottom-4 right-4 bg-black/50 text-white text-[10px] px-2 py-1 rounded-full backdrop-blur-sm pointer-events-none">
              1 / {{ count($allImages) }}
            </div>
          @endif
          <div class="card-overlay"></div>
        </div>
        <div class="p-4">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 avatar-ring" style="background:var(--terracotta);color:white;">
              {{ ($post->artisan && $post->artisan->user) ? strtoupper(substr($post->artisan->user->name, 0, 1)) : 'A' }}
            </div>
            <div>
              <p class="text-sm font-semibold leading-tight" style="color:var(--ink);">{{ ($post->artisan && $post->artisan->user) ? $post->artisan->user->name : 'Unknown Artisan' }}</p>
              <p class="text-xs" style="color:var(--ink-muted);">{{ $post->category ?? 'Category' }}</p>
            </div>
          </div>
          <p class="text-sm font-bold mb-1" style="color:var(--ink);">{{ $post->title }}</p>
          <p class="text-sm leading-relaxed mb-3" style="color:var(--ink-muted);">{{ Str::limit($post->description, 80) }}</p>
          <div class="flex gap-2 mb-4 flex-wrap">
            @if($post->tags && is_array($post->tags))
                @foreach($post->tags as $tag)
                    <span class="tag">{{ $tag }}</span>
                @endforeach
            @elseif($post->tags && is_string($post->tags))
                @foreach(json_decode($post->tags, true) ?? explode(',', $post->tags) as $tag)
                    <span class="tag">{{ trim($tag) }}</span>
                @endforeach
            @endif
          </div>
          <div class="flex items-center justify-between">
            <span class="price-badge">
                <!-- Using a default price since price isn't in Post model, or omit it -->
            </span>
            <button class="text-xs font-semibold px-4 py-2 rounded-full transition-all hover:opacity-80" style="background:var(--sand);color:var(--terracotta);">View Craft</button>
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center py-12">
          <p style="color:var(--ink-muted);">No crafts have been posted yet.</p>
      </div>
      @endforelse

    </div>

    <!-- Load More / Pagination -->
    <div class="pt-4 pb-6 mt-6">
      {{ $posts->links() }}
    </div>

  </main>


  <aside class="col-span-3 hidden lg:block">
    <div class="sticky top-24 space-y-5">

      <!-- Trending Categories -->
      <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <div class="flex items-center gap-2 mb-1">
          <p class="text-sm font-bold display-font" style="color:var(--ink);">Trending Categories</p>
        </div>
        <p class="ornament mb-4">✦ ✦ ✦</p>
        <div class="space-y-3">
          <div class="trending-item flex items-center justify-between cursor-pointer">
            <div>
              <p class="text-sm font-semibold" style="color:var(--terracotta);">#MoroccanPottery</p>
              <p class="text-xs" style="color:var(--ink-muted);">12.4K posts</p>
            </div>
            <span class="text-xs px-2 py-1 rounded-full font-medium" style="background:var(--sand);color:var(--terracotta);">🔥</span>
          </div>
          <div class="section-divider"></div>
          <div class="trending-item flex items-center justify-between cursor-pointer">
            <div>
              <p class="text-sm font-semibold" style="color:var(--tile-blue);">#ArtisanCrafts</p>
              <p class="text-xs" style="color:var(--ink-muted);">9.1K posts</p>
            </div>
          </div>
          <div class="section-divider"></div>
          <div class="trending-item flex items-center justify-between cursor-pointer">
            <div>
              <p class="text-sm font-semibold" style="color:var(--terracotta);">#TraditionalWeaving</p>
              <p class="text-xs" style="color:var(--ink-muted);">7.8K posts</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Featured Artisans -->
      <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <div class="flex items-center gap-2 mb-1">
          <p class="text-sm font-bold display-font" style="color:var(--ink);">Featured Artisans</p>
        </div>
        <p class="ornament mb-4">✦ ✦ ✦</p>
        <div class="space-y-1">

          <div class="featured-artisan flex items-center gap-3 cursor-pointer">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 avatar-ring" style="background:var(--terracotta);color:white;">F</div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold truncate" style="color:var(--ink);">Fatima Al-Mansouri</p>
              <p class="text-xs" style="color:var(--ink-muted);">Master Potter</p>
            </div>
          </div>

          <div class="featured-artisan flex items-center gap-3 cursor-pointer">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 avatar-ring" style="background:var(--tile-blue);color:white;">H</div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold truncate" style="color:var(--ink);">Hassan El-Khayat</p>
              <p class="text-xs" style="color:var(--ink-muted);">Textile Weaver</p>
            </div>
          </div>

        </div>

        <div class="mt-4 pt-4" style="border-top:1px solid var(--sand-dark);">
          <a href="#" class="text-xs font-semibold" style="color:var(--terracotta);">View all artisans →</a>
        </div>
      </div>

      <!-- Footer note -->
      <p class="text-center text-xs px-4" style="color:var(--ink-muted);opacity:0.6;">
        m3alem · Celebrating Moroccan Craft Heritage
      </p>

    </div>
  </aside>

</div>

<script>
  // Filter pill interaction
  document.querySelectorAll('.tag[style*="cursor"]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tag').forEach(t => t.classList.remove('filter-active'));
      btn.classList.add('filter-active');
    });
  });
  // Also handle "All" pill click
  document.querySelector('.filter-active').addEventListener('click', function() {
    document.querySelectorAll('.tag').forEach(t => t.classList.remove('filter-active'));
    this.classList.add('filter-active');
  });
  // Image scroller counter
  document.querySelectorAll('.image-scroller').forEach(scroller => {
    scroller.addEventListener('scroll', () => {
      const index = Math.round(scroller.scrollLeft / scroller.clientWidth) + 1;
      const counter = scroller.parentElement.querySelector('.absolute.bottom-4.right-4');
      if (counter) {
        const total = scroller.querySelectorAll('.scroller-image').length;
        counter.innerText = `${index} / ${total}`;
      }
    });
  });
</script>

</body>
</html>
