@extends('layouts.admin')

@section('title', 'm3alem Admin — Reports & Issues')
@section('header_title', 'Reports & Issues')
@section('header_subtitle', 'Monitor user complaints, fraud alerts, and system issues.')

@section('content')
    <!-- Filters -->
    <div class="card" style="padding: 20px; margin-bottom: 32px; display: flex; align-items: center; gap: 24px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <label style="font-size: 13px; font-weight: 600; color: var(--ink-muted);">Status</label>
            <select style="padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); background: #f8f9fa; font-size: 13px; outline: none;">
                <option>All</option>
                <option>Pending</option>
                <option>Resolved</option>
            </select>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <label style="font-size: 13px; font-weight: 600; color: var(--ink-muted);">Priority</label>
            <select style="padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); background: #f8f9fa; font-size: 13px; outline: none;">
                <option>All</option>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <label style="font-size: 13px; font-weight: 600; color: var(--ink-muted);">Category</label>
            <select style="padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); background: #f8f9fa; font-size: 13px; outline: none;">
                <option>All</option>
                <option>Payment</option>
                <option>Content</option>
                <option>Delivery</option>
            </select>
        </div>
        <button style="padding: 10px 24px; border-radius: 8px; border: none; background: #C38B5F; color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: opacity 0.2s;">Filter Reports</button>
    </div>

    <!-- Reports Grid -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        @php
            $reports = [
                ['title' => 'Payment Processing Delay', 'status' => 'HIGH', 'id' => 'RP-2024-001', 'date' => '2024-12-20', 'desc' => 'User reported that payment of $450 is pending for 48 hours. System showing successful transaction but funds not received.', 'user' => 'Ahmed Hassan', 'btn1' => 'View Details', 'btn2' => 'Close'],
                ['title' => 'Fraudulent Order Detection', 'status' => 'HIGH', 'id' => 'RP-2024-002', 'date' => '2024-12-20', 'desc' => 'Unusual activity detected: 5 orders placed from same IP in 2 minutes using different payment cards. Auto-flagged for review.', 'user' => 'Unknown User', 'btn1' => 'Investigate', 'btn2' => 'Archive'],
                ['title' => 'Inappropriate Content Uploaded', 'status' => 'HIGH', 'id' => 'RP-2024-003', 'date' => '2024-12-20', 'desc' => 'Artisan profile contains images that violate community guidelines. Content reported by multiple users.', 'artisan' => 'User ID #5847', 'btn1' => 'Review', 'btn2' => 'Suspend'],
                ['title' => 'Delivery Address Mismatch', 'status' => 'MEDIUM', 'id' => 'RP-2024-004', 'date' => '2024-12-19', 'desc' => 'Customer reported that package arrived at wrong address. Order tracking shows correct delivery but address differs from confirmation.', 'order' => '#ORD-45823', 'btn1' => 'View Details', 'btn2' => 'Resolve'],
                ['title' => 'Low Customer Satisfaction Score', 'status' => 'MEDIUM', 'id' => 'RP-2024-005', 'date' => '2024-12-19', 'desc' => 'Artisan "Pottery Masters" has dropped to 2.8 stars with 5 negative reviews in last 2 weeks citing quality issues.', 'artisan' => '#1234', 'btn1' => 'Review Feedback', 'btn2' => 'Close'],
                ['title' => 'API Connection Error', 'status' => 'LOW', 'id' => 'RP-2024-006', 'date' => '2024-12-19', 'desc' => 'Intermittent connection issues with payment gateway. Auto-logs show 3% failed transactions between 14:30-15:45.', 'system' => 'Payment Gateway', 'btn1' => 'View Logs', 'btn2' => 'Monitor'],
            ];
        @endphp

        @foreach($reports as $report)
        <div class="card" style="padding: 24px; position: relative; display: flex; flex-direction: column; gap: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <h3 style="font-size: 15px; font-weight: 700; width: 70%; line-height: 1.4;">{{ $report['title'] }}</h3>
                <span style="font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 4px; border: 1px solid {{ $report['status'] == 'HIGH' ? '#FECACA' : ($report['status'] == 'MEDIUM' ? '#FEF3C7' : '#E5E7EB') }}; color: {{ $report['status'] == 'HIGH' ? '#DC2626' : ($report['status'] == 'MEDIUM' ? '#D97706' : '#6B7280') }};">
                    {{ $report['status'] }}
                </span>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; color: var(--ink-muted);">
                <span>ID: {{ $report['id'] }}</span>
                <span>{{ $report['date'] }}</span>
            </div>

            <p style="font-size: 13px; line-height: 1.6; color: var(--ink-2);">
                {{ $report['desc'] }}
            </p>

            <div style="font-size: 12px; font-weight: 600; margin-top: 8px;">
                @if(isset($report['user']))
                    <span style="color: var(--ink-muted);">User:</span> <span>{{ $report['user'] }}</span>
                @elseif(isset($report['artisan']))
                    <span style="color: var(--ink-muted);">Artisan:</span> <span>{{ $report['artisan'] }}</span>
                @elseif(isset($report['order']))
                    <span style="color: var(--ink-muted);">Order:</span> <span>{{ $report['order'] }}</span>
                @elseif(isset($report['system']))
                    <span style="color: var(--ink-muted);">System:</span> <span>{{ $report['system'] }}</span>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px;">
                <button style="padding: 10px; border-radius: 8px; border: 1px solid #f0f0f0; background: #FAF9F6; color: var(--ink-muted); font-size: 12px; font-weight: 700; cursor: pointer;">{{ $report['btn1'] }}</button>
                <button style="padding: 10px; border-radius: 8px; border: none; background: #FEF2F2; color: #DC2626; font-size: 12px; font-weight: 700; cursor: pointer;">{{ $report['btn2'] }}</button>
            </div>
        </div>
        @endforeach
    </div>
@endsection
