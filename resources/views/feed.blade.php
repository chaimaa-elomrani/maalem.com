<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — Artisan Feed</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

    .header-bg {
      background-color: var(--ink);
    }

    .craft-card {
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
    }
    .craft-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 60px rgba(28,22,18,0.15);
    }
    .card-image {
      overflow: hidden;
      border-radius: 12px 12px 0 0;
    }
    .card-image img {
      width: 100%;
      height: 450px;
      object-fit: cover;
      display: block;
      flex-shrink: 0;
      scroll-snap-align: start;
    }

    .image-scroller {
      display: flex;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      scrollbar-width: none;
      -ms-overflow-style: none;
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

    .section-divider {
      height: 1px;
      background: linear-gradient(90deg, var(--sand-dark), transparent);
    }

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
    /* Interaction bar */
    .interaction-bar {
      display: flex;
      gap: 16px;
      padding: 12px 16px 8px;
    }
    .interaction-icon {
      width: 24px;
      height: 24px;
      cursor: pointer;
      color: var(--ink);
      transition: transform 0.1s ease, color 0.2s ease;
    }
    .interaction-icon:hover {
      transform: scale(1.1);
      color: var(--terracotta);
    }
    .interaction-icon:active {
      transform: scale(0.9);
    }

    /* Comment Modal */
    .comment-overlay {
      position: fixed;
      inset: 0;
      background: rgba(28,22,18,0.5);
      backdrop-filter: blur(6px);
      z-index: 999;
      display: none;
      align-items: center;
      justify-content: center;
      animation: overlayIn 0.25s ease;
    }
    .comment-overlay.active {
      display: flex;
    }
    @keyframes overlayIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }
    .comment-modal {
      background: white;
      border-radius: 20px;
      width: 95%;
      max-width: 520px;
      max-height: 80vh;
      display: flex;
      flex-direction: column;
      box-shadow: 0 24px 80px rgba(28,22,18,0.25);
      animation: modalSlideUp 0.35s cubic-bezier(0.34,1.56,0.64,1);
      overflow: hidden;
    }
    @keyframes modalSlideUp {
      from { opacity: 0; transform: translateY(40px) scale(0.96); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .comment-modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 22px;
      border-bottom: 1px solid var(--sand-dark);
      flex-shrink: 0;
    }
    .comment-modal-header h3 {
      font-family: 'Playfair Display', serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--ink);
    }
    .comment-modal-close {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: none;
      background: var(--sand);
      color: var(--ink-muted);
      font-size: 18px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.15s, color 0.15s;
    }
    .comment-modal-close:hover {
      background: var(--terracotta);
      color: white;
    }
    .comment-modal-body {
      flex: 1;
      overflow-y: auto;
      padding: 16px 22px;
      min-height: 120px;
    }
    .comment-item {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--sand);
      animation: fadeUp 0.3s ease both;
    }
    .comment-item:last-child {
      border-bottom: none;
    }
    .comment-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--terracotta);
      color: white;
      font-size: 13px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .comment-content {
      flex: 1;
    }
    .comment-author {
      font-size: 13px;
      font-weight: 600;
      color: var(--ink);
      margin-bottom: 2px;
    }
    .comment-text {
      font-size: 13px;
      line-height: 1.55;
      color: var(--ink-muted);
    }
    .comment-time {
      font-size: 11px;
      color: var(--ink-muted);
      opacity: 0.6;
      margin-top: 4px;
    }
    .comment-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      text-align: center;
    }
    .comment-empty svg {
      width: 56px;
      height: 56px;
      color: var(--sand-dark);
      margin-bottom: 16px;
    }
    .comment-empty p {
      font-size: 15px;
      font-weight: 600;
      color: var(--ink);
      margin-bottom: 4px;
    }
    .comment-empty span {
      font-size: 13px;
      color: var(--ink-muted);
    }
    .comment-modal-footer {
      padding: 14px 22px;
      border-top: 1px solid var(--sand-dark);
      flex-shrink: 0;
    }
    .comment-form {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .comment-input {
      flex: 1;
      padding: 10px 16px;
      border: 1px solid var(--sand-dark);
      border-radius: 999px;
      font-family: 'DM Sans', sans-serif;
      font-size: 13px;
      color: var(--ink);
      background: var(--cream);
      outline: none;
      transition: border-color 0.15s, box-shadow 0.15s;
    }
    .comment-input:focus {
      border-color: var(--terracotta);
      box-shadow: 0 0 0 3px rgba(196,98,45,0.12);
    }
    .comment-submit {
      padding: 10px 20px;
      border: none;
      border-radius: 999px;
      background: var(--terracotta);
      color: white;
      font-family: 'DM Sans', sans-serif;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.15s, transform 0.1s;
    }
    .comment-submit:hover {
      background: var(--terracotta-dark);
    }
    .comment-submit:active {
      transform: scale(0.96);
    }
  </style>
</head>
<body>

<header class="header-bg sticky top-0 z-50 shadow-lg">
  <div class="max-w-[1440px] mx-auto px-6 flex items-center justify-between h-16">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="display-font text-2xl font-bold tracking-tight" style="color: var(--terracotta-light);">
      m3alem
    </a>

    <nav class="hidden md:flex items-center gap-8">
      <a href="{{ route('feed') }}" class="nav-link-active text-sm font-medium" style="color:white;">Feed</a>
      <a href="{{ route('artisans.index') }}" class="text-sm font-medium opacity-60 hover:opacity-100 transition-opacity" style="color:white;">Explore</a>
      <a href="#" class="text-sm font-medium opacity-60 hover:opacity-100 transition-opacity" style="color:white;">Messages</a>
      <a href="#" class="text-sm font-medium opacity-60 hover:opacity-100 transition-opacity" style="color:white;">Saved</a>
    </nav>

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

      <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <p class="text-xs font-semibold uppercase tracking-widest mb-4" style="color:var(--ink-muted);">Navigation</p>
        <nav class="space-y-1">
          <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all" style="background:var(--sand);color:var(--terracotta);">
            Home
          </a>
          <a href="{{ route('artisans.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            Explore
          </a>
          <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            Messages
          </a>
          <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            Saved
          </a>
          <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-gray-50" style="color:var(--ink-muted);">
            Profile
          </a>
        </nav>
      </div>

      </div>

    <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <p class="text-xs font-semibold uppercase tracking-widest mb-4" style="color:var(--ink-muted);">Quick Links</p>
        <div class="space-y-2">
          <a href="#" class="block text-sm py-1.5 transition-colors hover:text-terracotta" style="color:var(--ink-muted);">Browse All Artisans</a>
          <a href="#" class="block text-sm py-1.5 transition-colors hover:text-terracotta" style="color:var(--ink-muted);">How It Works</a>
          <a href="#" class="block text-sm py-1.5 transition-colors hover:text-terracotta" style="color:var(--ink-muted);">Support</a>
        </div>
      </div>
  </aside>


  <main class="col-span-12 lg:col-span-7 space-y-6">

    <div class="max-w-xl mx-auto rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
      <form id="search-form" class="relative mb-4" onsubmit="handleSearch(event)">
        <input
          type="text"
          id="search-input"
          placeholder="Search for artisans or crafts..."
          value="{{ request('search') }}"
          class="search-bar w-full px-4 py-3 rounded-xl text-sm border transition-all"
          style="border-color:var(--sand-dark);background:var(--cream);color:var(--ink);"
        />
        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 hover:opacity-70 transition-opacity">
          <svg style="width:18px;height:18px;color:var(--ink-muted);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
      </form>
      <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide flex-nowrap items-center">
        <div id="clear-filters-container" class="hidden">
           <a href="#" onclick="clearFilters()" class="text-xs font-semibold mr-2" style="color:var(--terracotta);">Clear All ×</a>
        </div>
        <a href="#" onclick="setCategory(null)" class="category-tag tag {{ !request('category') ? 'filter-active' : '' }}">All</a>
        @foreach(['Pottery', 'Weaving', 'Leather', 'Metalwork', 'Ceramics', 'Woodwork'] as $cat)
          <a href="#" 
             onclick="setCategory('{{ $cat }}')"
             class="category-tag tag {{ request('category') === $cat ? 'filter-active' : '' }} hover:border-terracotta transition-colors" 
             style="cursor:pointer;">{{ $cat }}</a>
        @endforeach
      </div>
    </div>

    <div id="posts-container" class="max-w-xl mx-auto space-y-8 mt-6">
      <!-- Posts will be loaded here via API -->
      <div id="feed-loader" class="text-center py-12">
        <div class="inline-block w-8 h-8 border-4 border-terracotta border-t-transparent rounded-full animate-spin"></div>
        <p class="mt-4 text-sm font-medium" style="color:var(--ink-muted);">Curating the finest crafts...</p>
      </div>
    </div>

    <div id="empty-state" class="hidden max-w-xl mx-auto text-center py-12">
        <p style="color:var(--ink-muted);">No crafts matches your search.</p>
    </div>

    <!-- Load More Trigger for Infinite Scroll -->
    <div id="infinite-scroll-trigger" class="h-20"></div>

  </main>


  <aside class="col-span-3 hidden lg:block">
    <div class="sticky top-24 space-y-5">

      <!-- Trending Categories -->
      <div class="rounded-2xl p-5" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.06);">
        <div class="flex items-center gap-2 mb-1">
          <p class="text-sm font-bold display-font" style="color:var(--ink);">Trending Categories</p>
        </div>

        <div class="space-y-3">
          <div class="trending-item flex items-center justify-between cursor-pointer">
            <div>
              <p class="text-sm font-semibold" style="color:var(--terracotta);">#MoroccanPottery</p>
              <p class="text-xs" style="color:var(--ink-muted);">12.4K posts</p>
            </div>
            <span class="text-xs px-2 py-1 rounded-full font-medium" style="background:var(--sand);color:var(--terracotta);">Trending</span>
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

        <div class="space-y-1">

          <div class="featured-artisan flex items-center gap-3 cursor-pointer">
            <img src="{{ asset('images/profile.webp') }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0 avatar-ring" alt="Artisan Profile" />
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold truncate" style="color:var(--ink);">Fatima Al-Mansouri</p>
              <p class="text-xs" style="color:var(--ink-muted);">Master Potter</p>
            </div>
          </div>

          <div class="featured-artisan flex items-center gap-3 cursor-pointer">
            <img src="{{ asset('images/profile.webp') }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0 avatar-ring" alt="Artisan Profile" />
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

  function openCommentModal(postId) {
    const modal = document.getElementById('comment-modal-' + postId);
    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeCommentModal(event, postId) {
    if (event.target === event.currentTarget) {
      closeCommentModalDirect(postId);
    }
  }

  function closeCommentModalDirect(postId) {
    const modal = document.getElementById('comment-modal-' + postId);
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  // Close on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.comment-overlay.active').forEach(modal => {
        modal.classList.remove('active');
      });
      document.body.style.overflow = '';
    }
  });

  // API Config
  const CONFIG = {
    auth: @json(auth()->check()),
    loginUrl: "{{ route('login') }}",
    placeholderImages: [
      'Artisan Woman Weaving Traditional Moroccan Baskets.jpeg',
      'Broderie de Fez.jpeg',
      'L’Artisanat Marocain _ Un Héritage de Savoir-Faire Authentique.jpeg',
      'Pottery Painting, Morocco.jpeg',
      'Tapis Marocaine.jpeg',
      'artisanat au maroc - Page 7.jpeg',
      'image 26.png', 'image 34.png', 'image 35.png', 'image 36.png', 'image 37.png', 
      'image 38.png', 'image 39.png', 'image 40.png', 'image 41.png', 'image 42.png',
      'jpeg(1)',
      'Кожевенные красильни Марракеша.jpeg',
      'Разноцветье Марокко рядом.jpeg'
    ],
    assetImages: "{{ asset('images/') }}/",
    assetStorage: "{{ asset('storage/') }}/",
  };

  let currentPage = 1;
  let currentSearch = '{{ request('search', '') }}';
  let currentCategory = '{{ request('category', '') }}';
  let isLoading = false;
  let hasMore = true;

  const container = document.getElementById('posts-container');
  const loader = document.getElementById('feed-loader');
  const emptyState = document.getElementById('empty-state');
  const clearFiltersBtn = document.getElementById('clear-filters-container');

  function truncateText(text, limit = 80) {
    if (!text) return '';
    return text.length > limit ? text.substring(0, limit) + '...' : text;
  }

  function timeAgo(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    let interval = Math.floor(seconds / 31536000);
    if (interval > 1) return interval + " years ago";
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) return interval + " months ago";
    interval = Math.floor(seconds / 86400);
    if (interval > 1) return interval + " days ago";
    interval = Math.floor(seconds / 3600);
    if (interval > 1) return interval + " hours ago";
    interval = Math.floor(seconds / 60);
    if (interval > 1) return interval + " minutes ago";
    return Math.floor(seconds) + " seconds ago";
  }

  function initFeed() {
    loadPosts(true);
    setupInfiniteScroll();
  }

  async function loadPosts(reset = false) {
    if (isLoading || (!hasMore && !reset)) return;
    
    isLoading = true;
    if (reset) {
      currentPage = 1;
      hasMore = true;
      container.innerHTML = '';
      emptyState.classList.add('hidden');
    }
    loader.classList.remove('hidden');

    if (currentSearch || currentCategory) {
      clearFiltersBtn.classList.remove('hidden');
    } else {
      clearFiltersBtn.classList.add('hidden');
    }

    try {
      const params = new URLSearchParams({
        page: currentPage,
        search: currentSearch,
        category: currentCategory
      });

      const response = await fetch(`/feed?${params.toString()}`, {
        headers: { 'Accept': 'application/json' }
      });
      const data = await response.json();

      if (reset && data.data.length === 0) {
        emptyState.classList.remove('hidden');
      }

      data.data.forEach((post, index) => {
        const card = createPostCard(post, index);
        container.insertAdjacentHTML('beforeend', card);
      });

      currentPage++;
      hasMore = data.next_page_url !== null;
      
      // Initialize scrollers for new content
      initScrollers();

    } catch (error) {
      console.error('Failed to load posts:', error);
    } finally {
      isLoading = false;
      loader.classList.add('hidden');
    }
  }

  function createPostCard(post, index = 0) {
    const placeholder = CONFIG.placeholderImages[post.id % CONFIG.placeholderImages.length];
    const images = Array.isArray(post.images) ? post.images : [];
    
    let imagesHtml = '';
    if (images.length > 0) {
      images.forEach(img => {
        const isSeeder = img && img.includes('unsplash.com');
        const isLocalPlaceholder = CONFIG.placeholderImages.includes(img);
        
        let src;
        if (isSeeder || isLocalPlaceholder) {
            src = CONFIG.assetImages + (isLocalPlaceholder ? img : placeholder);
        } else if (img.startsWith('http')) {
            src = img;
        } else {
            src = CONFIG.assetStorage + img;
        }
        
        imagesHtml += `<img src="${src}" class="scroller-image" alt="${post.title}" />`;
      });
    } else {
      imagesHtml = `<img src="${CONFIG.assetImages + placeholder}" class="scroller-image" alt="${post.title}" />`;
    }

    const tagsHtml = Array.isArray(post.tags) ? post.tags.map(t => `<span class="tag">${t.trim()}</span>`).join('') : '';
    const artisanName = (post.artisan && post.artisan.user) ? post.artisan.user.name : 'Unknown Artisan';
    
    // Recent comments
    const recentComments = post.comments ? post.comments.slice(0, 2) : [];
    let commentsHtml = recentComments.map(c => `
      <div class="text-sm">
        <span class="font-bold mr-1">${c.user ? c.user.name : 'User'}</span>
        <span style="color:var(--ink-muted);">${c.content}</span>
      </div>
    `).join('');

    let commentPrompt = '';
    if (post.comments_count > 2) {
      commentPrompt = `<button onclick="openCommentModal(${post.id})" class="text-xs font-semibold opacity-60 hover:opacity-100 transition-opacity" style="color:var(--ink-muted);cursor:pointer;">View all ${post.comments_count} comments</button>`;
    } else if (post.comments_count === 0) {
      commentPrompt = `<button onclick="openCommentModal(${post.id})" class="text-xs font-semibold opacity-60 hover:opacity-100 transition-opacity" style="color:var(--ink-muted);cursor:pointer;">Be the first to comment</button>`;
    }

    const authForm = CONFIG.auth ? `
      <form action="/posts/${post.id}/comments" method="POST" class="flex items-center gap-2">
        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
        <input type="text" name="content" placeholder="Add a comment..." class="flex-1 bg-transparent border-none text-sm focus:ring-0 placeholder-gray-400 py-1" required />
        <button type="submit" class="text-xs font-bold transition-opacity hover:opacity-70" style="color:var(--terracotta);">Post</button>
      </form>
    ` : '';

    const animationDelay = (index % 5) + 1;

    return `
      <div class="craft-card fade-up delay-${animationDelay} rounded-2xl overflow-hidden" style="background:white;box-shadow:0 2px 20px rgba(28,22,18,0.07);">
        <div class="card-image relative">
          <div class="image-scroller">${imagesHtml}</div>
          ${images.length > 1 ? `<div class="absolute bottom-4 right-4 bg-black/50 text-white text-[10px] px-2 py-1 rounded-full backdrop-blur-sm pointer-events-none">1 / ${images.length}</div>` : ''}
          <div class="card-overlay"></div>
        </div>
        <div class="interaction-bar">
          <div class="flex items-center gap-1.5 cursor-pointer group" onclick="toggleLike(${post.id})">
            <svg id="like-icon-${post.id}" class="interaction-icon" fill="${post.is_liked ? 'var(--terracotta)' : 'none'}" stroke="${post.is_liked ? 'var(--terracotta)' : 'currentColor'}" stroke-width="2" viewBox="0 0 24 24" style="transition: all 0.2s ease;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <span id="like-count-${post.id}" class="text-xs font-bold" style="color:var(--ink);">${post.likes_count}</span>
          </div>
          <div class="flex items-center gap-1.5 cursor-pointer group" onclick="openCommentModal(${post.id})">
            <svg class="interaction-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <span class="text-xs font-bold" style="color:var(--ink);">${post.comments_count}</span>
          </div>
        </div>
        <div class="p-4 pt-0">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-full object-cover flex-shrink-0 avatar-ring flex items-center justify-center bg-sand-dark text-white font-bold text-xs overflow-hidden">
                <img src="${CONFIG.assetImages}profile.webp" class="w-full h-full object-cover" alt="Artisan" />
            </div>
            <div>
              <p class="text-sm font-semibold leading-tight" style="color:var(--ink);">${artisanName}</p>
              <p class="text-xs" style="color:var(--ink-muted);">${post.category || 'Category'}</p>
            </div>
          </div>
          <p class="text-sm font-bold mb-1" style="color:var(--ink);">${post.title}</p>
          <p class="text-sm leading-relaxed mb-3" style="color:var(--ink-muted);">${truncateText(post.description)}</p>
          <div class="flex gap-2 mb-4 flex-wrap">${tagsHtml}</div>
          <div class="mt-4 pt-4 border-t" style="border-color:var(--sand-dark);">
            <div class="space-y-3 mb-4">
              ${commentsHtml}
              ${commentPrompt}
            </div>
            ${authForm}
          </div>
        </div>

        <div class="comment-overlay" id="comment-modal-${post.id}" onclick="closeCommentModal(event, ${post.id})">
          <div class="comment-modal" onclick="event.stopPropagation()">
            <div class="comment-modal-header">
              <h3>Comments</h3>
              <button class="comment-modal-close" onclick="closeCommentModalDirect(${post.id})">&times;</button>
            </div>
            <div class="comment-modal-body">
              ${post.comments.length > 0 ? post.comments.map(c => `
                <div class="comment-item">
                  <div class="comment-avatar">${c.user.name.charAt(0).toUpperCase()}</div>
                  <div class="comment-content">
                    <div class="comment-author">${c.user.name}</div>
                    <div class="comment-text">${c.content}</div>
                    <div class="comment-time">${timeAgo(c.created_at)}</div>
                  </div>
                </div>
              `).join('') : `
                <div class="comment-empty">
                   <p>No comments yet</p>
                </div>
              `}
            </div>
            ${CONFIG.auth ? `
            <div class="comment-modal-footer">
              <form action="/posts/${post.id}/comments" method="POST" class="comment-form">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="text" name="content" class="comment-input" placeholder="Write a comment..." required />
                <button type="submit" class="comment-submit">Post</button>
              </form>
            </div>
            ` : ''}
          </div>
        </div>
      </div>
    `;
  }

  function initScrollers() {
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
  }

  function setupInfiniteScroll() {
    const observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && hasMore && !isLoading) {
        loadPosts();
      }
    }, { threshold: 0.1 });
    
    observer.observe(document.getElementById('infinite-scroll-trigger'));
  }

  function handleSearch(e) {
    e.preventDefault();
    currentSearch = document.getElementById('search-input').value;
    loadPosts(true);
  }

  function clearFilters() {
    currentSearch = '';
    currentCategory = '';
    document.getElementById('search-input').value = '';
    document.querySelectorAll('.category-tag').forEach(tag => {
      tag.classList.toggle('filter-active', tag.innerText === 'All');
    });
    loadPosts(true);
  }

  function setCategory(cat) {
    currentCategory = cat || '';
    document.querySelectorAll('.category-tag').forEach(tag => {
      tag.classList.toggle('filter-active', (cat === null && tag.innerText === 'All') || tag.innerText === cat);
    });
    loadPosts(true);
  }

  function openCommentModal(postId) {
    const modal = document.getElementById('comment-modal-' + postId);
    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeCommentModal(event, postId) {
    if (event.target === event.currentTarget) {
      closeCommentModalDirect(postId);
    }
  }

  function closeCommentModalDirect(postId) {
    const modal = document.getElementById('comment-modal-' + postId);
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  function toggleLike(postId) {
    const icon = document.getElementById('like-icon-' + postId);
    const countSpan = document.getElementById('like-count-' + postId);

    if (!CONFIG.auth) {
      window.location.href = CONFIG.loginUrl;
      return;
    }

    icon.style.transform = 'scale(1.2)';
    setTimeout(() => icon.style.transform = 'scale(1)', 200);

    fetch(`/posts/${postId}/like`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.isLiked) {
        icon.setAttribute('fill', 'var(--terracotta)');
        icon.setAttribute('stroke', 'var(--terracotta)');
      } else {
        icon.setAttribute('fill', 'none');
        icon.setAttribute('stroke', 'currentColor');
      }
      countSpan.innerText = data.likesCount;
    });
  }

  // Kickoff
  document.addEventListener('DOMContentLoaded', initFeed);

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.comment-overlay.active').forEach(modal => {
        modal.classList.remove('active');
      });
      document.body.style.overflow = '';
    }
  });
</script>

</body>
</html>
