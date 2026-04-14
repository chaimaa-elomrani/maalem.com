<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Listing — m3alem</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --terracotta: #C4622D;
      --terracotta-dark: #A04E22;
      --sand: #F5ECD7;
      --sand-dark: #E8D9BE;
      --ink: #1C1612;
      --ink-muted: #6B5B4E;
      --cream: #FAF6EF;
    }
    body { font-family: 'Inter', sans-serif; background: var(--cream); color: var(--ink); }
    .display-font { font-family: 'Playfair Display', serif; }
    
    .form-input {
      width: 100%;
      padding: 12px 16px;
      border-radius: 12px;
      border: 1px solid var(--sand-dark);
      background: white;
      font-size: 14px;
      transition: all 0.2s ease;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--terracotta);
      box-shadow: 0 0 0 3px rgba(196,98,45,0.1);
    }
    .label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--ink-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 8px;
    }
    .btn-submit {
      background: var(--terracotta);
      color: white;
      padding: 14px 28px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.2s ease;
      width: 100%;
    }
    .btn-submit:hover {
      background: var(--terracotta-dark);
      transform: translateY(-1px);
    }
  </style>
</head>
<body class="min-h-screen py-12 px-4">

  <div class="max-w-2xl mx-auto">
    
    <header class="mb-10 flex items-center justify-between">
      <div>
        <a href="{{ route('artisan.dashboard') }}" class="text-xs font-semibold uppercase tracking-widest text-terracotta hover:opacity-80 transition-opacity">
          ← Back to Dashboard
        </a>
        <h1 class="display-font text-3xl font-bold mt-2">Create a New Listing</h1>
        <p class="text-ink-muted text-sm mt-1">Share your latest craft with the community.</p>
      </div>
    </header>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div class="bg-white p-8 rounded-2xl shadow-sm border border-sand-dark space-y-6">
        
        <div>
          <label class="label">Craft Title</label>
          <input type="text" name="title" class="form-input" placeholder="e.g. Traditional Hand-Woven Berber Rug" required value="{{ old('title') }}">
        </div>

        <div>
          <label class="label">Category</label>
          <select name="category" class="form-input" required>
            <option value="" disabled selected>Select a category</option>
            <option value="Pottery">Pottery & Ceramics</option>
            <option value="Weaving">Textiles & Weaving</option>
            <option value="Leatherwork">Leatherwork</option>
            <option value="Woodwork">Woodwork</option>
            <option value="Metalwork">Metalwork & Jewelry</option>
            <option value="Zellige">Zellige & Tilework</option>
          </select>
        </div>

        <div>
          <label class="label">Product Story / Description</label>
          <textarea name="description" rows="5" class="form-input" placeholder="Tell the story of this piece, the materials used, and the technique..." required>{{ old('description') }}</textarea>
        </div>

        <div>
          <label class="label">Upload Images (Max 5MB per file)</label>
          <div class="relative group">
            <input type="file" name="images[]" multiple class="form-input py-10 text-center border-dashed border-2 cursor-pointer" accept="image/*" required>
            <div class="absolute inset-x-0 bottom-4 text-center pointer-events-none text-xs text-ink-muted">
              Select multiple photos of your work
            </div>
          </div>
        </div>

        <div>
          <label class="label">Tags (Keywords)</label>
          <input type="text" name="tags" class="form-input" placeholder="e.g. wool, handmade, traditional, atlas-mountains" value="{{ old('tags') }}">
          <p class="text-[10px] text-ink-muted mt-2 pl-1 italic">Separate tags with commas</p>
        </div>

      </div>

      <button type="submit" class="btn-submit shadow-lg">
        Publish Craft Listing
      </button>

    </form>

  </div>

</body>
</html>
