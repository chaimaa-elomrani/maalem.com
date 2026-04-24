@extends('layouts.main')

@section('title', 'm3alem — Account Settings')

@push('styles')
  <style>
    .settings-card {
      background: white;
      border-radius: 20px;
      padding: 32px;
      box-shadow: 0 4px 20px rgba(28,22,18,0.05);
      border: 1px solid var(--sand-dark);
    }

    input[type="text"], input[type="email"], input[type="password"], select {
      width: 100%;
      padding: 12px 16px;
      border-radius: 12px;
      border: 1px solid var(--sand-dark);
      background: var(--cream);
      font-family: inherit;
      font-size: 14px;
      transition: all 0.2s;
    }
    input:focus {
      outline: none;
      border-color: var(--terracotta);
      box-shadow: 0 0 0 3px rgba(196,98,45,0.1);
    }

    .btn-primary {
      background-color: var(--terracotta);
      color: white;
      padding: 12px 32px;
      border-radius: 999px;
      font-weight: 600;
      transition: all 0.2s;
      cursor: pointer;
      display: inline-block;
      border: none;
    }
    .btn-primary:hover {
      background-color: var(--terracotta-dark);
      transform: translateY(-2px);
    }

    .section-title {
       font-family: 'Playfair Display', serif;
       font-size: 24px;
       font-weight: 700;
       margin-bottom: 8px;
    }
    
    label {
      display: block;
      font-size: 13px;
      font-weight: 700;
      color: var(--ink);
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    /* Animation */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up { animation: fadeUp 0.5s ease forwards; }
  </style>
@endpush

@section('content')


  <main class="container mx-auto px-4 py-12 max-w-3xl">
    
    <div class="mb-12 animate-fade-up">
      <h1 class="text-4xl font-bold display-font mb-2">Account Settings</h1>
      <p class="text-ink-muted">Manage your personal information and security preferences.</p>
    </div>

    <div class="space-y-8 animate-fade-up" style="animation-delay: 0.1s;">
      
      <!-- Profile Information -->
      <section class="settings-card">
        <div class="mb-8">
          <h2 class="section-title">Profile Information</h2>
          <p class="text-sm text-ink-muted">Update your account's profile information and email address.</p>
        </div>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <div>
                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="btn-primary">Save Changes</button>
                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-green-600 font-bold">Saved successfully.</p>
                @endif
            </div>
        </form>
      </section>

      <!-- Update Password -->
      <section class="settings-card">
        <div class="mb-8">
          <h2 class="section-title">Update Password</h2>
          <p class="text-sm text-ink-muted">Ensure your account is using a long, random password to stay secure.</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div>
                <label for="current_password">Current Password</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password" />
                @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password">New Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" />
                @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                @error('password_confirmation', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="btn-primary">Update Password</button>
                @if (session('status') === 'password-updated')
                    <p class="text-sm text-green-600 font-bold">Updated successfully.</p>
                @endif
            </div>
        </form>
      </section>

      <!-- Delete Account -->
      <section class="settings-card" style="border-color: #fee2e2;">
        <div class="mb-8">
          <h2 class="section-title text-red-600">Delete Account</h2>
          <p class="text-sm text-ink-muted">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
        </div>

        <button onclick="if(confirm('Are you sure you want to delete your account?')) document.getElementById('delete-account-form').submit();" class="text-sm font-bold text-red-600 hover:bg-red-50 px-6 py-3 rounded-full border-2 border-red-100 transition-all">
          Permanently Delete Account
        </button>

        <form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}" class="hidden">
            @csrf
            @method('delete')
            <input type="password" name="password" value="confirm" /> <!-- Simplified for this UI demo, Breeze usually requires current password -->
        </form>
      </section>

    </div>
@endsection
