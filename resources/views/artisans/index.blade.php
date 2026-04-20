<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — Browse Artisans</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --brand:       #B85C2A;
      --brand-hover: #9A4B22;
      --brand-light: #F2E4DA;
      --brand-mid:   #D97B4F;
      --ink:         #18181B;
      --ink-2:       #3F3F46;
      --muted:       #71717A;
      --muted-2:     #A1A1AA;
      --border:      #E4E4E7;
      --bg:          #F4F4F5;
      --surface:     #FFFFFF;
      --star:        #D97706;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--ink); font-size: 14px; line-height: 1.5; min-height: 100vh; }

    /* NAV */
    nav { background: var(--ink); height: 54px; display: flex; align-items: center; position: sticky; top: 0; z-index: 100; }
    .nav-inner { width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo { font-size: 17px; font-weight: 700; color: var(--brand-mid); letter-spacing: -.3px; }
    .nav-links { display: flex; align-items: center; gap: 28px; }
    .nav-links a { font-size: 13px; font-weight: 500; color: rgba(255,255,255,.5); text-decoration: none; transition: color .15s; }
    .nav-links a:hover, .nav-links a.active { color: #fff; }
    .nav-av { width: 30px; height: 30px; border-radius: 50%; background: var(--brand); color: #fff; font-size: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; }

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
    
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-inner">
    <span class="nav-logo">m3alem</span>
    <div class="nav-links">
      <a href="#">Feed</a>
      <a href="#" class="active">Explore</a>
      <a href="#">Messages</a>
      <a href="#">Saved</a>
    </div>
    <div class="nav-av">A</div>
  </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="page-header-inner">
    <div>
      <h1>Browse Artisans</h1>
      <p>Discover skilled craftspeople from across Morocco</p>
    </div>
    <div class="search-wrap">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input class="search-input" type="text" placeholder="Search artisans, crafts…" />
    </div>
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

  <!-- SIDEBAR -->
  <aside class="sidebar">

    <div class="fsec">
      <div class="fsec-head">Location</div>
      <div class="fopt"><label><input type="checkbox" checked />Fès</label><span class="fopt-count">68</span></div>
      <div class="fopt"><label><input type="checkbox" />Marrakech</label><span class="fopt-count">54</span></div>
      <div class="fopt"><label><input type="checkbox" />Casablanca</label><span class="fopt-count">41</span></div>
      <div class="fopt"><label><input type="checkbox" />Rabat</label><span class="fopt-count">29</span></div>
      <div class="fopt"><label><input type="checkbox" />Chefchaouen</label><span class="fopt-count">18</span></div>
      <div class="fopt"><label><input type="checkbox" />Meknès</label><span class="fopt-count">15</span></div>
      <button class="f-more">+ Show more</button>
    </div>

    <div class="fsec">
      <div class="fsec-head">Availability</div>
      <div class="fopt"><label><input type="checkbox" checked />Available now</label><span class="fopt-count">143</span></div>
      <div class="fopt"><label><input type="checkbox" />Takes commissions</label><span class="fopt-count">201</span></div>
      <div class="fopt"><label><input type="checkbox" />Ships worldwide</label><span class="fopt-count">186</span></div>
    </div>



    <div class="fsec">
      <div class="fsec-head">Experience</div>
      <div class="fopt"><label><input type="checkbox" />Master (15+ yrs)</label><span class="fopt-count">47</span></div>
      <div class="fopt"><label><input type="checkbox" />Senior (8–15 yrs)</label><span class="fopt-count">89</span></div>
      <div class="fopt"><label><input type="checkbox" />Mid (3–8 yrs)</label><span class="fopt-count">74</span></div>
      <div class="fopt"><label><input type="checkbox" />Emerging (&lt;3 yrs)</label><span class="fopt-count">38</span></div>
    </div>

    <button class="clear-all">Clear all filters</button>
  </aside>

  <!-- CONTENT -->
  <div>
    <div class="sort-row">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <span class="result-count"><strong>248</strong> artisans</span>
        <div class="active-filters">
          <span class="af">Fès <button>×</button></span>
          <span class="af">4+ stars <button>×</button></span>
          <span class="af">Available now <button>×</button></span>
        </div>
      </div>
      <div class="sort-controls">
        <select class="sort-select">
          <option>Most Relevant</option>
          <option>Highest Rated</option>
          <option>Most Orders</option>
          <option>Newest</option>
        </select>
       </div>
    </div>

    <div class="agrid">
      <!-- 1 -->
      <div class="acard">
        <div class="acard-cover">
          <img src="https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=500&q=80" alt="" />
          <div class="cover-overlay"></div>
        </div>
        <div class="acard-body">
          <div class="acard-name">Fatima Al-Rouissi</div>
          <div class="acard-craft">Ceramic Master · Fès</div>
          <div class="acard-meta">
            <span class="sep">·</span>
            <span>(187 reviews)</span>
            <span class="sep">·</span>
            <span>892 orders</span>
          </div>
          <div class="acard-tags">
            <span class="tag">Pottery</span><span class="tag">Zellige</span><span class="tag">Custom</span>
            <button class="btn-view">View Profile</button>
          </div>
        </div>
      </div>

    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button class="pg wide">← Prev</button>
      <button class="pg active">1</button>
      <button class="pg">2</button>
      <button class="pg">3</button>
      <span style="font-size:13px;color:var(--muted);padding:0 2px;">…</span>
      <button class="pg">12</button>
      <button class="pg wide">Next →</button>
    </div>
  </div>

</div>

<!-- FOOTER -->
<footer style="background:var(--ink);border-top:1px solid #27272A;">
  <div style="max-width:1280px;margin:0 auto;padding:20px 32px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;">
    <span style="font-size:15px;font-weight:700;color:var(--brand-mid);">m3alem</span>
    <p style="font-size:12px;color:#52525B;">© 2025 m3alem · Connect with Moroccan Artisans. All rights reserved.</p>
    <div style="display:flex;gap:18px;">
      <a href="#" style="font-size:12px;color:#52525B;text-decoration:none;">Privacy</a>
      <a href="#" style="font-size:12px;color:#52525B;text-decoration:none;">Terms</a>
      <a href="#" style="font-size:12px;color:#52525B;text-decoration:none;">Support</a>
    </div>
  </div>
</footer>

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
</script>
</body>
</html>