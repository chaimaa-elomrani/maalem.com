@extends('layouts.admin')

@section('title', 'm3alem Admin — Users Management')
@section('header_title', 'Users Management')
@section('header_subtitle', 'Review and validate artisan applications and manage platform users.')

@section('content')
    <!-- Active User Overview -->
    <div class="section-title">
        <span>Active Platform Users</span>
        <button style="font-size: 13px; font-weight: 600; color: var(--terracotta); background: none; border: none; cursor: pointer;">View All Users →</button>
    </div>
    <div class="stat-grid" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 32px;">
        <div class="card" style="display: flex; align-items: center; gap: 20px; padding: 24px;">
            
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--ink-muted);">Validated Artisans</p>
                <h3 style="font-size: 20px; font-weight: 800;">{{ \App\Models\Artisan::where('status', 'approved')->count() }}</h3>
            </div>
        </div>
        <div class="card" style="display: flex; align-items: center; gap: 20px; padding: 24px;">
            
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--ink-muted);">Registered Clients</p>
                <h3 style="font-size: 20px; font-weight: 800;">{{ \App\Models\User::where('role', 'client')->count() }}</h3>
            </div>
        </div>
        <div class="card" style="display: flex; align-items: center; gap: 20px; padding: 24px;">
     
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--ink-muted);">Verified Mediators</p>
                <h3 style="font-size: 20px; font-weight: 800;">{{ \App\Models\Mediateur::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 0; margin-bottom: 32px;">
        <div style="padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 18px; font-weight: 700;">Pending Artisan Approvals</h2>
        </div>
        
        <div class="table-container" style="border: none; border-radius: 0;">
            <table>
                <thead>
                    <tr>
                        <th>Artisan</th>
                        <th>Craft / Service</th>
                        <th>Location</th>
                        <th>Experience</th>
                        <th>Application Date</th>
                        <th style="text-align: right;">Decision</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingArtisans as $artisan)
                    <tr>
                        <td style="font-weight: 600;">{{ $artisan->user->name }}</td>
                        <td>
                            <span style="font-weight: 500; color: var(--terracotta);">{{ $artisan->service }}</span>
                        </td>
                        <td style="color: var(--ink-muted);">{{ $artisan->user->city ?? 'Morocco' }}</td>
                        <td>{{ $artisan->experience }}</td>
                        <td style="color: var(--ink-muted);">{{ $artisan->created_at->format('M d, Y') }}</td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                <button class="btn-detail" onclick="showArtisanDetails({
                                    name: '{{ addslashes($artisan->user->name) }}',
                                    service: '{{ addslashes($artisan->service) }}',
                                    location: '{{ addslashes($artisan->user->city ?? 'Morocco') }}',
                                    experience: '{{ addslashes($artisan->experience) }}',
                                    date: '{{ $artisan->created_at->format('M d, Y') }}',
                                    bio: '{{ addslashes(str_replace(["\r", "\n"], ' ', $artisan->bio ?? 'No bio provided.')) }}',
                                    skills: '{{ addslashes($artisan->skills ?? 'None listed') }}'
                                })" style="padding: 8px 12px; font-size: 11px;">Details</button>
                                <form action="{{ route('admin.artisans.approve', $artisan->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn-action" style="background: var(--green); padding: 8px 16px;">Approve</button>
                                </form>
                                <form action="{{ route('admin.artisans.reject', $artisan->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn-action" style="background: var(--red); padding: 8px 16px;">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px; color: var(--ink-muted);">
                            <div style="font-size: 16px; font-weight: 500;">No pending artisan approvals.</div>
                            <p style="font-size: 14px; margin-top: 8px;">All artisan applications have been processed.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Artisan Details Modal -->
    <div id="artisanModal" class="modal-overlay" style="display:none;" onclick="if(event.target == this) closeArtisanModal()">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 id="art-name">Artisan Details</h3>
                    <p id="art-service" style="font-size: 13px; color: var(--terracotta); font-weight: 700; margin-top: 4px;">Craft Type</p>
                </div>
                <button class="close-btn" onclick="closeArtisanModal()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="details-grid">
                    <div class="detail-group">
                        <label>Location</label>
                        <p id="art-location"></p>
                    </div>
                    <div class="detail-group">
                        <label>Experience</label>
                        <p id="art-experience"></p>
                    </div>
                    <div class="detail-group full">
                        <label>Specialized Skills</label>
                        <p id="art-skills"></p>
                    </div>
                    <div class="detail-group full">
                        <label>About the Artisan</label>
                        <p id="art-bio" style="line-height: 1.6;"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-action" style="width: 100%;" onclick="closeArtisanModal()">Done Reviewing</button>
            </div>
        </div>
    </div>

    <style>
        .btn-detail {
            font-size: 11px; font-weight: 700; background: var(--bg); border: 1px solid var(--border);
            padding: 4px 10px; border-radius: 8px; cursor: pointer; color: var(--ink-muted);
            transition: all 0.2s;
        }
        .btn-detail:hover { background: var(--sand); border-color: var(--terracotta); color: var(--terracotta); }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(10, 10, 10, 0.4); backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            z-index: 1000; transition: all 0.3s ease;
        }
        .modal-content {
            background: #fff; width: 90%; max-width: 500px; border-radius: 32px; padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: modalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes modalSlide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
        .modal-header h3 { font-size: 24px; font-weight: 800; color: var(--ink); }
        .close-btn { background: var(--bg); border: 1px solid var(--border); padding: 8px; border-radius: 12px; cursor: pointer; color: var(--ink-muted); }
        .close-btn:hover { background: var(--sand); color: var(--terracotta); border-color: var(--terracotta); }

        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .detail-group.full { grid-column: span 2; }
        .detail-group label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--ink-muted); letter-spacing: 0.05em; margin-bottom: 6px; }
        .detail-group p { font-size: 15px; font-weight: 600; color: var(--ink); }
        
        .modal-footer { margin-top: 40px; }
    </style>

    <script>
        function showArtisanDetails(data) {
            document.getElementById('art-name').innerText = data.name;
            document.getElementById('art-service').innerText = data.service;
            document.getElementById('art-location').innerText = data.location;
            document.getElementById('art-experience').innerText = data.experience;
            document.getElementById('art-skills').innerText = data.skills;
            document.getElementById('art-bio').innerText = data.bio;
            document.getElementById('artisanModal').style.display = 'flex';
        }
        function closeArtisanModal() { document.getElementById('artisanModal').style.display = 'none'; }
    </script>
@endsection
