<?php

namespace App\Http\Controllers;

use App\Models\DeliveryRequest;
use App\Models\Artisan;
use App\Models\Mediateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Store a newly created delivery request (Client).
     */
    public function store(Request $request)
    {
        $request->validate([
            'artisan_id' => 'required|exists:artisans,id',
            'description' => 'required|string',
            'adresse' => 'required|string',
            'deliveryDate' => 'required|date|after_or_equal:today',
        ]);

        $client = Auth::user()->client;

        if (!$client) {
            return back()->with('error', 'Only clients can request mediation services.');
        }

        DeliveryRequest::create([
            'client_id' => $client->id,
            'artisan_id' => $request->artisan_id,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'deliveryDate' => $request->deliveryDate,
            'status' => DeliveryRequest::STATUS_PENDING,
        ]);

        return back()->with('success', 'Mediation request submitted successfully! A mediator will contact you soon.');
    }

    /**
     * Mediator Dashboard: List available and active requests.
     */
    public function mediatorDashboard()
    {
        $user = Auth::user();
        if ($user->role !== 'mediateur') {
            abort(403);
        }

        $availableRequests = DeliveryRequest::where('status', DeliveryRequest::STATUS_PENDING)->get();
        
        if (!$user->mediateur) {
            $myDeliveries = collect();
            $completedCount = 0;
        } else {
            $myDeliveries = DeliveryRequest::where('mediateur_id', $user->mediateur->id)
                ->where('status', '!=', DeliveryRequest::STATUS_DELIVERED)
                ->get();
            
            $completedCount = DeliveryRequest::where('mediateur_id', $user->mediateur->id)
                ->where('status', DeliveryRequest::STATUS_DELIVERED)
                ->count();
        }
        return view('mediateur.dashboard', compact('availableRequests', 'myDeliveries', 'completedCount', 'user'));
    }

    /**
     * Mediator accepts a request.
     */
    public function accept(DeliveryRequest $deliveryRequest)
    {
        $this->authorizeMediator();

        if ($deliveryRequest->status !== DeliveryRequest::STATUS_PENDING) {
            return back()->with('error', 'Request already taken.');
        }

        $deliveryRequest->update([
            'mediateur_id' => Auth::user()->mediateur->id,
            'status' => DeliveryRequest::STATUS_ACCEPTED_BY_MEDIATOR,
        ]);

        $notification = new \App\Notifications\DeliveryStatusUpdated($deliveryRequest->id, 'Accepted by Mediator');
        if ($deliveryRequest->client && $deliveryRequest->client->user) {
            $deliveryRequest->client->user->notify($notification);
        }
        if ($deliveryRequest->artisan && $deliveryRequest->artisan->user) {
            $deliveryRequest->artisan->user->notify($notification);
        }

        return back()->with('success', 'You have accepted the delivery request.');
    }

    /**
     * Update delivery status.
     */
    public function updateStatus(Request $request, DeliveryRequest $deliveryRequest)
    {
        $user = Auth::user();

        // Security check: Only involved parties can update relevant statuses
        if ($user->role === 'mediateur' && $deliveryRequest->mediateur_id === $user->mediateur->id) {
            $allowedStatuses = [
                DeliveryRequest::STATUS_PICKED_UP_CLIENT,
                DeliveryRequest::STATUS_AT_ARTISAN,
                DeliveryRequest::STATUS_DELIVERED
            ];
            
            if (in_array($request->status, $allowedStatuses)) {
                $deliveryRequest->update(['status' => $request->status]);
                
                $notification = new \App\Notifications\DeliveryStatusUpdated($deliveryRequest->id, $deliveryRequest->status_label);
                if ($deliveryRequest->client && $deliveryRequest->client->user) $deliveryRequest->client->user->notify($notification);
                if ($deliveryRequest->artisan && $deliveryRequest->artisan->user) $deliveryRequest->artisan->user->notify($notification);
                
                return back()->with('success', 'Status updated.');
            }
        }

        if ($user->role === 'artisan' && $deliveryRequest->artisan_id === $user->artisan->id) {
            $allowedStatuses = [
                DeliveryRequest::STATUS_IN_PROGRESS,
                DeliveryRequest::STATUS_READY_FOR_RETURN
            ];

            if (in_array($request->status, $allowedStatuses)) {
                $deliveryRequest->update(['status' => $request->status]);
                
                $notification = new \App\Notifications\DeliveryStatusUpdated($deliveryRequest->id, $deliveryRequest->status_label);
                if ($deliveryRequest->client && $deliveryRequest->client->user) $deliveryRequest->client->user->notify($notification);
                if ($deliveryRequest->mediateur && $deliveryRequest->mediateur->user) $deliveryRequest->mediateur->user->notify($notification);

                return back()->with('success', 'Status updated.');
            }
        }

        return back()->with('error', 'Unauthorized status transition.');
    }

    private function authorizeMediator()
    {
        if (Auth::user()->role !== 'mediateur') {
            abort(403);
        }
    }
}
