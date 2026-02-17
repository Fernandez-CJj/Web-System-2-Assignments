<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Evaluation System</title>
  <link rel="stylesheet" href="{{ asset('css/evaluation.css') }}">
</head>

<body>

  <h2>Student Evaluation System</h2>

  <div class="container">

    <!-- Form Card -->
    <form method="POST" action="/evaluation" class="card">
      @csrf
      <label>Student Name:</label>
      <input type="text" name="name" placeholder="Enter full name" required>

      <label>Prelim Grade:</label>
      <input type="number" name="prelim" min="0" max="100" placeholder="0-100" required>

      <label>Midterm Grade:</label>
      <input type="number" name="midterm" min="0" max="100" placeholder="0-100" required>

      <label>Final Grade:</label>
      <input type="number" name="final" min="0" max="100" placeholder="0-100" required>

      <button type="submit">Evaluate</button>
    </form>

    @if($submitted)
    @php
    $average = ($prelim + $midterm + $final) / 3;

    if($average >= 90){ $letter = 'A'; }
    elseif($average >= 80){ $letter = 'B'; }
    elseif($average >= 70){ $letter = 'C'; }
    elseif($average >= 60){ $letter = 'D'; }
    else { $letter = 'F'; }

    $remarks = ($average >= 75) ? 'Passed' : 'Failed';

    if($average >= 98){ $award = 'With Highest Honors'; $awardClass='highest'; }
    elseif($average >= 95){ $award = 'With High Honors'; $awardClass='high'; }
    elseif($average >= 90){ $award = 'With Honors'; $awardClass='honors'; }
    else { $award = 'No Award'; $awardClass='no-award'; }
    @endphp

    <div class="results">
      <h3>Results</h3>
      <p><span>Name:</span> <span>{{ $name }}</span></p>
      <p><span>Average:</span> <span>{{ number_format($average,2) }}</span></p>
      <p><span>Letter Grade:</span> <span class="grade {{ $letter }}">{{ $letter }}</span></p>
      <p><span>Remarks:</span> <span>{{ $remarks }}</span></p>
      <p><span>Award:</span> <span class="award {{ $awardClass }}">{{ $award }}</span></p>
    </div>
    @endif

  </div>

</body>

</html>