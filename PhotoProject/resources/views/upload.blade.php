<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel Image Upload</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      min-height: 100vh;
      color: #e2e8f0;
    }

    /* ── Header ── */
    header {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 1.25rem 2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .header-icon {
      width: 42px;
      height: 42px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }

    header h1 {
      font-size: 1.25rem;
      font-weight: 700;
      background: linear-gradient(135deg, #a78bfa, #818cf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    header p {
      font-size: 0.8rem;
      color: #94a3b8;
    }

    /* ── Main layout ── */
    main {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2.5rem 1.5rem;
    }

    .section-title {
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: #a78bfa;
      margin-bottom: 1.25rem;
    }

    /* ── Upload Grid ── */
    .upload-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2.5rem;
    }

    /* ── Card ── */
    .card {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.09);
      border-radius: 18px;
      padding: 2rem;
      transition: transform .2s, box-shadow .2s;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
    }

    .card-header {
      display: flex;
      align-items: center;
      gap: .85rem;
      margin-bottom: 1.5rem;
    }

    .card-icon {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      flex-shrink: 0;
    }

    .card-icon.single {
      background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .card-icon.multiple {
      background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .card-title {
      font-size: 1.05rem;
      font-weight: 600;
      color: #f1f5f9;
    }

    .card-subtitle {
      font-size: 0.75rem;
      color: #94a3b8;
      margin-top: 2px;
    }

    /* ── Drop zone ── */
    .drop-zone {
      border: 2px dashed rgba(255, 255, 255, 0.15);
      border-radius: 12px;
      padding: 2rem 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      margin-bottom: 1.25rem;
      position: relative;
    }

    .drop-zone:hover,
    .drop-zone.drag-over {
      border-color: #818cf8;
      background: rgba(129, 140, 248, 0.06);
    }

    .drop-zone input[type="file"] {
      position: absolute;
      inset: 0;
      opacity: 0;
      cursor: pointer;
      width: 100%;
      height: 100%;
    }

    .drop-icon {
      font-size: 2.2rem;
      margin-bottom: .5rem;
    }

    .drop-label {
      font-size: .875rem;
      font-weight: 500;
      color: #cbd5e1;
    }

    .drop-hint {
      font-size: .72rem;
      color: #64748b;
      margin-top: .3rem;
    }

    .file-preview {
      font-size: .8rem;
      color: #a78bfa;
      margin-top: .6rem;
      font-weight: 500;
    }

    /* ── Button ── */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
      width: 100%;
      padding: .7rem 1.25rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: .9rem;
      font-weight: 600;
      font-family: inherit;
      transition: opacity .2s, transform .15s;
    }

    .btn:hover {
      opacity: .88;
      transform: translateY(-1px);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff;
    }

    .btn-accent {
      background: linear-gradient(135deg, #f093fb, #f5576c);
      color: #fff;
    }

    .btn-danger {
      background: rgba(239, 68, 68, 0.15);
      color: #fca5a5;
      border: 1px solid rgba(239, 68, 68, 0.25);
      padding: .35rem .7rem;
      width: auto;
      font-size: .75rem;
      border-radius: 8px;
    }

    .btn-danger:hover {
      background: rgba(239, 68, 68, 0.3);
    }

    /* ── Alerts ── */
    .alert {
      padding: .85rem 1.25rem;
      border-radius: 10px;
      font-size: .85rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: .6rem;
      margin-bottom: 1.75rem;
      border: 1px solid;
    }

    .alert-success {
      background: rgba(52, 211, 153, 0.12);
      border-color: rgba(52, 211, 153, 0.3);
      color: #6ee7b7;
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.1);
      border-color: rgba(239, 68, 68, 0.25);
      color: #fca5a5;
    }

    .alert ul {
      margin: .4rem 0 0 1.2rem;
    }

    .alert ul li {
      margin-top: .2rem;
      font-size: .8rem;
    }

    /* ── Gallery section ── */
    .gallery-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .badge {
      background: rgba(129, 140, 248, 0.2);
      color: #a5b4fc;
      font-size: .72rem;
      font-weight: 600;
      padding: .3rem .75rem;
      border-radius: 999px;
      border: 1px solid rgba(129, 140, 248, 0.25);
    }

    /* ── Photo grid ── */
    .photo-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .photo-item {
      position: relative;
      border-radius: 14px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      aspect-ratio: 1;
      transition: transform .2s, box-shadow .2s;
      group: true;
    }

    .photo-item:hover {
      transform: scale(1.03);
      box-shadow: 0 12px 32px rgba(0, 0, 0, .5);
    }

    .photo-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform .3s;
    }

    .photo-item:hover img {
      transform: scale(1.06);
    }

    .photo-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, .7) 0%, transparent 55%);
      opacity: 0;
      transition: opacity .2s;
      display: flex;
      align-items: flex-end;
      justify-content: flex-end;
      padding: .75rem;
    }

    .photo-item:hover .photo-overlay {
      opacity: 1;
    }

    /* ── Empty state ── */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: #475569;
    }

    .empty-state .empty-icon {
      font-size: 3.5rem;
      margin-bottom: 1rem;
    }

    .empty-state p {
      font-size: .95rem;
    }

    /* ── Pagination ── */
    .pagination-wrapper {
      display: flex;
      justify-content: center;
    }

    .pagination-wrapper nav {
      display: flex;
      gap: .4rem;
      align-items: center;
      flex-wrap: wrap;
    }

    .pagination-wrapper span,
    .pagination-wrapper a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      height: 36px;
      padding: 0 .6rem;
      border-radius: 8px;
      font-size: .8rem;
      font-weight: 500;
      text-decoration: none;
      transition: background .2s, color .2s;
    }

    .pagination-wrapper a {
      color: #94a3b8;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pagination-wrapper a:hover {
      background: rgba(129, 140, 248, 0.2);
      color: #a5b4fc;
      border-color: rgba(129, 140, 248, 0.3);
    }

    .pagination-wrapper span[aria-current="page"] span,
    .pagination-wrapper .page-item.active .page-link {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff;
      border: none;
    }

    /* Override Laravel default pagination */
    nav[role="navigation"] {
      display: flex;
      justify-content: center;
    }

    nav[role="navigation"]>div:first-child {
      display: none;
    }

    nav[role="navigation"] span[aria-disabled="true"] span {
      background: rgba(255, 255, 255, 0.04);
      color: #475569;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      height: 36px;
      border-radius: 8px;
      font-size: .8rem;
      border: 1px solid rgba(255, 255, 255, 0.06);
    }

    nav[role="navigation"] span[aria-current="page"] span {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      height: 36px;
      border-radius: 8px;
      font-size: .8rem;
      font-weight: 600;
      border: none;
    }

    nav[role="navigation"] a {
      color: #94a3b8;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      height: 36px;
      border-radius: 8px;
      font-size: .8rem;
      text-decoration: none;
      transition: background .2s, color .2s;
    }

    nav[role="navigation"] a:hover {
      background: rgba(129, 140, 248, 0.2);
      color: #a5b4fc;
      border-color: rgba(129, 140, 248, 0.3);
    }

    nav[role="navigation"]>div:last-child {
      display: flex;
      gap: .4rem;
      flex-wrap: wrap;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
      main {
        padding: 1.5rem 1rem;
      }

      .photo-grid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      }
    }
  </style>
</head>

<body>

  <header>
    <div class="header-icon">📸</div>
    <div>
      <h1>Laravel Image Upload</h1>
      <p>Single &amp; Multiple Image Management</p>
    </div>
  </header>

  <main>

    {{-- ── Alerts ── --}}
    @if(session('success_single'))
    <div class="alert alert-success">
      <span>✅</span> {{ session('success_single') }}
    </div>
    @endif
    @if(session('success_multiple'))
    <div class="alert alert-success">
      <span>✅</span> {{ session('success_multiple') }}
    </div>
    @endif
    @if(session('success_delete'))
    <div class="alert alert-success">
      <span>🗑️</span> {{ session('success_delete') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
      <div>
        <strong>⚠️ Please fix the following errors:</strong>
        <ul>
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif

    {{-- ── Upload Forms ── --}}
    <p class="section-title">Upload Images</p>
    <div class="upload-grid">

      {{-- Single Upload --}}
      <div class="card">
        <div class="card-header">
          <div class="card-icon single">🖼️</div>
          <div>
            <div class="card-title">Single Image Upload</div>
            <div class="card-subtitle">Upload one image at a time</div>
          </div>
        </div>
        <form action="{{ route('photos.store.single') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="drop-zone" id="singleDrop">
            <input type="file" name="image" accept="image/*" required id="singleInput">
            <div class="drop-icon">📁</div>
            <div class="drop-label">Click or drag &amp; drop an image</div>
            <div class="drop-hint">JPG, PNG, GIF, WEBP — max 2 MB</div>
            <div class="file-preview" id="singlePreview"></div>
          </div>
          <button type="submit" class="btn btn-primary">⬆️ Upload Image</button>
        </form>
      </div>

      {{-- Multiple Upload --}}
      <div class="card">
        <div class="card-header">
          <div class="card-icon multiple">🗂️</div>
          <div>
            <div class="card-title">Multiple Images Upload</div>
            <div class="card-subtitle">Upload several images at once</div>
          </div>
        </div>
        <form action="{{ route('photos.store.multiple') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="drop-zone" id="multipleDrop">
            <input type="file" name="images[]" accept="image/*" multiple required id="multipleInput">
            <div class="drop-icon">📂</div>
            <div class="drop-label">Click or drag &amp; drop images</div>
            <div class="drop-hint">Select multiple files — JPG, PNG, GIF, WEBP — max 2 MB each</div>
            <div class="file-preview" id="multiplePreview"></div>
          </div>
          <button type="submit" class="btn btn-accent">⬆️ Upload Images</button>
        </form>
      </div>

    </div>

    {{-- ── Gallery ── --}}
    <div class="gallery-header">
      <p class="section-title" style="margin-bottom:0;">Photo Gallery</p>
      <span class="badge">{{ $photos->total() }} {{ Str::plural('photo', $photos->total()) }}</span>
    </div>

    @if($photos->count())
    <div class="photo-grid">
      @foreach($photos as $photo)
      <div class="photo-item">
        <img src="{{ asset('images/' . $photo->image) }}"
          alt="{{ $photo->image }}"
          loading="lazy">
        <div class="photo-overlay">
          <form action="{{ route('photos.destroy', $photo) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
              onclick="return confirm('Delete this photo?')">🗑️ Delete</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
      {{ $photos->links() }}
    </div>
    @else
    <div class="empty-state">
      <div class="empty-icon">🖼️</div>
      <p>No photos uploaded yet. Start by uploading an image above!</p>
    </div>
    @endif

  </main>

  <script>
    // File name preview for Single upload
    document.getElementById('singleInput').addEventListener('change', function() {
      const preview = document.getElementById('singlePreview');
      preview.textContent = this.files.length ? '✔ ' + this.files[0].name : '';
    });

    // File count preview for Multiple upload
    document.getElementById('multipleInput').addEventListener('change', function() {
      const preview = document.getElementById('multiplePreview');
      if (this.files.length === 1) {
        preview.textContent = '✔ ' + this.files[0].name;
      } else if (this.files.length > 1) {
        preview.textContent = '✔ ' + this.files.length + ' files selected';
      } else {
        preview.textContent = '';
      }
    });

    // Drag-over highlight for both drop zones
    ['singleDrop', 'multipleDrop'].forEach(function(id) {
      const zone = document.getElementById(id);
      zone.addEventListener('dragover', function(e) {
        e.preventDefault();
        zone.classList.add('drag-over');
      });
      zone.addEventListener('dragleave', function() {
        zone.classList.remove('drag-over');
      });
      zone.addEventListener('drop', function() {
        zone.classList.remove('drag-over');
      });
    });
  </script>

</body>

</html>