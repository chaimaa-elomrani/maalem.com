<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Maalem – Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'DM Sans', sans-serif; }
    h1, h2 { font-family: 'Playfair Display', serif; }

    /* Mosaic background grid */
    .mosaic {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      grid-template-rows: repeat(2, 1fr);
      position: absolute;
      inset: 0;
      overflow: hidden;
    }
    .mosaic-cell {
      background-size: cover;
      background-position: center;
      filter: brightness(0.45) saturate(0.8);
      transition: filter 0.6s ease;
    }

    /* Moroccan market images via Unsplash */
    .cell-1 { background-image: url('../images/image\ 26.png'); }
    .cell-2 { background-image: url('../images/image\ 42.png'); }
    .cell-3 { background-image: url('../images/image\ 34.png'); }
    .cell-4 { background-image: url('../images/image\ 35.png'); }
    .cell-5 { background-image: url('../images/image\ 36.png'); }
    .cell-6 { background-image: url('../images/image\ 37.png'); }
    .cell-7 { background-image: url('./images/image\ 38.png'); }
    .cell-8 { background-image: url('./images/image\ 39.png'); }
    .cell-9 { background-image: url('./images/image\ 40.png'); }
    .cell-10 { background-image: url('./images/Tapis\ Marocaine.jpeg'); }
    .cell-11 { background-image: url('./images/Artisan\ Woman\ Weaving\ Traditional\ Moroccan\ Baskets.jpeg'); }
    .cell-12 { background-image: url('./images/L’Artisanat\ Marocain\ _\ Un\ Héritage\ de\ Savoir-Faire\ Authentique.jpeg'); }
    .cell-13 { background-image: url('./images/Tapis\ Marocaine.jpeg'); }


    /* Card glassmorphism */
    .card {
      background: rgba(255, 255, 255, 0.97);
      backdrop-filter: blur(20px);
      box-shadow: 0 32px 80px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,255,255,0.15);
      animation: slideUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(32px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .hero-text {
      animation: fadeIn 0.8s 0.2s both;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(-20px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* Input focus ring */
    .input-field {
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-field:focus {
      outline: none;
      border-color: #e8601c;
      box-shadow: 0 0 0 3px rgba(232, 96, 28, 0.15);
    }

    /* CTA button */
    .btn-primary {
      background: linear-gradient(135deg, #e8601c 0%, #c94a10 100%);
      transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
    }
    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(232, 96, 28, 0.45);
      opacity: 0.95;
    }
    .btn-primary:active {
      transform: translateY(0);
    }

    /* Divider */
    .divider-line {
      flex: 1;
      height: 1px;
      background: #e5e7eb;
    }

    /* Google button */
    .btn-google {
      border: 1.5px solid #e5e7eb;
      transition: background 0.15s, border-color 0.15s;
    }
    .btn-google:hover {
      background: #f9fafb;
      border-color: #d1d5db;
    }

    /* Password eye toggle */
    .eye-btn { cursor: pointer; color: #9ca3af; }
    .eye-btn:hover { color: #6b7280; }
  </style>
</head>
<body class="relative min-h-screen flex items-center justify-center overflow-hidden">

  <!-- Mosaic background -->
  <div class="mosaic">
    <div class="mosaic-cell cell-1"></div>
    <div class="mosaic-cell cell-2"></div>
    <div class="mosaic-cell cell-3"></div>
    <div class="mosaic-cell cell-4"></div>
    <div class="mosaic-cell cell-5"></div>
    <div class="mosaic-cell cell-6"></div>
    <div class="mosaic-cell cell-7"></div>
    <div class="mosaic-cell cell-8"></div>
    <div class="mosaic-cell cell-9"></div>
    <div class="mosaic-cell cell-10"></div>
    <div class="mosaic-cell cell-11"></div>
    <div class="mosaic-cell cell-12"></div>
    <div class="mosaic-cell cell-13"></div>

  </div>

  <!-- Gradient overlay -->
  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent pointer-events-none"></div>

  <!-- Main layout -->
  <div class="relative z-10 w-full max-w-7xl mx-auto px-6 flex items-center justify-between gap-12">

    <!-- Hero copy -->
    <div class="hero-text hidden md:block flex-1 text-white max-w-xs">
      <p class="text-xs uppercase tracking-widest text-orange-400 mb-3 font-semibold">Maalem Platform</p>
      <h2 class="text-4xl leading-tight font-bold mb-4">
        Sign up and get<br/>your needed<br/>services
      </h2>
      <p class="text-sm text-white/60 leading-relaxed">
        Connect with artisans, makers, and skilled professionals. Trade expertise, grow together.
      </p>
    </div>

    <!-- Sign-up card -->
    <div class="card w-full max-w-xl rounded-2xl px-8 py-10">

      <!-- Header -->
      <div class="text-center mb-6">
        <h1 class="text-xl font-bold text-gray-900 mb-1">Welcome to Maalem</h1>
        <p class="text-xs text-gray-400 tracking-wide">Explore different services</p>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('register') }}" class="space-y-4">

        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Name -->
          <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus class="input-field w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-800 placeholder-gray-300 bg-white" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
          </div>

          <!-- Email -->
          <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required class="input-field w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-800 placeholder-gray-300 bg-white" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Phone -->
          <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone number" required class="input-field w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-800 placeholder-gray-300 bg-white" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs text-red-500" />
          </div>

          <!-- City -->
          <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">City</label>
            <input type="text" name="city" value="{{ old('city') }}" placeholder="Your city" required class="input-field w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-800 placeholder-gray-300 bg-white" />
            <x-input-error :messages="$errors->get('city')" class="mt-1 text-xs text-red-500" />
          </div>
        </div>

        <!-- Role -->
        <div>
          <label class="block text-xs font-medium text-gray-600 mb-1.5">Role</label>
          <select name="role" required class="input-field w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-800 bg-white">
            <option value="" disabled selected>Select a role</option>
            <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
            <option value="artisan" {{ old('role') == 'artisan' ? 'selected' : '' }}>Artisan</option>
            <option value="mediateur" {{ old('role') == 'mediateur' ? 'selected' : '' }}>Mediateur</option>
          </select>
          <x-input-error :messages="$errors->get('role')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Password -->
          <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Password</label>
            <div class="relative">
              <input id="password" name="password" type="password" placeholder="Create a password" required class="input-field w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 text-sm text-gray-800 placeholder-gray-300 bg-white" />
              <button type="button" class="eye-btn absolute right-3 top-1/2 -translate-y-1/2" onclick="togglePassword('password', 'eye-icon')">
                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
          </div>

          <!-- Password Confirmation -->
          <div>
            <label class="block text-xs font-medium text-gray-600 mb-1.5">Confirm Password</label>
            <div class="relative">
              <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" required class="input-field w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 text-sm text-gray-800 placeholder-gray-300 bg-white" />
              <button type="button" class="eye-btn absolute right-3 top-1/2 -translate-y-1/2" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')">
                <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
          </div>
        </div>

        <!-- CTA -->
        <button type="submit" class="btn-primary w-full py-3 rounded-full text-white text-sm font-semibold tracking-wide mt-1">
          Get Started
        </button>

      </form>

      <!-- Divider -->
      <div class="flex items-center gap-3 my-4">
        <span class="divider-line"></span>
        <span class="text-xs text-gray-400">or</span>
        <span class="divider-line"></span>
      </div>

      <!-- Google SSO -->
      <button class="btn-google w-full flex items-center justify-center gap-2.5 py-2.5 rounded-lg bg-white text-sm font-medium text-gray-700">
        <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
          <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
          <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
          <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continue with Google
      </button>

      <!-- Footer -->
      <p class="text-center text-xs text-gray-400 mt-4 leading-relaxed">
        By continuing, you agree to Maalem's
        <a href="#" class="text-gray-600 underline underline-offset-2">Terms of Service</a>
        and acknowledge you've read our
        <a href="#" class="text-gray-600 underline underline-offset-2">Privacy Policy</a>.
      </p>

      <p class="text-center text-xs text-gray-500 mt-3">
        Already a member?
        <a href="{{ route('login') }}" class="text-orange-600 font-semibold hover:underline ml-1">Log in</a>
      </p>
    </div>

  </div>

  <script>
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
      } else {
        input.type = 'password';
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
      }
    }
  </script>
</body>
</html>