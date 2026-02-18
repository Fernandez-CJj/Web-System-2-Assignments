<!DOCTYPE html>
<html>

<head>
  <title>Event Registration</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #e0e0e0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      width: 400px;
      background: #ffffff;
      padding: 40px;
      border: 1px solid #e5e7eb;
    }

    h2 {
      margin: 0 0 30px 0;
      font-weight: 500;
      font-size: 22px;
      color: #111827;
    }

    .row {
      margin-bottom: 20px;
    }

    .label {
      font-size: 13px;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 5px;
    }

    .value {
      font-size: 18px;
      color: #111827;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2>Event Registration</h2>

    <div class="row">
      <div class="label">Event Name</div>
      <div class="value">{{ $event }}</div>
    </div>

    <div class="row">
      <div class="label">Participant Name</div>
      <div class="value">{{ $participant }}</div>
    </div>

    <div class="row">
      <div class="label">Year Level</div>
      <div class="value">{{ $year }}</div>
    </div>
  </div>

</body>

</html>