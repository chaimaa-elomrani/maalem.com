@extends('layouts.admin')

@section('title', 'm3alem Admin — Dashboard')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Welcome back, Admin. Here\'s your platform overview.')

@section('header_actions')
    <div style="display: flex; gap: 12px;">
        <button style="padding: 10px 20px; border-radius: 12px; border: 1px solid var(--border); background: #fff; font-size: 13px; font-weight: 600; color: var(--ink-muted); cursor: pointer;">Last 30 Days</button>
        <button class="btn-action">Export Report</button>
    </div>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <p class="stat-card-label">Total Users</p>
            <h2 class="stat-card-value">{{ number_format($stats['total_users'] ?? 15342) }}</h2>
  
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Active Artisans</p>
            <h2 class="stat-card-value">{{ number_format($stats['total_artisans'] ?? 2547) }}</h2>

        </div>
        <div class="stat-card">
            <p class="stat-card-label">Total Orders</p>
            <h2 class="stat-card-value">{{ number_format($stats['active_deliveries'] ?? 8924) }}</h2>

        </div>
        <div class="stat-card">
            <p class="stat-card-label">Revenue</p>
            <h2 class="stat-card-value">${{ number_format(($stats['revenue'] ?? 124500) / 1000, 1) }}K</h2>

        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid-2">
        <div class="card">
            <div class="section-title">
                <span>Monthly Revenue</span>
            </div>
            <div style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="section-title">
                <span>User Growth</span>
            </div>
            <div style="height: 300px; display: flex; align-items: center; justify-content: center; position: relative;">
                <canvas id="growthChart"></canvas>
                <div style="position: absolute; text-align: center;">
                    <div style="font-size: 24px; font-weight: 800;">35%</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card" style="padding: 0;">
        <div style="padding: 24px 32px; font-size: 18px; font-weight: 700; border-bottom: 1px solid var(--border);">
            Recent Activity
        </div>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRegistrations->take(5) as $user)
                <tr>
                    <td style="font-weight: 600;">{{ $user->name }}</td>
                    <td>New {{ $user->role }} registration</td>
                    <td style="color: var(--ink-muted);">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <span class="badge badge-success">Completed</span>
                    </td>
                </tr>
                @endforeach
                @foreach($recentDeliveries->take(3) as $delivery)
                <tr>
                    <td style="font-weight: 600;">{{ $delivery->client->user->name ?? 'System' }}</td>
                    <td>Order placed with {{ $delivery->artisan->user->name ?? 'Artisan' }}</td>
                    <td style="color: var(--ink-muted);">{{ $delivery->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <span class="badge {{ $delivery->status == 'delivered' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($delivery->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    // Revenue Chart
    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRev, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
            datasets: [{
                label: 'Revenue',
                data: [35, 48, 62, 58, 70, 65, 82, 75],
                backgroundColor: '#B85C2A',
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, border: { display: false }, grid: { color: '#f0f0f0' } },
                x: { border: { display: false }, grid: { display: false } }
            }
        }
    });

    // Growth Chart (Donut)
    const ctxGro = document.getElementById('growthChart').getContext('2d');
    new Chart(ctxGro, {
        type: 'doughnut',
        data: {
            labels: ['Collectors', 'Artisans', 'Admin'],
            datasets: [{
                data: [45, 35, 20],
                backgroundColor: ['#B85C2A', '#D97B4F', '#D4AF37'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } }
        }
    });
</script>
@endpush
