@extends('layouts.main')

@php $minimal = true; @endphp

@section('title', 'Maalem – Verify Email')

@push('styles')
  <style>
    /* Mosaic background grid */
    .mosaic {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      grid-template-rows: repeat(2, 1fr);
      position: absolute;
      inset: 0;
      overflow: hidden;
      z-index: 0;
    }
    .mosaic-cell {
      background-size: cover;
      background-position: center;
      filter: brightness(0.4) saturate(0.8);
    }
    .cell-1 { background-image: url('../images/image 26.png'); }
    .cell-2 { background-image: url('../images/image 42.png'); }
    .cell-3 { background-image: url('../images/image 34.png'); }
    .cell-4 { background-image: url('../images/image 35.png'); }
    .cell-5 { background-image: url('../images/image 36.png'); }
    .cell-6 { background-image: url('../images/image 37.png'); }
    .cell-7 { background-image: url('./images/image 38.png'); }
    .cell-8 { background-image: url('./images/image 39.png'); }
    .cell-9 { background-image: url('./images/image 40.png'); }
    .cell-10 { background-image: url('./images/Tapis Marocaine.jpeg'); }
    .cell-11 { background-image: url('./images/Artisan Woman Weaving Traditional Moroccan Baskets.jpeg'); }
    .cell-12 { background-image: url('./images/L’Artisanat Marocain _ Un Héritage de Savoir-Faire Authentique.jpeg'); }
    .cell-13 { background-image: url('./images/Tapis Marocaine.jpeg'); }

    /* Card */
    .auth-card {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      box-shadow: 0 32px 80px rgba(0,0,0,0.35);
      border-radius: 16px;
      padding: 32px;
      width: 100%;
      max-width: 500px;
      animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .btn-submit {
      background: linear-gradient(135deg, #e8601c 0%, #c94a10 100%);
      color: #fff;
      padding: 10px 20px;
      border-radius: 999px;
      font-weight: 600;
      transition: opacity 0.2s;
      font-size: 14px;
    }
    .btn-submit:hover { opacity: 0.9; }

    .auth-bg-overlay {
      position: absolute; inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 1;
    }
    .auth-container {
      position: relative; z-index: 10;
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      padding: 24px;
    }
  </style>
@endpush

@section('content')
<div class="relative min-h-screen overflow-hidden">
    <div class="mosaic">
        @for($i=1; $i<=13; $i++)
            <div class="mosaic-cell cell-{{$i}}"></div>
        @endfor
    </div>
    <div class="auth-bg-overlay"></div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold text-gray-900 display-font">Verify Email</h1>
                <p class="text-xs text-gray-500 mt-1 body-font">One last step to join Maalem</p>
            </div>

            <div class="mb-4 text-xs text-gray-600 leading-relaxed body-font">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-xs text-green-600 body-font">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-6 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-submit body-font">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 font-semibold hover:text-orange-600 hover:underline body-font">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
