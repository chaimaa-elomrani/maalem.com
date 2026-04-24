@extends('layouts.main')

@section('title', 'm3alem — Browse Artisans')

@push('styles')
  <style>
    /* PAGE HEADER */
    .page-header { background: var(--surface); border-bottom: 1px solid var(--border); }
    .page-header-inner { max-width: 1280px; margin: 0 auto; padding: 22px 32px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .page-header h1 { font-size: 18px; font-weight: 700; color: var(--ink); margin-bottom: 2px; }
    .page-header p { font-size: 12px; color: var(--muted); }
    .search-wrap { position: relative; width: 280px; }
    .search-wrap svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--muted-2); pointer-events: none; }
    .search-input { width: 100%; padding: 8px 12px 8px 32px; border: 1px solid var(--border); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 13px; color: var(--ink); background: var(--bg); outline: none; transition: border-color .15s; }
    .search-input:focus { border-color: var(--brand); background: #fff; }

    /* CATEGORY TABS */
    .cat-bar { background: var(--surface); border-bottom: 1px solid var(--border); }
    .cat-bar-inner { max-width: 1280px; margin: 0 auto; padding: 0 32px; display: flex; overflow-x: auto; }
    .cat-bar-inner::-webkit-scrollbar { display: none; }
    .cat-tab { padding: 13px 16px; font-size: 13px; font-weight: 500; color: var(--muted); border-bottom: 2px solid transparent; cursor: pointer; white-space: nowrap; transition: color .15s, border-color .15s; display: flex; align-items: center; gap: 6px; }
    .cat-tab:hover { color: var(--ink-2); }
    .cat-tab.active { color: var(--brand); border-bottom-color: var(--brand); }
    .cat-count { font-size: 11px; background: var(--bg); border: 1px solid var(--border); color: var(--muted); padding: 1px 6px; border-radius: 999px; }
    .cat-tab.active .cat-count { background: var(--brand-light); color: var(--brand); border-color: transparent; }

    /* LAYOUT */
    .layout { max-width: 1280px; margin: 0 auto; padding: 24px 32px 60px; display: grid; grid-template-columns: 220px 1fr; gap: 24px; align-items: start; }

    /* SIDEBAR */
    .sidebar { position: sticky; top: 78px; display: flex; flex-direction: column; gap: 12px; }
    .fsec { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
    .fsec-head { padding: 11px 16px; font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid var(--border); background: var(--bg); }
    .fopt { display: flex; align-items: center; justify-content: space-between; padding: 8px 16px; cursor: pointer; transition: background .1s; }
    .fopt:hover { background: var(--bg); }
    .fopt label { font-size: 13px; color: var(--ink-2); cursor: pointer; display: flex; align-items: center; gap: 8px; }
    .fopt input[type=checkbox] { accent-color: var(--brand); width: 14px; height: 14px; cursor: pointer; flex-shrink: 0; }
    .fopt-count { font-size: 11px; color: var(--muted-2); }
    .f-more { background: none; border: none; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500; color: var(--brand); cursor: pointer; padding: 9px 16px; text-align: left; display: block; width: 100%; }
    .clear-all { background: none; border: none; font-family: 'Inter', sans-serif; font-size: 12px; color: var(--muted); cursor: pointer; text-align: left; padding: 4px 0; transition: color .15s; }
    .clear-all:hover { color: var(--ink); }

    /* CONTENT */
    .sort-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .result-count { font-size: 13px; color: var(--muted); }
    .result-count strong { color: var(--ink); font-weight: 600; }
    .active-filters { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .af { display: inline-flex; align-items: center; gap: 4px; background: var(--brand-light); color: var(--brand); font-size: 12px; font-weight: 500; padding: 3px 8px; border-radius: 4px; }
    .af button { background: none; border: none; color: var(--brand); cursor: pointer; font-size: 13px; line-height: 1; padding: 0; margin-left: 2px; }
    .sort-controls { display: flex; align-items: center; gap: 8px; }
    .sort-select { padding: 7px 10px; border: 1px solid var(--border); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 13px; color: var(--ink-2); background: var(--surface); outline: none; cursor: pointer; }
    .view-toggle { display: flex; border: 1px solid var(--border); border-radius: 6px; overflow: hidden; }
    .vbtn { padding: 7px 9px; background: var(--surface); border: none; cursor: pointer; color: var(--muted); display: flex; align-items: center; transition: background .1s, color .1s; }
    .vbtn.active { background: var(--bg); color: var(--ink); }
    .vbtn + .vbtn { border-left: 1px solid var(--border); }

    /* ARTISAN LIST (One per row) */
    .agrid { display: flex; flex-direction: column; gap: 14px; }

    .acard { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow .18s, transform .18s; display: flex; flex-direction: row; }
    .acard:hover { box-shadow: 0 4px 18px rgba(0,0,0,.08); transform: translateY(-1px); }

    .acard-cover { width: 180px; min-height: 130px; position: relative; overflow: hidden; flex-shrink: 0; }
    .acard-cover img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s; }
    .acard:hover .acard-cover img { transform: scale(1.04); }
    .cover-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 30%, rgba(0,0,0,.32) 100%); }
    .feat-badge { position: absolute; top: 8px; right: 8px; background: var(--brand); color: #fff; font-size: 9px; font-weight: 600; padding: 2px 6px; border-radius: 3px; letter-spacing: .04em; }
    .av-chip { position: absolute; top: 8px; left: 8px; display: flex; align-items: center; gap: 3px; background: rgba(0,0,0,.5); backdrop-filter: blur(4px); color: #fff; font-size: 9px; font-weight: 500; padding: 2px 6px; border-radius: 3px; }
    .dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .dot-g { background: #22C55E; }
    .dot-m { background: var(--muted-2); }

    .acard-body { padding: 14px 18px; flex: 1; display: flex; flex-direction: column; justify-content: center; }
    .acard-name { font-size: 15px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
    .acard-craft { font-size: 12px; color: var(--muted); margin-bottom: 8px; }
    .acard-meta { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); margin-bottom: 8px; flex-wrap: wrap; }
    .acard-rating { font-weight: 500; color: var(--ink-2); display: flex; align-items: center; gap: 3px; }
    .star { color: var(--star); }
    .sep { color: var(--border); }
    .acard-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 10px; }
    .tag { display: inline-block; background: var(--bg); border: 1px solid var(--border); color: var(--muted); font-size: 10px; font-weight: 500; padding: 2px 6px; border-radius: 4px; }
    .acard-foot { display: flex; align-items: center; justify-content: space-between; padding-top: 10px; border-top: 1px solid var(--border); margin-top: auto; }
    .orders-lbl { font-size: 11px; color: var(--muted); }
    .orders-lbl strong { font-weight: 600; color: var(--ink-2); }
    .btn-view { background: var(--brand); color: #fff; font-size: 12px; font-weight: 500; padding: 6px 14px; border-radius: 5px; border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: background .15s; }
    .btn-view:hover { background: var(--brand-hover); }

    /* PAGINATION */
    .pagination { display: flex; justify-content: center; align-items: center; gap: 4px; margin-top: 28px; }
    .pg { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; font-weight: 500; color: var(--ink-2); background: var(--surface); cursor: pointer; transition: background .12s, border-color .12s, color .12s; }
    .pg:hover { border-color: var(--muted); }
    .pg.active { background: var(--brand); border-color: var(--brand); color: #fff; }
    .pg.wide { width: auto; padding: 0 12px; }

    /* COMPARISON TRAY */
    .compare-tray {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(120%);
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 24px;
        z-index: 1000;
        transition: transform 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        border: 1px solid var(--brand-pale);
    }
    .compare-tray.active { transform: translateX(-50%) translateY(0); }
    .compare-items { display: flex; gap: 12px; }
    .compare-item {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid var(--border);
        font-size: 12px;
        font-weight: 600;
    }
    .compare-item button {
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }
    .compare-item button:hover { color: #ef4444; }

    /* COMPARISON MODAL */
    .compare-modal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(10px);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }
    .compare-modal.active { display: flex; }
    .compare-content {
        background: #fff;
        width: 100%;
        max-width: 1000px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
    }
    .compare-head {
        padding: 24px 32px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .compare-grid {
        display: grid;
        grid-template-columns: 200px repeat(3, 1fr);
        padding: 0;
    }
    .compare-row {
        display: contents;
    }
    .compare-cell {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
        display: flex;
        align-items: center;
    }
    .compare-label {
        font-weight: 700;
        color: var(--muted);
        background: #F9FAFB;
        border-right: 1px solid var(--border);
    }
    .compare-artisan-name { font-weight: 700; color: var(--ink); font-size: 16px; margin-bottom: 4px; }
    .compare-artisan-sub { font-size: 12px; color: var(--muted); }
  </style>
@endpush

@section('content')


<!-- PAGE HEADER -->
<div class="page-header">
  <div class="page-header-inner">
    <div>
      <h1>Browse Artisans</h1>
      <p>Discover skilled craftspeople from across Morocco</p>
    </div>
    <form action="{{ route('artisans.index') }}" method="GET" class="search-wrap">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input class="search-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search artisans, crafts…" onchange="this.form.submit()" />
    </form>
  </div>
</div>

<!-- CATEGORY TABS -->
<div class="cat-bar">
  <div class="cat-bar-inner">
    <span class="cat-tab active">All <span class="cat-count">248</span></span>
    <span class="cat-tab">Pottery <span class="cat-count">54</span></span>
    <span class="cat-tab">Weaving <span class="cat-count">41</span></span>
    <span class="cat-tab">Leather <span class="cat-count">37</span></span>
    <span class="cat-tab">Metalwork <span class="cat-count">29</span></span>
    <span class="cat-tab">Ceramics <span class="cat-count">48</span></span>
    <span class="cat-tab">Woodwork <span class="cat-count">22</span></span>
    <span class="cat-tab">Jewelry <span class="cat-count">17</span></span>
  </div>
</div>

<!-- LAYOUT -->
<div class="layout">
  <aside class="sidebar">
    <form action="{{ route('artisans.index') }}" method="GET" id="filters-form">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="fsec">
          <div class="fsec-head">Location</div>
          <div style="max-height: 200px; overflow-y: auto;">
              @foreach($cities as $city)
                  <div class="fopt">
                      <label>
                          <input type="radio" name="city" value="{{ $city }}" 
                                 {{ request('city') == $city ? 'checked' : '' }} 
                                 onchange="this.form.submit()" />
                          {{ $city }}
                      </label>
                  </div>
              @endforeach
          </div>
          @if(request('city'))
              <a href="{{ route('artisans.index', request()->only(['search', 'experience', 'availability', 'min_rating'])) }}" class="f-more" style="text-decoration:none; display:inline-block; text-align:center;">Clear City</a>
          @endif
        </div>

        <div class="fsec">
          <div class="fsec-head">Availability</div>
          <div class="fopt">
              <label>
                  <input type="checkbox" name="availability" value="1" {{ request('availability') ? 'checked' : '' }} onchange="this.form.submit()" />
                  Available now
              </label>
          </div>
        </div>

        <div class="fsec">
          <div class="fsec-head">Experience</div>
          <div class="fopt">
              <label><input type="radio" name="experience" value="master" {{ request('experience') == 'master' ? 'checked' : '' }} onchange="this.form.submit()" /> Master (15+ yrs)</label>
          </div>
          <div class="fopt">
              <label><input type="radio" name="experience" value="senior" {{ request('experience') == 'senior' ? 'checked' : '' }} onchange="this.form.submit()" /> Senior (8–15 yrs)</label>
          </div>
          <div class="fopt">
              <label><input type="radio" name="experience" value="mid" {{ request('experience') == 'mid' ? 'checked' : '' }} onchange="this.form.submit()" /> Mid (3–8 yrs)</label>
          </div>
          <div class="fopt">
              <label><input type="radio" name="experience" value="emerging" {{ request('experience') == 'emerging' ? 'checked' : '' }} onchange="this.form.submit()" /> Emerging (<3 yrs)</label>
          </div>
        </div>

        <div class="fsec">
            <div class="fsec-head">Min. Rating</div>
            <div class="fopt">
                <select name="min_rating" class="sort-select" style="width:100%;" onchange="this.form.submit()">
                    <option value="">Any Rating</option>
                    <option value="4.5" {{ request('min_rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
                    <option value="4.0" {{ request('min_rating') == '4.0' ? 'selected' : '' }}>4.0+ Stars</option>
                    <option value="3.5" {{ request('min_rating') == '3.5' ? 'selected' : '' }}>3.5+ Stars</option>
                </select>
            </div>
        </div>

        <a href="{{ route('artisans.index') }}" class="clear-all" style="display:block; text-align:center; padding:10px;">Clear all filters</a>
    </form>
  </aside>

  <!-- CONTENT -->
  <div>
   
    <div class="agrid">
      @forelse($artisans as $artisan)
          <div class="acard" onclick="window.location='{{ route('artisan.profile', $artisan->id) }}'">
            <div class="acard-cover">
              <img src="{{ asset('images/profile.webp') }}" alt="" />
              <div class="cover-overlay"></div>
              <div style="position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); color:#fff; font-size:9px; font-weight:600; padding:2px 6px; border-radius:4px; display:flex; align-items:center; gap:4px;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Mediation Supported
              </div>
            </div>
            <div class="acard-body">
              <div class="acard-name">{{ $artisan->name }}</div>
              <div class="acard-craft">{{ $artisan->artisan->service }} · {{ $artisan->city }}</div>
              <div class="acard-meta">
                <span class="acard-rating">
                   <span class="star">★</span> {{ round($artisan->reviews_received_avg_rating ?? 0, 1) ?: 'N/A' }}
                </span>
                <span class="sep">·</span>
                <span>({{ $artisan->reviews_received_count ?? 0 }} reviews)</span>
                <span class="sep">·</span>
                <span>{{ $artisan->posts_count ?? 0 }} projects</span>
              </div>
              <div class="acard-tags">
                <span class="tag">{{ $artisan->artisan->service }}</span>
                @if($artisan->city)
                    <span class="tag">{{ $artisan->city }}</span>
                @endif
                <div style="margin-left: auto; display: flex; gap: 8px;">
                    <button class="btn-ghost" onclick="event.stopPropagation(); addToCompare({{ json_encode(['id'=>$artisan->id, 'name'=>$artisan->name, 'city'=>$artisan->city, 'rating'=>round($artisan->reviews_received_avg_rating ?? 0, 1), 'projects'=>$artisan->posts_count]) }})" style="padding: 6px 12px; font-size: 11px;">
                        + Compare
                    </button>
                    <button class="btn-view">View Profile</button>
                </div>
              </div>
            </div>
          </div>
      @empty
          <div style="background: var(--surface); padding: 40px; text-align: center; border-radius: 8px; border: 1px solid var(--border);">
              <h3 style="font-size: 16px; font-weight: 600; color: var(--ink);">No artisans found</h3>
              <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">Try adjusting your search or filters.</p>
              <a href="{{ route('artisans.index') }}" class="btn-view" style="display: inline-block; margin-top: 16px; text-decoration: none;">Clear all filters</a>
          </div>
      @endforelse
    </div>

    </div>
  </div>

  <!-- Comparison Tray -->
  <div id="compareTray" class="compare-tray">
    <div style="padding-right: 16px; border-right: 1px solid var(--border);">
        <p style="font-size: 11px; font-weight: 700; color: var(--brand); text-transform: uppercase;">Comparison Tray</p>
        <p style="font-size: 12px; color: var(--muted);" id="compareCount">0 artisans selected</p>
    </div>
    <div class="compare-items" id="compareItems">
        <!-- JS rendered -->
    </div>
    <button class="btn-view" onclick="openCompareModal()">Compare Now</button>
  </div>

  <!-- Comparison Modal -->
  <div id="compareModal" class="compare-modal" onclick="closeCompareModal()">
    <div class="compare-content" onclick="event.stopPropagation()">
        <div class="compare-head">
            <h2 class="font-bold text-xl">Artisan Comparison</h2>
            <button onclick="closeCompareModal()" class="text-gray-400 hover:text-gray-600">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="compare-grid" id="compareGrid">
            <!-- JS populated -->
        </div>
        <div style="padding: 20px 32px; background: #F9FAFB; text-align: right;">
            <button class="btn-ghost" onclick="closeCompareModal()">Close Comparison</button>
        </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('.cat-tab').forEach(t => {
    t.addEventListener('click', () => {
      document.querySelectorAll('.cat-tab').forEach(x => x.classList.remove('active'));
      t.classList.add('active');
    });
  });
  document.querySelectorAll('.vbtn').forEach(b => {
    b.addEventListener('click', () => {
      document.querySelectorAll('.vbtn').forEach(x => x.classList.remove('active'));
      b.classList.add('active');
    });
  });
  document.querySelectorAll('.af button').forEach(b => {
    b.addEventListener('click', () => b.closest('.af').remove());
  });
  document.querySelectorAll('.pg:not(.wide)').forEach(b => {
    b.addEventListener('click', () => {
      document.querySelectorAll('.pg:not(.wide)').forEach(x => x.classList.remove('active'));
      b.classList.add('active');
    });
  });

  // COMPARISON LOGIC
  let compareList = [];

  function addToCompare(artisan) {
    if (compareList.length >= 3) {
        alert("You can compare up to 3 artisans at once.");
        return;
    }
    if (compareList.find(a => a.id === artisan.id)) {
        alert("This artisan is already in your comparison list.");
        return;
    }
    compareList.push(artisan);
    updateTray();
  }

  function removeFromCompare(id) {
    compareList = compareList.filter(a => a.id !== id);
    updateTray();
  }

  function updateTray() {
    const tray = document.getElementById('compareTray');
    const itemsContainer = document.getElementById('compareItems');
    const countText = document.getElementById('compareCount');

    if (compareList.length > 0) {
        tray.classList.add('active');
    } else {
        tray.classList.remove('active');
    }

    countText.innerText = `${compareList.length} artisan${compareList.length > 1 ? 's' : ''} selected`;
    
    itemsContainer.innerHTML = compareList.map(a => `
        <div class="compare-item">
            <span>${a.name}</span>
            <button onclick="removeFromCompare(${a.id})">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    `).join('');
  }

  function openCompareModal() {
    const modal = document.getElementById('compareModal');
    const grid = document.getElementById('compareGrid');
    
    if (compareList.length === 0) return;

    modal.classList.add('active');

    let html = `
        <div class="compare-row">
            <div class="compare-cell compare-label">Artisan</div>
            ${compareList.map(a => `
                <div class="compare-cell flex-col items-start">
                    <div class="compare-artisan-name">${a.name}</div>
                    <div class="compare-artisan-sub">#${a.id}</div>
                </div>
            `).join('')}
            ${Array(3 - compareList.length).fill('<div class="compare-cell text-gray-300 italic">Empty Slot</div>').join('')}
        </div>
        <div class="compare-row">
            <div class="compare-cell compare-label">City</div>
            ${compareList.map(a => `<div class="compare-cell">${a.city}</div>`).join('')}
            ${Array(3 - compareList.length).fill('<div class="compare-cell"></div>').join('')}
        </div>
        <div class="compare-row">
            <div class="compare-cell compare-label">Rating</div>
            ${compareList.map(a => `<div class="compare-cell"><span style="color:#F59E0B; margin-right:4px;">★</span> ${a.rating}</div>`).join('')}
            ${Array(3 - compareList.length).fill('<div class="compare-cell"></div>').join('')}
        </div>
        <div class="compare-row">
            <div class="compare-cell compare-label">Portfolio</div>
            ${compareList.map(a => `<div class="compare-cell">${a.projects} Projects</div>`).join('')}
            ${Array(3 - compareList.length).fill('<div class="compare-cell"></div>').join('')}
        </div>
        <div class="compare-row">
            <div class="compare-cell compare-label">Actions</div>
            ${compareList.map(a => `<div class="compare-cell"><a href="/artisan/${a.id}" class="text-brand font-bold text-xs">View Profile</a></div>`).join('')}
            ${Array(3 - compareList.length).fill('<div class="compare-cell"></div>').join('')}
        </div>
    `;
    grid.innerHTML = html;
  }

  function closeCompareModal() {
    document.getElementById('compareModal').classList.remove('active');
  }
</script>
@endpush