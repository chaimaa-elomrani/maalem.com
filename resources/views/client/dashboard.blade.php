@extends('layouts.main')

@section('title', 'm3alem — My Dashboard')

@push('styles')
  <style>
    /* ── SHELL ── */
    .shell { flex: 1; display: grid; grid-template-columns: 220px 1fr; width: 100%; margin: 0 auto; padding: 0 32px; gap: 0; align-items: start; }

    /* ── SIDEBAR ── */
    .sidebar { position: sticky; top: 64px; height: calc(100vh - 64px); overflow-y: auto; padding: 24px 0; display: flex; flex-direction: column; gap: 4px; border-right: 1px solid var(--border); padding-right: 20px; }
    .sidebar::-webkit-scrollbar { display: none; }

    .sidebar-label { font-size: 10px; font-weight: 600; color: var(--muted-2); text-transform: uppercase; letter-spacing: .08em; padding: 14px 10px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 6px; font-size: 13px; font-weight: 500; color: var(--muted); text-decoration: none; cursor: pointer; transition: background .12s, color .12s; }
    .sidebar-link:hover { background: var(--brand-light); color: var(--brand); }
    .sidebar-link.active { background: var(--brand-light); color: var(--brand); font-weight: 600; }
    .sidebar-link svg { flex-shrink: 0; opacity: .7; }
    .sidebar-link.active svg { opacity: 1; }

    /* ── MAIN CONTENT AREA ── */
    .main { padding: 28px 0 60px 28px; display: flex; flex-direction: column; gap: 24px; min-width: 0; }

    /* ── PAGE TITLE ── */
    .page-title { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .page-title h1 { font-size: 18px; font-weight: 700; color: var(--ink); }
    .page-title p { font-size: 12px; color: var(--muted); margin-top: 2px; }
    .btn-p { background: var(--brand); color: #fff; font-size: 12px; font-weight: 500; padding: 7px 16px; border-radius: 6px; border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: background .15s; white-space: nowrap; }
    .btn-p:hover { background: var(--brand-hover); }
    .btn-g { background: var(--surface); color: var(--ink-2); font-size: 12px; font-weight: 500; padding: 7px 14px; border-radius: 6px; border: 1px solid var(--border); cursor: pointer; font-family: 'Inter', sans-serif; transition: border-color .15s; white-space: nowrap; }
    .btn-g:hover { border-color: var(--muted); }

    /* ── STAT CARDS ── */
    .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 18px; display: flex; flex-direction: column; gap: 10px; }
    .stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; }
    .stat-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-num { font-size: 24px; font-weight: 700; color: var(--ink); line-height: 1; }
    .stat-lbl { font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-top: 4px; }
    .stat-delta { font-size: 11px; font-weight: 500; display: flex; align-items: center; gap: 3px; }
    .delta-up { color: var(--green); }
    .delta-neutral { color: var(--muted); }

    /* ── SECTION HEADER ── */
    .sec-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .sec-head h2 { font-size: 14px; font-weight: 600; color: var(--ink); }
    .sec-head a, .sec-head button { font-size: 12px; font-weight: 500; color: var(--brand); text-decoration: none; background: none; border: none; cursor: pointer; font-family: 'Inter', sans-serif; }

    /* ── ACTIVE REQUESTS ── */
    .req-list { display: flex; flex-direction: column; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .req-row { background: var(--surface); display: grid; grid-template-columns: 48px 1fr auto; align-items: center; padding: 0; transition: background .12s; cursor: pointer; }
    .req-row:hover { background: #FAFAFA; }
    .req-row:first-child { border-radius: 9px 9px 0 0; }
    .req-row:last-child  { border-radius: 0 0 9px 9px; }
    .req-thumb { width: 48px; height: 60px; overflow: hidden; flex-shrink: 0; }
    .req-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .req-body { padding: 0 14px; display: flex; align-items: center; gap: 14px; min-width: 0; flex-wrap: wrap; }
    .req-av { width: 32px; height: 32px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid var(--border); }
    .req-av img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .req-av.ini { display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #fff; }
    .req-info { flex: 1; min-width: 0; }
    .req-name { font-size: 13px; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .req-sub  { font-size: 11px; color: var(--muted); margin-top: 1px; }
    .req-status { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 4px; white-space: nowrap; }
    .status-pending  { background: var(--amber-bg); color: var(--amber); }
    .status-transit  { background: var(--blue-bg);  color: var(--blue); }
    .status-done     { background: var(--green-bg); color: var(--green); }
    .status-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .req-action { padding: 0 16px; display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
    .req-date { font-size: 11px; color: var(--muted-2); }

    /* ── SAVED ARTISANS ── */
    .saved-list { display: flex; flex-direction: column; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .saved-row { background: var(--surface); display: grid; grid-template-columns: 42px 1fr auto; align-items: center; padding: 0; cursor: pointer; transition: background .12s; }
    .saved-row:hover { background: #FAFAFA; }
    .saved-row:first-child { border-radius: 9px 9px 0 0; }
    .saved-row:last-child  { border-radius: 0 0 9px 9px; }
    .saved-thumb { width: 42px; height: 50px; overflow: hidden; flex-shrink: 0; }
    .saved-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .saved-body { padding: 0 12px; display: flex; align-items: center; gap: 10px; min-width: 0; }
    .saved-av { width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0; border: 2px solid var(--border); overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #fff; }
    .saved-av img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .saved-info { flex: 1; min-width: 0; }
    .saved-name { font-size: 12px; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .saved-sub  { font-size: 11px; color: var(--muted); }
    .saved-action { padding: 0 12px; display: flex; align-items: center; gap: 6px; }
    .star { color: var(--star); font-size: 11px; }
    .saved-rating { font-size: 11px; font-weight: 600; color: var(--ink-2); }

    /* ── NOTIF PANEL ── */
    .notif-list { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .notif-item { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; border-bottom: 1px solid var(--border); transition: background .12s; cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--bg); }
    .notif-item.unread { background: #FEFAF8; }
    .notif-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--brand); flex-shrink: 0; margin-top: 5px; }
    .notif-dot.read { background: transparent; }
    .notif-text { font-size: 12px; color: var(--ink-2); line-height: 1.55; flex: 1; }
    .notif-text strong { font-weight: 600; color: var(--ink); }
    .notif-time { font-size: 10px; color: var(--muted-2); margin-top: 2px; }

    /* ── MEDIATOR TRACKING ── */
    .track-card { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .track-header { padding: 14px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .track-title { font-size: 13px; font-weight: 600; color: var(--ink); }
    .track-id { font-size: 11px; color: var(--muted); }
    .track-body { padding: 16px; }
    .track-steps { display: flex; flex-direction: column; gap: 0; position: relative; }
    .track-step { display: flex; align-items: flex-start; gap: 12px; padding-bottom: 18px; position: relative; }
    .track-step:last-child { padding-bottom: 0; }
    .step-line { position: absolute; left: 11px; top: 24px; bottom: 0; width: 1px; background: var(--border); }
    .track-step:last-child .step-line { display: none; }
    .step-circle { width: 24px; height: 24px; border-radius: 50%; border: 2px solid var(--border); background: var(--surface); display: flex; align-items: center; justify-content: center; flex-shrink: 0; position: relative; z-index: 1; }
    .step-circle.done { border-color: var(--green); background: var(--green-bg); }
    .step-circle.active { border-color: var(--blue); background: var(--blue-bg); }
    .step-circle svg { width: 12px; height: 12px; }
    .step-info { flex: 1; padding-top: 2px; }
    .step-label { font-size: 12px; font-weight: 600; color: var(--ink); }
    .step-label.muted { color: var(--muted); font-weight: 500; }
    .step-time { font-size: 11px; color: var(--muted-2); margin-top: 1px; }

    /* ── QUICK SEARCH ── */
    .quick-search { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 16px; }
    .quick-search h3 { font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px; }
    .qs-input-wrap { position: relative; margin-bottom: 10px; }
    .qs-input-wrap svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--muted-2); pointer-events: none; }
    .qs-input { width: 100%; padding: 8px 10px 8px 30px; border: 1px solid var(--border); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 12px; color: var(--ink); background: var(--bg); outline: none; transition: border-color .15s; }
    .qs-input:focus { border-color: var(--brand); background: #fff; }
    .qs-cats { display: flex; flex-wrap: wrap; gap: 5px; }
    .qs-cat { font-size: 11px; font-weight: 500; padding: 4px 10px; border-radius: 4px; border: 1px solid var(--border); background: var(--bg); color: var(--muted); cursor: pointer; transition: background .12s, color .12s, border-color .12s; }
    .qs-cat:hover { border-color: var(--brand); color: var(--brand); background: var(--brand-light); }

    /* ── REVIEWS TO LEAVE ── */
    .review-prompt { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: background .12s; }
    .review-prompt:hover { background: #FAFAFA; }
    .review-thumb { width: 40px; height: 40px; border-radius: 6px; overflow: hidden; flex-shrink: 0; }
    .review-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .review-info { flex: 1; }
    .review-info p { font-size: 12px; font-weight: 600; color: var(--ink); }
    .review-info span { font-size: 11px; color: var(--muted); }
    .stars-empty { color: var(--border); font-size: 16px; letter-spacing: 2px; }

    /* divider */
    .vdiv { width: 1px; height: 28px; background: var(--border); flex-shrink: 0; }
  </style>
@endpush

@section('content')

<!-- SHELL -->
<div class="shell">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-label">Overview</div>
    <a class="sidebar-link active" href="{{ route('dashboard') }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a class="sidebar-link" href="{{ route('artisans.index') }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      Find Artisans
    </a>

    <div class="sidebar-label">My Activity</div>
    <a class="sidebar-link active" href="{{ route('dashboard') }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
      My Requests
    </a>
    <a class="sidebar-link" href="#">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      Messages
    </a>

    <div class="sidebar-label">Account</div>
    <a class="sidebar-link" href="{{ route('profile.edit') }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      My Profile
    </a>
    <a class="sidebar-link" href="{{ route('profile.edit') }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      Settings
    </a>
  </aside>

  <!-- MAIN -->
  <main class="main">

    <!-- Stats -->
    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-card-top">
          <div>
            <div class="stat-num">{{ $deliveryRequests->where('status', '!=', 'delivered')->count() }}</div>
            <div class="stat-lbl">Tracked Services</div>
          </div>
        </div>
        <div class="stat-delta delta-neutral">Active currently</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-top">
          <div>
            <div class="stat-num">{{ $deliveryRequests->whereIn('status', ['at_artisan', 'in_progress', 'ready_for_return'])->count() }}</div>
            <div class="stat-lbl">In Production</div>
          </div>
        </div>
        <div class="stat-delta delta-neutral">At the workshop</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-top">
          <div>
            <div class="stat-num">{{ $deliveryRequests->where('status', 'delivered')->count() }}</div>
            <div class="stat-lbl">Done Services</div>
          </div>
        </div>
        <div class="stat-delta delta-neutral">Successfully received</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-top">
          <div>
            <div class="stat-num">{{ $deliveryRequests->count() }}</div>
            <div class="stat-lbl">Total Orders</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tracked services (Active) -->
    <div>
      <div class="sec-head">
        <h2>Tracked Services</h2>
        <span style="font-size:12px; color:var(--muted);">Real-time progress</span>
      </div>
      <div class="req-list">
        @forelse($deliveryRequests->where('status', '!=', 'delivered') as $request)
            <div class="req-row">
              <div class="req-thumb">
                @php
                  $placeholder = $placeholderImages[$request->id % count($placeholderImages)];
                @endphp
                <img src="{{ asset('images/' . $placeholder) }}" alt="" />
              </div>
              <div class="req-body">
                <div class="req-av ini" style="background:var(--brand);">{{ strtoupper(substr($request->artisan->user->name, 0, 1)) }}</div>
                <div class="req-info">
                  <div class="req-name">{{ $request->artisan->user->name }}</div>
                  <div class="req-sub">{{ $request->description }} · {{ $request->artisan->user->city }}</div>
                </div>
                <div class="vdiv"></div>
                <span class="req-status status-transit">
                    <span class="status-dot"></span>
                    {{ str_replace('_', ' ', $request->status) }}
                </span>
                @if($request->mediateur)
                    <div class="vdiv"></div>
                    <span style="font-size:11px;color:var(--muted);">Mediator: {{ $request->mediateur->user->name }}</span>
                @endif
              </div>
              <div class="req-action">
                <span class="req-date">{{ $request->created_at->format('M d') }}</span>
                <button class="btn-g" onclick="showTracker({{ $request->id }})">Track Live</button>
              </div>
            </div>
            
            <div id="tracker-{{ $request->id }}" style="display:none; background: var(--bg); padding: 20px; border-top: 1px solid var(--border);">
                <div class="track-steps">
                    @php
                        $statuses = ['pending', 'accepted_by_mediateur', 'picked_up_client', 'at_artisan', 'in_progress', 'ready_for_return', 'delivered'];
                        $currentIdx = array_search($request->status, $statuses);
                    @endphp
                    @foreach($statuses as $index => $status)
                        <div class="track-step">
                            <div class="step-line" style="{{ $index >= count($statuses) - 1 ? 'display:none;' : '' }}"></div>
                            <div class="step-circle {{ $index <= $currentIdx ? 'done' : ($index == $currentIdx + 1 ? 'active' : '') }}">
                                @if($index <= $currentIdx)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                @endif
                            </div>
                            <div class="step-info">
                                <div class="step-label {{ $index > $currentIdx ? 'muted' : '' }}">{{ ucwords(str_replace('_', ' ', $status)) }}</div>
                                <div class="step-time">{{ $index <= $currentIdx ? 'Completed' : 'Upcoming' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>  
            </div>
        @empty
            <div style="padding: 32px; text-align: center; color: var(--muted); background: var(--surface);">
                <p>No services currently being tracked.</p>
            </div>
        @endforelse
      </div>
    </div>

    <!-- Done Services -->
    <div>
      <div class="sec-head">
        <h2>Done Services</h2>
        <span style="font-size:12px; color:var(--muted);">History of craftsmanship</span>
      </div>
      <div class="req-list">
        @forelse($deliveryRequests->where('status', 'delivered') as $request)
            <div class="req-row">
              <div class="req-thumb">
                @php
                  $placeholder = $placeholderImages[$request->id % count($placeholderImages)];
                @endphp
                <img src="{{ asset('images/' . $placeholder) }}" alt="" />
              </div>
              <div class="req-body">
                <div class="req-av ini" style="background:#4B5563;">{{ strtoupper(substr($request->artisan->user->name, 0, 1)) }}</div>
                <div class="req-info">
                  <div class="req-name">{{ $request->artisan->user->name }}</div>
                  <div class="req-sub">Masterful {{ $request->artisan->service }} work completed.</div>
                </div>
                <div class="vdiv"></div>
                <span class="req-status status-done">
                    <span class="status-dot"></span>
                    Delivered
                </span>
              </div>
              <div class="req-action">
                <span class="req-date">{{ $request->updated_at->format('M d, Y') }}</span>
                <button class="btn-g" style="color:var(--brand)">Leave Review</button>
              </div>
            </div>
        @empty
            <div style="padding: 32px; text-align: center; color: var(--muted); background: var(--surface);">
                <p>No completed services yet.</p>
            </div>
        @endforelse
      </div>
    </div>

  </main>
</div>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.sidebar-link').forEach(l => {
    l.addEventListener('click', e => {
      // Allow default behavior for links with href starting with / or http
      if (l.getAttribute('href') && (l.getAttribute('href').startsWith('/') || l.getAttribute('href').startsWith('http'))) {
          return;
      }
      e.preventDefault();
      document.querySelectorAll('.sidebar-link').forEach(x => x.classList.remove('active'));
      l.classList.add('active');
    });
  });

  function showTracker(id) {
    const tracker = document.getElementById('tracker-' + id);
    if (tracker.style.display === 'none') {
        tracker.style.display = 'block';
    } else {
        tracker.style.display = 'none';
    }
  }

  document.querySelectorAll('.qs-cat').forEach(c => {
    c.addEventListener('click', () => {
      document.querySelectorAll('.qs-cat').forEach(x => x.style.cssText = '');
      c.style.background = 'var(--brand-light)';
      c.style.color = 'var(--brand)';
      c.style.borderColor = 'var(--brand)';
    });
  });
</script>
@endpush
