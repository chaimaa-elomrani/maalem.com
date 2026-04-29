@extends('layouts.main')

@section('title', 'Update Listing — m3alem')

@push('styles')
  <style>
    :root {
      --brand: #B85C2A;
      --brand-hover: #9A4B22;
      --brand-light: #FBF0E9;
      --surface: #FFFFFF;
      --bg: #FAFAFA;
      --border: #E4E4E7;
      --ink: #18181B;
      --ink-muted: #71717A;
      --focus-ring: rgba(184, 92, 42, 0.15);
    }

    body {
        background-color: var(--bg);
    }

    .creator-container {
      max-width: 780px;
      margin: 0 auto;
      padding: 60px 24px 100px;
    }

    .page-header {
      margin-bottom: 40px;
      text-align: center;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: var(--brand);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-decoration: none;
        margin-bottom: 16px;
        transition: opacity 0.2s;
    }

    .back-link:hover {
        opacity: 0.8;
    }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 700;
      color: var(--ink);
      line-height: 1.1;
      margin-bottom: 8px;
    }

    .page-subtitle {
      font-size: 15px;
      color: var(--ink-muted);
    }

    /* Form Container */
    .form-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    /* Input Fields */
    .form-group {
      margin-bottom: 28px;
    }
    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--ink);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 8px;
    }

    .form-hint {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 6px;
    }

    .form-input, .form-select, .form-textarea {
      width: 100%;
      padding: 14px 16px;
      border-radius: 8px;
      border: 1.5px solid var(--border);
      background: var(--surface);
      font-size: 14px;
      color: var(--ink);
      transition: all 0.2s ease;
      font-family: 'Inter', sans-serif;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--brand);
      box-shadow: 0 0 0 4px var(--focus-ring);
    }

    .form-input::placeholder, .form-textarea::placeholder {
      color: #A1A1AA;
    }

    /* File Upload Area */
    .upload-area {
        position: relative;
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        background: #FAFAFA;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: var(--brand);
        background: var(--brand-light);
    }

    .upload-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        width: 40px;
        height: 40px;
        color: var(--brand);
        margin: 0 auto 12px;
    }

    .upload-text {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .upload-subtext {
        font-size: 12px;
        color: var(--ink-muted);
    }

    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 16px;
    }

    .preview-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Submit Button */
    .submit-wrapper {
        margin-top: 40px;
    }

    .btn-submit {
      background: var(--brand);
      color: white;
      padding: 16px 32px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.2s ease;
      width: 100%;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-submit:hover {
      background: var(--brand-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(184, 92, 42, 0.2);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Error Alert */
    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }
    .alert-error ul {
        margin: 0;
        padding-left: 20px;
        color: #DC2626;
        font-size: 13px;
        font-weight: 500;
    }

  </style>
@endpush

@section('content')

<div class="creator-container">
    <div class="page-header">
        <a href="{{ route('artisan.dashboard') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Dashboard
        </a>
        <h1 class="page-title">Update Your Listing</h1>
        <p class="page-subtitle">Refine the details of your masterpiece.</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label class="form-label">Title of the Piece *</label>
            <input type="text" name="title" class="form-input" placeholder="e.g., Hand-Woven Atlas Wool Rug" required value="{{ old('title', $post->title) }}">
        </div>

        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label class="form-label">Category *</label>
                <div style="position: relative;">
                    <select name="category" class="form-select" required style="appearance: none;">
                        <option value="Pottery" {{ old('category', $post->category) == 'Pottery' ? 'selected' : '' }}>Pottery & Ceramics</option>
                        <option value="Weaving" {{ old('category', $post->category) == 'Weaving' ? 'selected' : '' }}>Textiles & Weaving</option>
                        <option value="Leatherwork" {{ old('category', $post->category) == 'Leatherwork' ? 'selected' : '' }}>Leather Crafting</option>
                        <option value="Woodwork" {{ old('category', $post->category) == 'Woodwork' ? 'selected' : '' }}>Woodworks</option>
                        <option value="Metalwork" {{ old('category', $post->category) == 'Metalwork' ? 'selected' : '' }}>Metal & Jewelry</option>
                        <option value="Zellige" {{ old('category', $post->category) == 'Zellige' ? 'selected' : '' }}>Zellige & Tilework</option>
                    </select>
                    <svg style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--ink-muted);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>
            
            <div>
                <label class="form-label">Keywords / Tags</label>
                @php
                    $tags = is_array($post->tags) ? implode(', ', $post->tags) : $post->tags;
                @endphp
                <input type="text" name="tags" class="form-input" placeholder="e.g. vintage, customized, blue" value="{{ old('tags', $tags) }}">
                <div class="form-hint">Separate with commas</div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">The Story behind the Piece *</label>
            <textarea name="description" rows="5" class="form-textarea" placeholder="Describe your process..." required>{{ old('description', $post->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Current Images</label>
            <div class="preview-container">
                @foreach($post->images as $img)
                    @if(str_contains($img, 'unsplash'))
                         <img src="{{ asset('images/image 26.png') }}" class="preview-img">
                    @else
                         <img src="{{ str_starts_with($img,'http') ? $img : asset('storage/'.$img) }}" class="preview-img">
                    @endif
                @endforeach
            </div>
            <p class="form-hint">Existing images will be kept unless you upload new ones.</p>
        </div>

        <div class="form-group">
            <label class="form-label">Upload New Images (Optional)</label>
            <div class="upload-area">
                <input type="file" id="images-input" name="images[]" multiple class="upload-input" accept="image/*" onchange="previewImages(event)">
                <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                <div class="upload-text">Click to upload or drag and drop</div>
                <div class="upload-subtext">This will replace current images</div>
            </div>
            <div id="image-preview" class="preview-container" style="display: none;"></div>
            <div id="image-count" class="form-hint" style="display: none; margin-top: 8px; font-weight: 500;"></div>
        </div>

        <div class="submit-wrapper">
            <button type="submit" class="btn-submit">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                Save Changes
            </button>
        </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
  function previewImages(event) {
    const preview = document.getElementById('image-preview');
    const countEl = document.getElementById('image-count');
    const files = event.target.files;

    preview.innerHTML = '';
    preview.style.display = 'flex';
    countEl.style.display = 'block';

    if (files.length === 0) {
      preview.style.display = 'none';
      countEl.style.display = 'none';
      return;
    }

    countEl.textContent = files.length + (files.length === 1 ? ' new file selected' : ' new files selected');

    Array.from(files).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'preview-img';
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  }
</script>
@endpush
