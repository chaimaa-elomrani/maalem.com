@extends('layouts.main')

@php $minimal = true; @endphp

@section('title', 'Maalem – Confirm Password')

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
      max-width: 450px;
      animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .input-field {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      font-size: 14px;
      transition: border-color 0.2s;
    }
    .input-field:focus {
      outline: none;
      border-color: #e8601c;
      box-shadow: 0 0 0 3px rgba(232, 96, 28, 0.15);
    }

    .btn-submit {
      background: linear-gradient(135deg, #e8601c 0%, #c94a10 100%);
      color: #fff;
      padding: 12px;
      border-radius: 999px;
      font-weight: 600;
      text-align: center;
      width: 100%;
      transition: opacity 0.2s;
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
                <h1 class="text-xl font-bold text-gray-900 display-font">Confirm Password</h1>
                <p class="text-xs text-gray-500 mt-1 body-font">Please confirm your identity</p>
            </div>

            <div class="mb-4 text-xs text-gray-600 leading-relaxed body-font">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5 body-font">Password</label>
                    <input type="password" name="password" required autocomplete="current-password" class="input-field body-font" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-submit body-font">
                        {{ __('Confirm Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
