<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artisan;
use App\Models\Client;
use App\Models\Mediateur;
use App\Models\DeliveryRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_artisans' => Artisan::count(),
            'total_clients' => Client::count(),
            'active_deliveries' => DeliveryRequest::whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'pending_approvals' => Artisan::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'total_mediateurs' => Mediateur::count(),
        ];

        $recentRegistrations = User::whereIn('role', ['artisan', 'mediateur', 'client'])
            ->latest()
            ->take(5)
            ->get();

        $recentDeliveries = DeliveryRequest::with(['client.user', 'artisan.user', 'mediateur.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'recentDeliveries'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function pendingApprovals()
    {
        $pendingArtisans = Artisan::with('user')->where('status', 'pending')->get();
        return view('admin.validation', compact('pendingArtisans'));
    }

    public function approveArtisan(Artisan $artisan)
    {
        $artisan->update(['status' => 'approved']);
        return back()->with('success', 'Artisan approved successfully.');
    }

    public function rejectArtisan(Artisan $artisan)
    {
        $artisan->update(['status' => 'rejected']);
        return back()->with('success', 'Artisan rejected.');
    }

    public function deliveries()
    {
        $deliveries = DeliveryRequest::with(['client.user', 'artisan.user', 'mediateur.user'])->latest()->paginate(20);
        return view('admin.deliveries', compact('deliveries'));
    }
}
