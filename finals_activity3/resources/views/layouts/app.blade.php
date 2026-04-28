<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student QR Code System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    :root {
      --page-bg: #f4f7fb;
      --ink: #172033;
      --muted: #667085;
      --brand: #176b87;
      --brand-dark: #0f4c5c;
      --line: #d9e2ec;
      --soft: #eef5f8;
    }

    body {
      background: var(--page-bg);
      color: var(--ink);
      font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .app-shell {
      max-width: 1180px;
    }

    .topbar {
      background: #fff;
      border-bottom: 1px solid var(--line);
    }

    .brand-mark {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      display: inline-grid;
      place-items: center;
      background: var(--brand);
      color: #fff;
      font-weight: 800;
    }

    .page-title {
      font-weight: 800;
      letter-spacing: 0;
    }

    .panel,
    .student-card,
    .form-panel {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 8px;
      box-shadow: 0 12px 30px rgba(23, 32, 51, .06);
    }

    .student-photo,
    .profile-photo,
    .photo-preview {
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: var(--soft);
    }

    .student-photo {
      width: 58px;
      height: 58px;
    }

    .profile-photo {
      width: 180px;
      height: 180px;
    }

    .photo-preview {
      width: 120px;
      height: 120px;
    }

    .photo-placeholder {
      display: inline-grid;
      place-items: center;
      color: var(--brand-dark);
      font-weight: 800;
    }

    .field-label {
      color: var(--muted);
      font-size: .78rem;
      font-weight: 700;
      text-transform: uppercase;
    }

    .field-value {
      font-weight: 700;
      word-break: break-word;
    }

    .btn-primary {
      background: var(--brand);
      border-color: var(--brand);
    }

    .btn-primary:hover,
    .btn-primary:focus {
      background: var(--brand-dark);
      border-color: var(--brand-dark);
    }

    .qr-box svg {
      width: 100%;
      max-width: 220px;
      height: auto;
    }

    .table > :not(caption) > * > * {
      vertical-align: middle;
    }

    .empty-state {
      border: 1px dashed var(--line);
      border-radius: 8px;
      background: #fff;
      padding: 42px 24px;
      text-align: center;
    }
  </style>
</head>

<body>
  <nav class="topbar py-3 mb-4">
    <div class="container app-shell d-flex align-items-center justify-content-between gap-3">
      <a class="d-flex align-items-center gap-3 text-decoration-none text-dark" href="{{ route('students.index') }}">
        <span class="brand-mark">SQ</span>
        <span>
          <span class="d-block fw-bold">Student QR System</span>
          <span class="small text-secondary">Directory, pictures, and QR profiles</span>
        </span>
      </a>
      <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Add Student</a>
    </div>
  </nav>

  <main class="container app-shell pb-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
