<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>m3alem — Complete Your Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --brand:      #C4622D;
      --brand-dark: #A34E22;
      --brand-pale: #F7EDE6;
      --ink:        #111827;
      --ink-2:      #374151;
      --muted:      #6B7280;
      --border:     #E5E7EB;
      --bg:         #F9FAFB;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--ink); min-height: 100vh; }

    .form-field {
      width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px;
      font-family: 'Inter', sans-serif; font-size: 14px; color: var(--ink);
      outline: none; transition: border-color .15s, box-shadow .15s; background: #fff;
    }
    .form-field:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(196,98,45,.1); }
    .form-field.error { border-color: #EF4444; }

    label { font-size: 13px; font-weight: 500; color: var(--ink-2); display: block; margin-bottom: 5px; }
    .hint  { font-size: 11px; color: var(--muted); margin-top: 4px; }

    .btn-primary {
      background: var(--brand); color: #fff; font-size: 14px; font-weight: 600;
      padding: 11px 24px; border-radius: 8px; border: none; cursor: pointer;
      transition: background .15s, transform .1s; width: 100%;
    }
    .btn-primary:hover  { background: var(--brand-dark); }
    .btn-primary:active { transform: scale(.98); }

    .day-pill {
      display: inline-flex; align-items: center; gap: 5px; cursor: pointer;
      padding: 6px 14px; border-radius: 999px; border: 1.5px solid var(--border);
      font-size: 12px; font-weight: 500; color: var(--muted); transition: all .15s;
      user-select: none;
    }
    .day-pill input { display: none; }
    .day-pill:has(input:checked) {
      background: var(--brand-pale); border-color: var(--brand); color: var(--brand);
    }

    .skill-tag {
      display: inline-flex; align-items: center; gap: 5px;
      background: var(--brand-pale); color: var(--brand-dark);
      font-size: 12px; font-weight: 500; padding: 4px 10px; border-radius: 6px;
    }
    .skill-tag button { background: none; border: none; cursor: pointer; color: inherit; line-height: 1; font-size: 14px; }

    .step-dot {
      width: 8px; height: 8px; border-radius: 50%;
    }
  </style>
</head>
<body>

<header style="background:#fff;border-bottom:1px solid var(--border);">
  <div style="max-width:680px;margin:0 auto;padding:0 20px;height:54px;display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:16px;font-weight:700;color:var(--brand);">m3alem</span>
    <span style="font-size:12px;color:var(--muted);">Logged in as {{ $user->name }}</span>
  </div>
</header>

<div style="max-width:620px;margin:40px auto;padding:0 20px 60px;">

  <!-- Progress -->
  <div style="display:flex;align-items:center;gap:8px;margin-bottom:28px;">
    <div style="display:flex;align-items:center;gap:6px;">
      <div class="step-dot" style="background:var(--brand);"></div>
      <span style="font-size:12px;font-weight:500;color:var(--brand);">Account</span>
    </div>
    <div style="flex:1;height:2px;background:var(--brand);border-radius:1px;"></div>
    <div style="display:flex;align-items:center;gap:6px;">
      <div class="step-dot" style="background:var(--brand);"></div>
      <span style="font-size:12px;font-weight:600;color:var(--brand);">Professional Details</span>
    </div>
    <div style="flex:1;height:2px;background:var(--border);border-radius:1px;"></div>
    <div style="display:flex;align-items:center;gap:6px;">
      <div class="step-dot" style="background:var(--border);"></div>
      <span style="font-size:12px;color:var(--muted);">Dashboard</span>
    </div>
  </div>

  <!-- Header -->
  <div style="margin-bottom:28px;">
    <h1 style="font-size:22px;font-weight:700;margin-bottom:6px;">Complete your artisan profile</h1>
    <p style="font-size:14px;color:var(--muted);">This info will appear on your public profile and help clients find you.</p>
  </div>

  @if($errors->any())
  <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:8px;padding:12px 16px;margin-bottom:20px;">
    <ul style="list-style:none;font-size:13px;color:#DC2626;display:flex;flex-direction:column;gap:4px;">
      @foreach($errors->all() as $error)
        <li>· {{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form method="POST" action="{{ route('artisan.setup.store') }}" style="display:flex;flex-direction:column;gap:20px;">
    @csrf

    <!-- Service Title -->
    <div>
      <label for="service">Your Service Title *</label>
      <input id="service" name="service" type="text" class="form-field {{ $errors->has('service') ? 'error' : '' }}"
        placeholder="e.g. Ceramic Master, Master Weaver, Leather Artist"
        value="{{ old('service') }}" required />
      <p class="hint">This is your main headline visible on your profile.</p>
    </div>

    <!-- Working Area -->
    <div>
      <label for="workingArea">Craft / Working Area *</label>
      <input id="workingArea" name="workingArea" type="text" class="form-field {{ $errors->has('workingArea') ? 'error' : '' }}"
        placeholder="e.g. Pottery, Zellige Tiles, Leather Craft, Weaving"
        value="{{ old('workingArea') }}" required />
    </div>

    <!-- Experience / Bio -->
    <div>
      <label for="experience">About You & Your Experience *</label>
      <textarea id="experience" name="experience" rows="4" class="form-field {{ $errors->has('experience') ? 'error' : '' }}"
        placeholder="Tell clients about yourself, your background, and what makes your craft unique…"
        required>{{ old('experience') }}</textarea>
      <p class="hint">Aim for 2–4 sentences; this appears directly on your public profile.</p>
    </div>

    <!-- Workshop Address -->
    <div>
      <label for="workshopAdresse">Workshop / Studio Location *</label>
      <input id="workshopAdresse" name="workshopAdresse" type="text" class="form-field {{ $errors->has('workshopAdresse') ? 'error' : '' }}"
        placeholder="e.g. Fès el-Bali Medina, Marrakech Medina"
        value="{{ old('workshopAdresse') }}" required />
    </div>

    <!-- Availability -->
    <div>
      <label>Availability</label>
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:4px;">
        @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $day)
        <label class="day-pill">
          <input type="checkbox" name="disponibility[]" value="{{ $day }}"
            {{ in_array($day, old('disponibility', [])) ? 'checked' : '' }}/>
          {{ $day }}
        </label>
        @endforeach
      </div>
      <p class="hint">Select the days you are typically available for consultations.</p>
    </div>

    <!-- Skills / Certifications -->
    <div>
      <label for="certifications-input">Skills & Specialisations</label>
      <div id="tags-container" style="display:flex;flex-wrap:wrap;gap:6px;min-height:38px;padding:8px;border:1px solid var(--border);border-radius:8px;background:#fff;cursor:text;" onclick="document.getElementById('certifications-input').focus()">
        <div id="tag-list" style="display:flex;flex-wrap:wrap;gap:6px;"></div>
        <input id="certifications-input" type="text" placeholder="Type a skill and press Enter…"
          style="border:none;outline:none;font-size:13px;color:var(--ink);flex:1;min-width:120px;font-family:'Inter',sans-serif;" />
      </div>
      <input type="hidden" name="certifications" id="certifications-hidden" value="{{ old('certifications') }}" />
      <p class="hint">e.g. Traditional Pottery, Zellige, Hand-painting, Custom Commission</p>
    </div>

    <button type="submit" class="btn-primary" style="margin-top:8px;">
      Save Profile & Go to Dashboard →
    </button>

  </form>
</div>

<script>
  const input   = document.getElementById('certifications-input');
  const tagList = document.getElementById('tag-list');
  const hidden  = document.getElementById('certifications-hidden');

  let tags = hidden.value ? hidden.value.split(',').map(t => t.trim()).filter(Boolean) : [];

  function renderTags() {
    tagList.innerHTML = '';
    tags.forEach((tag, i) => {
      const el = document.createElement('span');
      el.className = 'skill-tag';
      el.innerHTML = `${tag} <button type="button" onclick="removeTag(${i})">×</button>`;
      tagList.appendChild(el);
    });
    hidden.value = tags.join(', ');
  }

  function removeTag(i) {
    tags.splice(i, 1);
    renderTags();
  }

  input.addEventListener('keydown', e => {
    if ((e.key === 'Enter' || e.key === ',') && input.value.trim()) {
      e.preventDefault();
      tags.push(input.value.trim().replace(/,$/, ''));
      input.value = '';
      renderTags();
    }
    if (e.key === 'Backspace' && !input.value && tags.length) {
      tags.pop();
      renderTags();
    }
  });

  renderTags();
</script>
</body>
</html>
