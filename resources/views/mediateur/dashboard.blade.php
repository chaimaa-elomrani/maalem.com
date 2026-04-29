@extends('layouts.main')

@section('title', 'Mediator Dashboard — m3alem Logistics')

@push('styles')
<style>
    /* Premium Logistics Dashboard Styles */
    :root {
        --logistic-bg: #f8fafc;
        --logistic-surface: #ffffff;
        --logistic-border: #e2e8f0;
        --logistic-text: #0f172a;
        --logistic-text-muted: #64748b;
        --transit-color: #3b82f6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
    }

    .logistics-wrapper {
        background-color: var(--logistic-bg);
        min-height: calc(100vh - 64px);
        padding: 40px;
        font-family: 'Inter', sans-serif;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 32px;
    }

    .profile-greeting {
        font-size: 28px;
        font-weight: 700;
        color: var(--logistic-text);
        letter-spacing: -0.02em;
    }
    
    .profile-subtitle {
        color: var(--logistic-text-muted);
        font-size: 14px;
        margin-top: 4px;
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .kpi-card {
        background: var(--logistic-surface);
        border: 1px solid var(--logistic-border);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05);
    }

    .kpi-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .kpi-icon-wrapper.available { background: #fef3c7; color: #d97706; }
    .kpi-icon-wrapper.transit { background: #eff6ff; color: #2563eb; }
    .kpi-icon-wrapper.completed { background: #dcfce7; color: #16a34a; }

    .kpi-content h3 {
        font-size: 13px;
        font-weight: 600;
        color: var(--logistic-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }

    .kpi-content .kpi-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--logistic-text);
        line-height: 1;
    }

    /* Main Grid Layout */
    .dashboard-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
    }

    @media (max-width: 1024px) {
        .dashboard-layout {
            grid-template-columns: 1fr;
        }
        .logistics-wrapper {
            padding: 24px;
        }
    }

    /* Section Cards */
    .section-card {
        background: var(--logistic-surface);
        border: 1px solid var(--logistic-border);
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .section-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--logistic-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--logistic-text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mission-count {
        background: var(--logistic-border);
        color: var(--logistic-text-muted);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .mission-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    /* Mission Items */
    .mission-item {
        padding: 24px;
        border-bottom: 1px solid var(--logistic-border);
        transition: background-color 0.15s ease;
    }

    .mission-item:last-child {
        border-bottom: none;
    }
    
    .mission-item:hover {
        background-color: #f8fafc;
    }

    .mission-top-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .mission-route {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .route-point {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .point-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--logistic-text-muted);
    }
    
    .route-line {
        width: 2px;
        height: 24px;
        background-image: linear-gradient(to bottom, #cbd5e1 50%, transparent 50%);
        background-size: 100% 8px;
        margin-left: 15px;
    }

    .person-name {
        font-size: 15px;
        font-weight: 600;
        color: var(--logistic-text);
    }

    .person-role {
        font-size: 12px;
        color: var(--logistic-text-muted);
    }

    .mission-details-box {
        background: #f8fafc;
        border: 1px solid var(--logistic-border);
        border-radius: 8px;
        padding: 16px;
        margin-top: 16px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }
    .detail-row:last-child { margin-bottom: 0; }
    
    .detail-label { color: var(--logistic-text-muted); font-weight: 500; }
    .detail-value { color: var(--logistic-text); font-weight: 600; text-align: right; max-width: 60%; }

    /* Badges & Buttons */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        width: 100%;
        margin-top: 16px;
    }

    .btn-primary { background: var(--logistic-text); color: #fff; }
    .btn-primary:hover { background: #000; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    
    .btn-accent { background: var(--transit-color); color: #fff; }
    .btn-accent:hover { background: #2563eb; box-shadow: 0 4px 12px rgba(59,130,246,0.2); }
    
    .btn-success { background: var(--success-color); color: #fff; }
    .btn-success:hover { background: #059669; box-shadow: 0 4px 12px rgba(16,185,129,0.2); }

    .empty-state {
        padding: 64px 24px;
        text-align: center;
        color: var(--logistic-text-muted);
    }
    
    .empty-state svg {
        margin: 0 auto 16px;
        color: #cbd5e1;
    }
</style>
@endpush

@section('content')
<div class="logistics-wrapper">
    <div class="dashboard-header">
        <div>
            <h1 class="profile-greeting">Logistics Terminal</h1>
            <p class="profile-subtitle">{{ Auth::user()->name }} — Central Dispatch Network</p>
        </div>
        <div class="date-chip" style="background:#fff;border:1px solid #e2e8f0;padding:8px 16px;border-radius:8px;font-weight:600;font-size:14px;color:#0f172a;">
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon-wrapper available">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <div class="kpi-content">
                <h3>Open Requests</h3>
                <div class="kpi-value">{{ $availableRequests->count() }}</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-wrapper transit">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.58 16.14a6 6 0 0 1 6.84 0"></path><circle cx="12" cy="19" r="1"></circle></svg>
            </div>
            <div class="kpi-content">
                <h3>Active Transits</h3>
                <div class="kpi-value">{{ $myDeliveries->count() }}</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon-wrapper completed">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div class="kpi-content">
                <h3>Completed</h3>
                <div class="kpi-value">{{ $completedCount }}</div>
            </div>
        </div>
    </div>

    <div class="dashboard-layout">
        
        <!-- Active Deliveries Panel -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--transit-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    Your Assigments
                </div>
                <span class="mission-count">{{ $myDeliveries->count() }} Active</span>
            </div>
            
            <ul class="mission-list">
                @forelse($myDeliveries as $request)
                    @php
                        // Determine styling based on status
                        $statusData = [
                            'accepted_by_mediateur' => ['lbl' => 'Pickup Required', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
                            'picked_up_client' => ['lbl' => 'In Transit to Artisan', 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                            'at_artisan' => ['lbl' => 'Processing at Artisan', 'color' => '#8b5cf6', 'bg' => '#f3e8ff'],
                            'in_progress' => ['lbl' => 'Artisan Working', 'color' => '#8b5cf6', 'bg' => '#f3e8ff'],
                            'ready_for_return' => ['lbl' => 'Ready for Client Drop-off', 'color' => '#10b981', 'bg' => '#dcfce7'],
                        ];
                        
                        $s = $statusData[$request->status] ?? ['lbl' => str_replace('_', ' ', $request->status), 'color' => '#64748b', 'bg' => '#f1f5f9'];
                    @endphp
                
                    <li class="mission-item">
                        <div class="mission-top-row">
                            <div class="status-badge" style="background: {{ $s['bg'] }}; color: {{ $s['color'] }};">
                                <div class="status-indicator" style="background: {{ $s['color'] }};"></div>
                                {{ $s['lbl'] }}
                            </div>
                            <div style="font-weight:600; color:var(--logistic-text-muted); font-size:13px; font-family:monospace;">TRK-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>

                        <div class="mission-route">
                            <!-- Client Node -->
                            <div class="route-point">
                                <div class="point-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div>
                                <div>
                                    <div class="person-name">{{ $request->client->user->name }}</div>
                                    <div class="person-role">Client • {{ $request->adresse }}</div>
                                </div>
                            </div>
                            
                            <div class="route-line"></div>
                            
                            <!-- Artisan Node -->
                            <div class="route-point">
                                <div class="point-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>
                                <div>
                                    <div class="person-name">{{ $request->artisan->user->name }}</div>
                                    <div class="person-role">Master Artisan • {{ $request->artisan->workshopAdresse ?? 'Workshop' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mission-details-box">
                            <div class="detail-row">
                                <span class="detail-label">Item Description</span>
                                <span class="detail-value">{{ $request->description }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Target Delivery</span>
                                <span class="detail-value">{{ \Carbon\Carbon::parse($request->deliveryDate)->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <!-- Dynamic Action Buttons based on status -->
                        @if($request->status == 'accepted_by_mediateur')
                            <form action="{{ route('deliveries.update-status', $request) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="picked_up_client">
                                <button type="submit" class="btn-action btn-primary">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    Confirm Item Pickup
                                </button>
                            </form>
                        @elseif($request->status == 'picked_up_client')
                            <form action="{{ route('deliveries.update-status', $request) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="at_artisan">
                                <button type="submit" class="btn-action btn-accent">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg>
                                    Drop-off at Artisan
                                </button>
                            </form>
                        @elseif($request->status == 'ready_for_return')
                            <form action="{{ route('deliveries.update-status', $request) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" class="btn-action btn-success">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Complete Final Delivery
                                </button>
                            </form>
                        @endif
                    </li>
                @empty
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <h4 style="font-size:16px;font-weight:600;color:var(--logistic-text);margin-bottom:8px;">No Active Assignments</h4>
                        <p>Pick up new tasks from the board to get started.</p>
                    </div>
                @endforelse
            </ul>
        </div>
        
        <!-- Open Requests Board -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--warning-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Order Board
                </div>
                <span class="mission-count">{{ $availableRequests->count() }} Open</span>
            </div>
            
            <ul class="mission-list">
                @forelse($availableRequests as $request)
                    <li class="mission-item" style="padding: 20px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                            <span style="font-size:12px;font-weight:600;color:var(--warning-color);background:#fef3c7;padding:4px 8px;border-radius:4px;">PENDING DISPATCH</span>
                            <span style="font-size:12px;color:var(--logistic-text-muted);">{{ $request->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <h4 style="font-size:15px;font-weight:600;color:var(--logistic-text);margin-bottom:4px;">{{ $request->description }}</h4>
                        <p style="font-size:13px;color:var(--logistic-text-muted);margin-bottom:16px;line-height:1.5;">
                            <strong>From:</strong> {{ $request->client->user->name }}'s Address<br>
                            <strong>To:</strong> {{ $request->artisan->user->name }}'s Workshop
                        </p>
                        
                        <form action="{{ route('deliveries.accept', $request) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-action btn-primary" style="margin-top:0;padding:8px 16px;">
                                Claim Delivery
                            </button>
                        </form>
                    </li>
                @empty
                    <div class="empty-state" style="padding:40px 20px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <h4 style="font-size:14px;font-weight:600;color:var(--logistic-text);margin-bottom:4px;">No Open Orders</h4>
                        <p style="font-size:13px;">The dispatch board is currently clear.</p>
                    </div>
                @endforelse
            </ul>
        </div>

    </div>
</div>
@endsection