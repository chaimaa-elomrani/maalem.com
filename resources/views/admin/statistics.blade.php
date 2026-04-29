@extends('layouts.admin')

@section('title', 'm3alem Admin — Statistics')
@section('header_title', 'Detailed Statistics')
@section('header_subtitle', 'In-depth analysis of platform performance and user behavior.')

@section('content')
    <div class="grid-2" style="margin-bottom: 24px;">
        <!-- Sales by Category -->
        <div class="card">
            <div class="section-title">
                <span>Sales by Category</span>
            </div>
            <div style="height: 300px;">
                <canvas id="salesCategoryChart"></canvas>
            </div>
        </div>

        <!-- Order Completion Rate -->
        <div class="card">
            <div class="section-title">
                <span>Order Completion Rate</span>
            </div>
            <div style="height: 300px; display: flex; align-items: center; justify-content: center;">
                <canvas id="completionRateChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid-2" style="grid-template-columns: 1fr 1fr; margin-bottom: 32px;">
        <!-- Customer Satisfaction Trend -->
        <div class="card">
            <div class="section-title">
                <span>Customer Satisfaction Trend</span>
            </div>
            <div style="height: 300px;">
                <canvas id="satisfactionChart"></canvas>
            </div>
        </div>

        <!-- User Demographics -->
        <div class="card">
            <div class="section-title">
                <span>User Demographics</span>
            </div>
            <div style="height: 300px;">
                <canvas id="demographicsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="stat-grid" style="grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <div class="stat-card" style="padding: 24px; position: relative;">
            <p style="font-size: 11px; color: var(--ink-muted); font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Avg. Order Value</p>
            <h3 style="font-size: 28px; font-weight: 800; color: var(--ink);">$285.50</h3>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                <p style="font-size: 12px; color: var(--green); font-weight: 600;">↑ 15%</p>
                <button class="btn-detail" onclick="showMetricDetails('Avg. Order Value', 'In-depth analysis of order amounts across all categories.', '$285.50', '15%', 'positive')">Details</button>
            </div>
        </div>
        <div class="stat-card" style="padding: 24px; position: relative;">
            <p style="font-size: 11px; color: var(--ink-muted); font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Conversion Rate</p>
            <h3 style="font-size: 28px; font-weight: 800; color: var(--ink);">3.8%</h3>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                <p style="font-size: 12px; color: var(--green); font-weight: 600;">↑ 0.5%</p>
                <button class="btn-detail" onclick="showMetricDetails('Conversion Rate', 'Platform-wide visitor to customer conversion tracking.', '3.8%', '0.5%', 'positive')">Details</button>
            </div>
        </div>
        <div class="stat-card" style="padding: 24px; position: relative;">
            <p style="font-size: 11px; color: var(--ink-muted); font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Customer Retention</p>
            <h3 style="font-size: 28px; font-weight: 800; color: var(--ink);">67%</h3>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                <p style="font-size: 12px; color: var(--green); font-weight: 600;">↑ 5%</p>
                <button class="btn-detail" onclick="showMetricDetails('Customer Retention', 'Percentage of users who returned to make another purchase.', '67%', '5%', 'positive')">Details</button>
            </div>
        </div>
        <div class="stat-card" style="padding: 24px; position: relative;">
            <p style="font-size: 11px; color: var(--ink-muted); font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Avg. Response Time</p>
            <h3 style="font-size: 28px; font-weight: 800; color: var(--ink);">2.3h</h3>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                <p style="font-size: 12px; color: var(--green); font-weight: 600;">↓ 0.5h</p>
                <button class="btn-detail" onclick="showMetricDetails('Avg. Response Time', 'Time taken for artisans to respond to first-time client inquiries.', '2.3h', '0.5h improvement', 'positive')">Details</button>
            </div>
        </div>
    </div>

    <!-- Metric Details Modal -->
    <div id="metricModal" class="modal-overlay" style="display:none;" onclick="if(event.target == this) closeMetricModal()">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header">
                <div>
                    <h3 id="met-title">Metric Details</h3>
                    <p id="met-subtitle" style="font-size: 12px; color: var(--ink-muted); margin-top: 4px;">Performance Analysis</p>
                </div>
                <button class="close-btn" onclick="closeMetricModal()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="background: var(--bg); padding: 24px; border-radius: 20px; text-align: center; margin-bottom: 24px;">
                    <h4 id="met-value" style="font-size: 36px; font-weight: 800; color: var(--terracotta);">0.0</h4>
                    <p id="met-trend" style="font-weight: 700; font-size: 13px; margin-top: 4px;">Trend Info</p>
                </div>
                <p id="met-description" style="color: var(--ink-muted); line-height: 1.6; font-size: 14px;"></p>
            </div>
            <div class="modal-footer">
                <button class="btn-action" style="width: 100%;" onclick="closeMetricModal()">Understood</button>
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
            background: #fff; width: 90%; border-radius: 32px; padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: modalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes modalSlide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
        .modal-header h3 { font-size: 24px; font-weight: 800; color: var(--ink); }
        .close-btn { background: var(--bg); border: 1px solid var(--border); padding: 8px; border-radius: 12px; cursor: pointer; color: var(--ink-muted); }
        .close-btn:hover { background: var(--sand); color: var(--terracotta); border-color: var(--terracotta); }
    </style>

    <script>
        function showMetricDetails(title, desc, value, trend, type) {
            document.getElementById('met-title').innerText = title;
            document.getElementById('met-description').innerText = desc;
            document.getElementById('met-value').innerText = value;
            document.getElementById('met-trend').innerText = trend;
            document.getElementById('met-trend').style.color = type == 'positive' ? 'var(--green)' : 'var(--red)';
            document.getElementById('metricModal').style.display = 'flex';
        }
        function closeMetricModal() { document.getElementById('metricModal').style.display = 'none'; }
    </script>
@endsection

@push('scripts')
<script>
    // Sales by Category (Line Chart)
    const ctxSales = document.getElementById('salesCategoryChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: ['Pottery', 'Weaving', 'Leather', 'Metal', 'Textile', 'Ceramic'],
            datasets: [{
                label: 'Sales ($)',
                data: [42, 65, 54, 82, 70, 95],
                borderColor: '#B85C2A',
                backgroundColor: '#B85C2A',
                borderWidth: 3,
                tension: 0.4,
                pointRadius: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f0f0f0' }, ticks: { callback: v => '$' + v + 'K' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Order Completion Rate (Polar Area)
    const ctxComp = document.getElementById('completionRateChart').getContext('2d');
    new Chart(ctxComp, {
        type: 'polarArea',
        data: {
            labels: ['Completed', 'In Progress', 'Pending'],
            datasets: [{
                data: [60, 25, 15],
                backgroundColor: [
                    'rgba(184, 92, 42, 0.8)',
                    'rgba(217, 123, 79, 0.8)',
                    'rgba(212, 175, 55, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: { r: { grid: { display: false }, ticks: { display: false } } }
        }
    });

    // Satisfaction Trend (Area Chart)
    const ctxSub = document.getElementById('satisfactionChart').getContext('2d');
    new Chart(ctxSub, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Rating (%)',
                data: [82, 88, 85, 92, 96, 91],
                borderColor: '#B85C2A',
                backgroundColor: 'rgba(184, 92, 42, 0.1)',
                fill: true,
                borderWidth: 3,
                tension: 0.4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: false, min: 0, max: 100, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // User Demographics (Bar Chart)
    const ctxDemo = document.getElementById('demographicsChart').getContext('2d');
    new Chart(ctxDemo, {
        type: 'bar',
        data: {
            labels: ['18-25', '26-35', '36-45', '46-55', '56-65', '66-75', '75+'],
            datasets: [{
                label: 'Users',
                data: [420, 580, 650, 510, 590, 480, 530],
                backgroundColor: (context) => {
                    const colors = ['#B85C2A', '#C67A53', '#D4987C', '#D9AD98', '#E6C6B5', '#EED9C4', '#F4EAE0'];
                    return colors[context.dataIndex % colors.length];
                },
                borderRadius: 8
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
