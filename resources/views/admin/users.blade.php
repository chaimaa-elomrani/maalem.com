@extends('layouts.admin')

@section('title', 'm3alem Admin — All Users')
@section('header_title', 'User Management')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px">
    <div>
        <div class="sec-head">
            <h2>System Users</h2>
            <div class="tb-badge">{{ \App\Models\User::count() }} Total</div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>City</th>
                        <th>Joined</th>
                        <th style="text-align:right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="pill {{ $user->role == 'artisan' ? 'p-amber' : ($user->role == 'mediateur' ? 'p-blue' : ($user->role == 'admin' ? 'p-red' : 'p-gray')) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->city ?? '—' }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right">
                            <button class="btn-g">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
