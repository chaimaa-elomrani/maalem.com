<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem – Discover Authentic Moroccan Craftsmanship</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root {
      --orange: #C8641E;
      --orange-light: #E07840;
      --orange-dark: #A04E10;
      --cream: #FAF8F5;
      --cream2: #F4F0EB;
      --text: #1A1410;
      --muted: #7A6A5A;
    }

    * { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; background: var(--cream); color: var(--text); margin: 0; }
    h1, h2, h3 { font-family: 'Playfair Display', serif; }

    /* Navbar */
    nav { background: #fff; border-bottom: 1px solid #f0ece7; position: sticky; top: 0; z-index: 100; }

    /* Buttons */
    .btn-primary {
      background: var(--orange);
      color: #fff;
      border-radius: 999px;
      padding: 10px 24px;
      font-size: 14px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s;
    }
    .btn-primary:hover { background: var(--orange-dark); transform: translateY(-1px); color: #fff;}

    .btn-outline {
      background: transparent;
      color: var(--text);
      border-radius: 999px;
      padding: 9px 22px;
      font-size: 14px;
      font-weight: 500;
      border: 1.5px solid #ccc;
      cursor: pointer;
      transition: border-color 0.2s, background 0.2s;
    }
    .btn-outline:hover { border-color: var(--orange); color: var(--orange); }

    /* Hero section */
    .hero { background: var(--cream); }
    .hero-img { border-radius: 16px; object-fit: cover; }

    /* Capability cards */
    .cap-card {
      background: #fff;
      border-radius: 16px;
      padding: 24px;
      border: 1px solid #ede9e4;
      transition: box-shadow 0.2s, transform 0.2s;
    }
    .cap-card:hover { box-shadow: 0 8px 30px rgba(200,100,30,0.10); transform: translateY(-3px); }
    .cap-icon {
      width: 44px; height: 44px;
      background: #FEF0E6;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 14px;
    }

    /* Stats bar */
    .stats-bar {
      background: linear-gradient(135deg, #C8641E 0%, #E07840 60%, #C8641E 100%);
    }

    /* Testimonial cards */
    .testimonial-card {
      background: #fff;
      border-radius: 16px;
      padding: 24px;
      border: 1px solid #ede9e4;
    }
    .star { color: #F5A623; }

    /* Artisan cards */
    .artisan-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid #ede9e4;
      transition: box-shadow 0.2s, transform 0.2s;
    }
    .artisan-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.12); transform: translateY(-4px); }
    .artisan-img { width: 100%; height: 180px; object-fit: cover; }

    /* Gallery */
    .gallery-img { border-radius: 16px; object-fit: cover; width: 100%; height: 200px; }

    /* Pricing */
    .pricing-card {
      background: #fff;
      border-radius: 20px;
      padding: 32px 24px;
      border: 2px solid #ede9e4;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .pricing-card.featured {
      border-color: var(--orange);
      box-shadow: 0 12px 40px rgba(200,100,30,0.15);
      position: relative;
    }
    .pricing-badge {
      position: absolute;
      top: -13px; left: 50%; transform: translateX(-50%);
      background: var(--orange);
      color: #fff;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 14px;
      border-radius: 999px;
      letter-spacing: 0.05em;
    }
    .check-item { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #555; margin-bottom: 10px; }
    .check-icon { color: var(--orange); flex-shrink: 0; }

    /* FAQ */
    .faq-item { border-bottom: 1px solid #e8e3dc; }
    .faq-question {
      width: 100%;
      background: none;
      border: none;
      text-align: left;
      padding: 18px 0;
      font-size: 15px;
      font-weight: 500;
      color: var(--text);
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-family: 'DM Sans', sans-serif;
    }
    .faq-answer { display: none; padding-bottom: 16px; font-size: 14px; color: var(--muted); line-height: 1.7; }
    .faq-item.open .faq-answer { display: block; }
    .faq-icon { transition: transform 0.3s; flex-shrink: 0; }
    .faq-item.open .faq-icon { transform: rotate(45deg); }

    /* CTA dark */
    .cta-dark {
      background: #1A1410;
      background-image: url("{{ asset('images/L’Artisanat Marocain _ Un Héritage de Savoir-Faire Authentique.jpeg') }}");
      background-size: cover;
      background-position: center;
      position: relative;
    }
    .cta-dark::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(15, 10, 5, 0.78);
    }

    /* Footer */
    footer { background: #0F0A05; color: #aaa; }

    /* How it works step */
    .step-circle {
      width: 52px; height: 52px;
      background: var(--orange);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff;
      font-size: 18px;
      font-weight: 700;
      font-family: 'Playfair Display', serif;
      margin: 0 auto 16px;
    }

    /* Section label */
    .section-label {
      text-align: center;
      font-size: 13px;
      font-weight: 500;
      color: var(--muted);
      margin-bottom: 8px;
      letter-spacing: 0.04em;
    }

    /* Fade-in animation */
    .fade-in { opacity: 0; transform: translateY(24px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .fade-in.visible { opacity: 1; transform: translateY(0); }

    /* Avatar circle */
    .avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; color: #fff; }
  </style>
</head>
<body>

<!-- ───────────────── NAVBAR ───────────────── -->
<nav class="py-4">
  <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
    <a href="#" class="text-orange-700 font-bold text-xl hover:text-orange-800" style="font-family:'Playfair Display',serif;">m3alem</a>
    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
      <a href="#features" class="hover:text-orange-600 transition-colors">Features</a>
      <a href="#process" class="hover:text-orange-600 transition-colors">Process</a>
      <a href="#pricing" class="hover:text-orange-600 transition-colors">Pricing</a>
      <a href="#faq" class="hover:text-orange-600 transition-colors">FAQ</a>
    </div>
    
    @if (Route::has('login'))
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary text-sm inline-block no-underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-orange-600 hidden md:block">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary text-sm inline-block no-underline">Get Started</a>
                @endif
            @endauth
        </div>
    @endif
  </div>
</nav>

<!-- ───────────────── HERO ───────────────── -->
<section class="hero py-20 px-6" id="features">
  <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-12">
    <!-- Text -->
    <div class="flex-1 fade-in">
      <h1 class="text-5xl md:text-6xl leading-tight mb-6">
        Discover <span style="color:var(--orange)">Authentic</span><br/>
        Moroccan<br/>
        <span style="color:var(--orange)">Craftsmanship</span>
      </h1>
      <p class="text-base text-gray-500 max-w-md mb-8 leading-relaxed">
        Connect directly with skilled artisans and explore generations of traditional expertise. From pottery to textiles, find the perfect handcrafted pieces that tell stories.
      </p>
      <div class="flex items-center gap-4">
        <a href="{{ route('register') }}" class="btn-primary inline-block no-underline">Explore Artisans</a>
        <a href="#process" class="btn-outline inline-block text-center no-underline">Learn More</a>
      </div>
    </div>
    <!-- Images -->
    <div class="flex gap-4 fade-in" style="animation-delay:0.2s">
      <img src="{{ asset('images/Artisan Woman Weaving Traditional Moroccan Baskets.jpeg') }}" alt="Moroccan potter" class="hero-img w-52 h-64 object-cover" />
      <img src="{{ asset('images/Pottery Painting, Morocco.jpeg') }}" alt="Moroccan ceramics" class="hero-img w-52 h-64 object-cover mt-10" />
    </div>
  </div>
</section>

<!-- ───────────────── PLATFORM CAPABILITIES ───────────────── -->
<section class="py-20 px-6 bg-white" id="process">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">Platform Capabilities</h2>
      <p class="text-gray-500 text-sm">Everything you need to connect with authentic Moroccan artisans</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 fade-in">
      <!-- Card 1 -->
      <div class="cap-card">
        <div class="cap-icon">
          <svg class="w-5 h-5" style="color:var(--orange)" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Advanced Search</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Find artisans by specialty, location, and expertise. Filter by craft type, price range, and availability.</p>
      </div>
      <!-- Card 2 -->
      <div class="cap-card">
        <div class="cap-icon">
          <svg class="w-5 h-5" style="color:var(--orange)" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Verified Reviews</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Browse authentic customer feedback with verified ratings and detailed project histories.</p>
      </div>
      <!-- Card 3 -->
      <div class="cap-card">
        <div class="cap-icon">
          <svg class="w-5 h-5" style="color:var(--orange)" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
        </div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Portfolio Gallery</h3>
        <p class="text-sm text-gray-500 leading-relaxed">High-quality galleries showcasing artisan work with detailed descriptions and project stories.</p>
      </div>
      <!-- Card 4 -->
      <div class="cap-card">
        <div class="cap-icon">
          <svg class="w-5 h-5" style="color:var(--orange)" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
        </div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Secure Logistics</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Reliable shipping and handling of handcrafted items with insurance and tracking.</p>
      </div>
      <!-- Card 5 -->
      <div class="cap-card">
        <div class="cap-icon">
          <svg class="w-5 h-5" style="color:var(--orange)" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Direct Communication</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Message artisans directly via chat, phone, or WhatsApp to discuss custom projects.</p>
      </div>
      <!-- Card 6 -->
      <div class="cap-card">
        <div class="cap-icon">
          <svg class="w-5 h-5" style="color:var(--orange)" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Buyer Protection</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Secured transactions with money-back guarantees and dispute resolution support.</p>
      </div>
    </div>
  </div>
</section>

<!-- ───────────────── HOW IT WORKS ───────────────── -->
<section class="py-20 px-6" style="background:var(--cream2)">
  <div class="max-w-5xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">How It Works</h2>
      <p class="text-gray-500 text-sm">Simple steps to connect with Moroccan artisans</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center fade-in">
      <div>
        <div class="step-circle">1</div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Browse & Search</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Explore thousands of artisans and their handcrafted creations by category, location, and specialty.</p>
      </div>
      <div>
        <div class="step-circle">2</div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Connect</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Message artisans directly to discuss your project, ask questions, and negotiate custom orders.</p>
      </div>
      <div>
        <div class="step-circle">3</div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Order & Pay</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Secure payment options with protection. No funds released until you approve delivery.</p>
      </div>
      <div>
        <div class="step-circle">4</div>
        <h3 class="text-base font-bold mb-2" style="font-family:'DM Sans',sans-serif">Receive & Review</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Get your handcrafted item and share your experience to help other collectors.</p>
      </div>
    </div>
  </div>
</section>

<!-- ───────────────── STATS BAR ───────────────── -->
<section class="stats-bar py-12 px-6">
  <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
    <div>
      <div class="text-4xl font-bold mb-1" style="font-family:'Playfair Display',serif">2,500</div>
      <div class="text-sm opacity-80">Active Artisans</div>
    </div>
    <div>
      <div class="text-4xl font-bold mb-1" style="font-family:'Playfair Display',serif">25,000</div>
      <div class="text-sm opacity-80">Happy Customers</div>
    </div>
    <div>
      <div class="text-4xl font-bold mb-1" style="font-family:'Playfair Display',serif">50+</div>
      <div class="text-sm opacity-80">Craft Categories</div>
    </div>
    <div>
      <div class="text-4xl font-bold mb-1" style="font-family:'Playfair Display',serif">98%</div>
      <div class="text-sm opacity-80">Satisfaction Rate</div>
    </div>
  </div>
</section>

<!-- ───────────────── CUSTOMER STORIES ───────────────── -->
<section class="py-20 px-6 bg-white">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">Customer Stories</h2>
      <p class="text-gray-500 text-sm">Hear from collectors and customers who found their perfect artisan</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in">
      <!-- T1 -->
      <div class="testimonial-card">
        <div class="flex gap-1 mb-3">
          <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-4">"I discovered an incredible ceramic artist through m3alem. The entire process was seamless, and the artisan exceeded my expectations. Authentic Moroccan craftsmanship at its finest."</p>
        <div class="flex items-center gap-3">
          <div class="avatar" style="background:var(--orange)">AC</div>
          <div>
            <div class="font-semibold text-sm">Anna Chen</div>
            <div class="text-xs text-gray-400">California, USA</div>
          </div>
        </div>
      </div>
      <!-- T2 -->
      <div class="testimonial-card">
        <div class="flex gap-1 mb-3">
          <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-4">"As an artisan, m3alem connects me with customers worldwide. The platform is professional, secure, and helps me showcase my 15 years of weaving expertise to the right audience."</p>
        <div class="flex items-center gap-3">
          <div class="avatar" style="background:#6B8E5A">MC</div>
          <div>
            <div class="font-semibold text-sm">Mohammed Chaoui</div>
            <div class="text-xs text-gray-400">Marrakech, Morocco</div>
          </div>
        </div>
      </div>
      <!-- T3 -->
      <div class="testimonial-card">
        <div class="flex gap-1 mb-3">
          <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-4">"The quality of handcrafted items and the level of communication from artisans is outstanding. Each piece tells a story. I've become a regular customer of three different artisans."</p>
        <div class="flex items-center gap-3">
          <div class="avatar" style="background:#5A7B8E">LS</div>
          <div>
            <div class="font-semibold text-sm">Lisa Schmidt</div>
            <div class="text-xs text-gray-400">Berlin, Germany</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ───────────────── FEATURED ARTISANS ───────────────── -->
<section class="py-20 px-6" style="background:var(--cream)">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">Featured Artisans</h2>
      <p class="text-gray-500 text-sm">Meet master craftspeople carrying on traditional Moroccan heritage</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in">
      <!-- Artisan 1 -->
      <div class="artisan-card">
        <img src="{{ asset('images/Pottery Painting, Morocco.jpeg') }}" alt="Fatima Bennani" class="artisan-img" />
        <div class="p-5">
          <div class="flex items-start justify-between mb-1">
            <div>
              <h3 class="font-bold text-base" style="font-family:'DM Sans',sans-serif">Fatima Bennani</h3>
              <p class="text-xs" style="color:var(--orange)">Traditional Pottery</p>
            </div>
          </div>
          <div class="flex gap-1 my-2">
            <span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span>
            <span class="text-xs text-gray-400 ml-1">4.9 (241 reviews)</span>
          </div>
          <p class="text-sm text-gray-500 leading-relaxed">Master potter with 15 years of experience. Specializes in hand-thrown Moroccan ceramics using traditional techniques.</p>
        </div>
      </div>
      <!-- Artisan 2 -->
      <div class="artisan-card">
        <img src="{{ asset('images/Tapis Marocaine.jpeg') }}" alt="Hassan El Mansouri" class="artisan-img" />
        <div class="p-5">
          <h3 class="font-bold text-base mb-0.5" style="font-family:'DM Sans',sans-serif">Hassan El Mansouri</h3>
          <p class="text-xs mb-2" style="color:var(--orange)">Textile Weaving</p>
          <div class="flex gap-1 my-2">
            <span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span>
            <span class="text-xs text-gray-400 ml-1">4.8 (189 reviews)</span>
          </div>
          <p class="text-sm text-gray-500 leading-relaxed">Master weaver creating intricate Berber carpets on traditional looms. Each piece is a unique work of art.</p>
        </div>
      </div>
      <!-- Artisan 3 -->
      <div class="artisan-card">
        <img src="{{ asset('images/Broderie de Fez.jpeg') }}" alt="Leila Khatib" class="artisan-img" />
        <div class="p-5">
          <h3 class="font-bold text-base mb-0.5" style="font-family:'DM Sans',sans-serif">Leila Khatib</h3>
          <p class="text-xs mb-2" style="color:var(--orange)">Tile & Zellige Design</p>
          <div class="flex gap-1 my-2">
            <span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span><span class="star text-sm">★</span>
            <span class="text-xs text-gray-400 ml-1">4.7 (156 reviews)</span>
          </div>
          <p class="text-sm text-gray-500 leading-relaxed">Contemporary artisan blending traditional zellige tilework with modern design. Custom commissions welcome.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ───────────────── ARTISAN GALLERY ───────────────── -->
<section class="py-20 px-6 bg-white">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">Artisan Gallery</h2>
      <p class="text-gray-500 text-sm">Explore the beauty of traditional Moroccan craftsmanship</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 fade-in">
      <img src="{{ asset('images/artisanat au maroc - Page 7.jpeg') }}" alt="Gallery 1" class="gallery-img" />
      <img src="{{ asset('images/Разноцветье Марокко рядом.jpeg') }}" alt="Gallery 2" class="gallery-img" />
      <img src="{{ asset('images/Кожевенные красильни Марракеша.jpeg') }}" alt="Gallery 3" class="gallery-img" />
    </div>
  </div>
</section>

<!-- ───────────────── PRICING ───────────────── -->
<section class="py-20 px-6" style="background:var(--cream2)" id="pricing">
  <div class="max-w-5xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">Transparent Pricing</h2>
      <p class="text-gray-500 text-sm">No hidden fees. Simple, straightforward pricing for buyers and sellers.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start fade-in">
      <!-- Collector -->
      <div class="pricing-card">
        <div class="text-xs font-bold uppercase tracking-widest mb-3 px-3 py-1 rounded-full inline-block" style="background:#FEF0E6;color:var(--orange)">Collector</div>
        <div class="text-4xl font-bold mb-1" style="color:var(--orange);font-family:'Playfair Display',serif">Free</div>
        <p class="text-sm text-gray-500 mb-6">Browse, search, and connect with artisans at no cost.</p>
        <div class="check-item"><span class="check-icon">✓</span> Search & browse artisans</div>
        <div class="check-item"><span class="check-icon">✓</span> View portfolios</div>
        <div class="check-item"><span class="check-icon">✓</span> Send messages</div>
        <div class="check-item"><span class="check-icon">✓</span> Place orders</div>
        <div class="check-item"><span class="check-icon">✓</span> Buyer protection (2%)</div>
        <a href="{{ route('register') }}" class="btn-primary w-full mt-6 block text-center no-underline">Start Browsing</a>
      </div>
      <!-- Professional (featured) -->
      <div class="pricing-card featured">
        <div class="pricing-badge">POPULAR</div>
        <div class="text-xs font-bold uppercase tracking-widest mb-3 px-3 py-1 rounded-full inline-block" style="background:#FEF0E6;color:var(--orange)">Professional</div>
        <div class="text-4xl font-bold mb-1" style="color:var(--orange);font-family:'Playfair Display',serif">8%</div>
        <p class="text-sm text-gray-500 mb-6">Commission on successful sales. Everything you need to grow.</p>
        <div class="check-item"><span class="check-icon">✓</span> Professional profile</div>
        <div class="check-item"><span class="check-icon">✓</span> Portfolio showcase</div>
        <div class="check-item"><span class="check-icon">✓</span> Order management</div>
        <div class="check-item"><span class="check-icon">✓</span> Analytics dashboard</div>
        <a href="{{ route('register') }}" class="btn-primary w-full mt-6 block text-center no-underline">Register as Artisan</a>
      </div>
      <!-- Enterprise -->
      <div class="pricing-card">
        <div class="text-xs font-bold uppercase tracking-widest mb-3 px-3 py-1 rounded-full inline-block" style="background:#FEF0E6;color:var(--orange)">Enterprise</div>
        <div class="text-4xl font-bold mb-1" style="color:var(--orange);font-family:'Playfair Display',serif">Custom</div>
        <p class="text-sm text-gray-500 mb-6">White-label solutions for large businesses and cooperatives.</p>
        <div class="check-item"><span class="check-icon">✓</span> Unlimited artisan slots</div>
        <div class="check-item"><span class="check-icon">✓</span> Custom branding</div>
        <div class="check-item"><span class="check-icon">✓</span> API access</div>
        <div class="check-item"><span class="check-icon">✓</span> Dedicated support</div>
        <a href="mailto:contact@m3alem.test" class="btn-outline w-full mt-6 block text-center no-underline">Contact Us</a>
      </div>
    </div>
  </div>
</section>

<!-- ───────────────── FAQ ───────────────── -->
<section class="py-20 px-6 bg-white" id="faq">
  <div class="max-w-3xl mx-auto">
    <div class="text-center mb-14 fade-in">
      <h2 class="text-4xl mb-3">Frequently Asked Questions</h2>
      <p class="text-gray-500 text-sm">Find answers to the most common questions below</p>
    </div>
    <div class="fade-in">
      <div class="faq-item open">
        <button class="faq-question" onclick="toggleFaq(this)">
          How do I find an artisan for my specific project?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">Use our advanced search filters to browse by craft type, location, price range, and availability. You can also post a project brief and let artisans reach out to you directly.</div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)">
          Is my payment secure as a buyer?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">Yes. All payments are held in escrow until you confirm delivery and satisfaction. Our buyer protection policy covers disputes, refunds, and damage during shipping.</div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)">
          What if I'm not satisfied with my order?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">We offer a 14-day return policy for most items. If your piece arrives damaged or doesn't match the listing, our support team will arrange a full refund or replacement.</div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)">
          How do I register as an artisan?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">Click "Get Started" at the top of the page, select the artisan option, and complete your profile with photos, craft description, and portfolio. Verification takes 24–48 hours.</div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)">
          Can I customize items or request special orders?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">Absolutely. Most artisans on m3alem accept custom commissions. Simply message them with your requirements, dimensions, color preferences, and deadline to get a quote.</div>
      </div>
    </div>
  </div>
</section>

<!-- ───────────────── CTA DARK ───────────────── -->
<section class="cta-dark py-24 px-6 text-center">
  <div class="relative z-10">
    <h2 class="text-4xl md:text-5xl text-white mb-4">Join the Moroccan Artisan Revolution</h2>
    <p class="text-gray-300 text-sm mb-8 max-w-lg mx-auto leading-relaxed">Whether you're a collector seeking authentic handcrafted pieces or an artisan ready to share your work with the world, m3alem is your platform.</p>
    <a href="{{ route('register') }}" class="btn-primary text-base px-8 py-3 inline-block no-underline">Create Account Today</a>
  </div>
</section>

<!-- ───────────────── FOOTER ───────────────── -->
<footer class="py-16 px-6">
  <div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-10 mb-12">
      <!-- Brand -->
      <div class="col-span-2 md:col-span-1">
        <div class="text-orange-500 font-bold text-xl mb-3" style="font-family:'Playfair Display',serif">m3alem</div>
        <p class="text-xs text-gray-500 leading-relaxed">Connecting the world with the timeless artistry of Moroccan craftspeople.</p>
      </div>
      <!-- Platform -->
      <div>
        <h4 class="text-white text-sm font-semibold mb-4">Platform</h4>
        <ul class="space-y-2 text-xs text-gray-500">
          <li><a href="#features" class="hover:text-orange-400 transition-colors">Features</a></li>
          <li><a href="#pricing" class="hover:text-orange-400 transition-colors">Pricing</a></li>
          <li><a href="#process" class="hover:text-orange-400 transition-colors">Process</a></li>
          <li><a href="#faq" class="hover:text-orange-400 transition-colors">FAQ</a></li>
        </ul>
      </div>
      <!-- For Buyers -->
      <div>
        <h4 class="text-white text-sm font-semibold mb-4">For Buyers</h4>
        <ul class="space-y-2 text-xs text-gray-500">
          <li><a href="{{ route('register') }}" class="hover:text-orange-400 transition-colors">Browse Artisans</a></li>
          <li><a href="#process" class="hover:text-orange-400 transition-colors">How to Order</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Buyer Protection</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Custom Orders</a></li>
        </ul>
      </div>
      <!-- For Artisans -->
      <div>
        <h4 class="text-white text-sm font-semibold mb-4">For Artisans</h4>
        <ul class="space-y-2 text-xs text-gray-500">
          <li><a href="{{ route('register') }}" class="hover:text-orange-400 transition-colors">Register</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Seller Guide</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Payments</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Success Stories</a></li>
        </ul>
      </div>
      <!-- Company -->
      <div>
        <h4 class="text-white text-sm font-semibold mb-4">Company</h4>
        <ul class="space-y-2 text-xs text-gray-500">
          <li><a href="#" class="hover:text-orange-400 transition-colors">About Us</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Blog</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-orange-400 transition-colors">Terms of Service</a></li>
        </ul>
      </div>
    </div>
    <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-xs text-gray-600">© 2026 m3alem. All rights reserved.</p>
      <p class="text-xs text-gray-600">Celebrating Moroccan craftsmanship worldwide.</p>
    </div>
  </div>
</footer>

<script>
  // FAQ toggle
  function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }

  // Scroll fade-in
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

  // Smooth scroll for nav links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
</script>
</body>
</html>
