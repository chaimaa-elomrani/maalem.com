@extends('layouts.admin')

@section('title', 'm3alem Admin — All Deliveries')
@section('header_title', 'Delivery Management')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px">
    <div>
        <div class="sec-head">
            <h2 style="font-size: 24px; font-weight: 800; color: var(--ink);">Delivery Management</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Artisan</th>
                        <th>Mediator</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="text-align:right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveries as $delivery)
                    <tr>
                        <td style="color:var(--ink-muted);font-size:11px; font-weight: 700;">#DEL-{{ str_pad($delivery->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $delivery->client->user->name ?? '—' }}</strong></td>
                        <td>{{ $delivery->artisan->user->name ?? '—' }}</td>
                        <td>{{ $delivery->mediateur->user->name ?? '—' }}</td>
                        <td>
                            <span class="pill {{ $delivery->status == 'delivered' ? 'p-green' : ($delivery->status == 'pending' ? 'p-amber' : ($delivery->status == 'cancelled' ? 'p-red' : 'p-blue')) }}">
                                <span class="pill-dot"></span>{{ str_replace('_', ' ', $delivery->getStatusLabelAttribute()) }}
                            </span>
                        </td>
                        <td style="color: var(--ink-muted);">{{ $delivery->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right">
                            <button class="btn-g" onclick="showDeliveryDetails({
                                id: '{{ $delivery->id }}',
                                client: '{{ addslashes($delivery->client->user->name ?? '—') }}',
                                artisan: '{{ addslashes($delivery->artisan->user->name ?? '—') }}',
                                mediator: '{{ addslashes($delivery->mediateur->user->name ?? '—') }}',
                                status: '{{ str_replace('_', ' ', $delivery->getStatusLabelAttribute()) }}',
                                date: '{{ $delivery->created_at->format('M d, Y H:i') }}',
                                address: '{{ addslashes($delivery->adresse ?? 'Not provided') }}',
                                deliveryDate: '{{ $delivery->deliveryDate ?? 'Not set' }}',
                                description: '{{ addslashes(str_replace(["\r", "\n"], ' ', $delivery->description ?? 'No description.')) }}'
                            })">Details</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 24px">
            {{ $deliveries->links() }}
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="modal-overlay" style="display:none;" onclick="if(event.target == this) closeDetailsModal()">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h3 id="modalTitle">Delivery Details</h3>
                <p id="modalSub" style="font-size: 12px; color: var(--ink-muted); margin-top: 4px;">#DEL-000</p>
            </div>
            <button class="close-btn" onclick="closeDetailsModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="details-grid">
                <div class="detail-group">
                    <label>Client</label>
                    <p id="det-client"></p>
                </div>
                <div class="detail-group">
                    <label>Artisan</label>
                    <p id="det-artisan"></p>
                </div>
                <div class="detail-group">
                    <label>Mediator</label>
                    <p id="det-mediator"></p>
                </div>
                <div class="detail-group">
                    <label>Current Status</label>
                    <p id="det-status"></p>
                </div>
                <div class="detail-group">
                    <label>Created At</label>
                    <p id="det-date"></p>
                </div>
                <div class="detail-group">
                    <label>Scheduled Delivery</label>
                    <p id="det-deliveryDate"></p>
                </div>
                <div class="detail-group full">
                    <label>Pickup / Delivery Address</label>
                    <p id="det-address"></p>
                </div>
                <div class="detail-group full">
                    <label>Job Description</label>
                    <p id="det-description" style="line-height: 1.6;"></p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-action" style="width: 100%;" onclick="closeDetailsModal()">Close Details</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .sec-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .tb-badge { background: var(--sand); color: var(--terracotta); padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; }
    
    .table-wrap { background: #fff; border: 1px solid var(--border); border-radius: 24px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    
    .pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .pill-dot { width: 6px; height: 6px; border-radius: 50%; }
    .p-green { background: #ECFDF5; color: #059669; }
    .p-green .pill-dot { background: #10B981; }
    .p-amber { background: #FFFBEB; color: #D97706; }
    .p-amber .pill-dot { background: #F59E0B; }
    .p-red { background: #FEF2F2; color: #DC2626; }
    .p-red .pill-dot { background: #EF4444; }
    .p-blue { background: #EFF6FF; color: #2563EB; }
    .p-blue .pill-dot { background: #3B82F6; }

    .btn-g { 
        background: #F8F9FA; border: 1px solid var(--border); color: var(--ink);
        padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: 600; cursor: pointer;
        transition: all 0.2s;
    }
    .btn-g:hover { background: var(--sand); border-color: var(--terracotta); color: var(--terracotta); }

    /* Modal Styles */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(10, 10, 10, 0.4); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000; transition: all 0.3s ease;
    }
    .modal-content {
        background: #fff; width: 90%; max-width: 550px;
        border-radius: 32px; padding: 40px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        animation: modalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .modal-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
    .modal-header h3 { font-size: 24px; font-weight: 800; color: var(--ink); }
    .close-btn { background: var(--bg); border: 1px solid var(--border); padding: 8px; border-radius: 12px; cursor: pointer; color: var(--ink-muted); transition: all 0.2s; }
    .close-btn:hover { background: var(--sand); color: var(--terracotta); border-color: var(--terracotta); }

    .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .detail-group.full { grid-column: span 2; }
    .detail-group label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--ink-muted); letter-spacing: 0.05em; margin-bottom: 6px; }
    .detail-group p { font-size: 15px; font-weight: 600; color: var(--ink); }
    
    .modal-footer { margin-top: 40px; }
</style>
@endpush

@push('scripts')
<script>
    function showDeliveryDetails(data) {
        document.getElementById('modalSub').innerText = '#DEL-' + data.id.toString().padStart(3, '0');
        document.getElementById('det-client').innerText = data.client;
        document.getElementById('det-artisan').innerText = data.artisan;
        document.getElementById('det-mediator').innerText = data.mediator;
        document.getElementById('det-status').innerText = data.status;
        document.getElementById('det-date').innerText = data.date;
        document.getElementById('det-deliveryDate').innerText = data.deliveryDate;
        document.getElementById('det-address').innerText = data.address;
        document.getElementById('det-description').innerText = data.description;
        
        document.getElementById('detailsModal').style.display = 'flex';
    }

    function closeDetailsModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }
</script>
@endpush
@endsection
