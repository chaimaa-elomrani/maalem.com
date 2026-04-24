@extends('layouts.main')

@section('title', 'Mediator Dashboard — m3alem')

@push('styles')
<style>
    .dash-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
        transition: all 0.3s ease;
    }
    .dash-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        border-color: var(--brand-mid);
    }
    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 99px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending { background: var(--amber-bg); color: var(--amber); }
    .status-accepted { background: var(--blue-bg); color: var(--blue); }
    .status-artisan { background: var(--green-bg); color: var(--green); }
    .status-progress { background: #F3E8FF; color: #7E22CE; }
    .status-delivered { background: #F1F5F9; color: #475569; }

    .req-item {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid var(--border);
    }
    .req-item:last-child { border-bottom: none; }

    .btn-action {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-accept { background: var(--brand); color: #fff; }
    .btn-accept:hover { background: var(--brand-hover); }
    
    .btn-update { background: var(--ink); color: #fff; }
    .btn-update:hover { opacity: 0.9; }
</style>
@endpush

@section('content')
<div class="py-10 bg-[#FAFAFA] min-h-screen">
    <div class="container-xl">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="display-font text-3xl font-bold text-gray-900">Mediator Dashboard</h1>
                <p class="body-font text-gray-500 mt-1 text-sm">Oversee and coordinate craftsman-client deliveries.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right mr-3 hidden sm:block">
                    <div class="text-sm font-bold text-gray-900">Active Taskforce</div>
                    <div class="text-xs text-green-600 font-medium flex items-center justify-end gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        {{ $myDeliveries->count() }} active missions
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Available Requests -->
            <div class="lg:col-span-2 space-y-6">
                <div class="dash-card">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-500"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Available Missions
                        </h2>
                        <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full">{{ $availableRequests->count() }} New</span>
                    </div>

                    @forelse($availableRequests as $request)
                        <div class="req-item">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="status-badge status-pending">New Request</span>
                                    <span class="text-xs text-gray-400 font-medium">{{ $request->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">{{ $request->artisan->user->name }} — {{ $request->description }}</h3>
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        {{ $request->adresse }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        {{ $request->deliveryDate->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <form action="{{ route('deliveries.accept', $request) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-action btn-accept">Accept Mission</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <p class="text-gray-400 text-sm font-medium">No pending requests at the moment.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Active Deliveries -->
                <div class="dash-card">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.58 16.14a7 7 0 0 1 6.84 0"/><circle cx="12" cy="19" r="1"/></svg>
                            In-Transit missions
                        </h2>
                    </div>

                    @forelse($myDeliveries as $request)
                        <div class="req-item">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="status-badge 
                                        @if($request->status == 'accepted_by_mediator') status-accepted 
                                        @elseif($request->status == 'at_artisan') status-artisan
                                        @elseif($request->status == 'in_progress') status-progress
                                        @else status-pending @endif">
                                        {{ str_replace('_', ' ', $request->status) }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-medium">ID: #{{ $request->id }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">From: {{ $request->client->user->name }} $\rightarrow$ To: {{ $request->artisan->user->name }}</h3>
                                <p class="text-xs text-gray-500 mb-3">{{ $request->adresse }}</p>
                            </div>
                            <div class="flex flex-col gap-2">
                                @if($request->status == 'accepted_by_mediator')
                                    <form action="{{ route('deliveries.update-status', $request) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="picked_up_client">
                                        <button type="submit" class="btn-action btn-update">Mark Picked Up</button>
                                    </form>
                                @elseif($request->status == 'picked_up_client')
                                    <form action="{{ route('deliveries.update-status', $request) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="at_artisan">
                                        <button type="submit" class="btn-action btn-update">Delivered to Artisan</button>
                                    </form>
                                @elseif($request->status == 'ready_for_return')
                                    <form action="{{ route('deliveries.update-status', $request) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="btn-action btn-update">Confirm Final Delivery</button>
                                    </form>
                                @endif
                                <button class="btn-action bg-gray-100 text-gray-600 hover:bg-gray-200">Contact Party</button>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-gray-400 text-sm font-medium">
                            No active missions.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <div class="dash-card bg-var(--ink) text-white" style="background: #18181B;">
                    <h3 class="font-bold text-lg mb-2">Service Standard</h3>
                    <p class="text-gray-400 text-xs leading-relaxed mb-4">You represent the quality bridge between Morocco's finest artisans and their customers. Ensure every pickup is verified and every transition is logged.</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-amber-500">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 uppercase font-bold tracking-tight">Trust Score</div>
                                <div class="text-sm font-bold">98.4% Secure</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dash-card">
                    <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-widest">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5"></div>
                            <div>
                                <p class="text-[13px] text-gray-800"><span class="font-bold">Mission #42</span> accepted successfully.</p>
                                <span class="text-[10px] text-gray-400">2 hours ago</span>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mt-1.5"></div>
                            <div>
                                <p class="text-[13px] text-gray-800">Payment released for <span class="font-bold">Mission #39</span>.</p>
                                <span class="text-[10px] text-gray-400">5 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
