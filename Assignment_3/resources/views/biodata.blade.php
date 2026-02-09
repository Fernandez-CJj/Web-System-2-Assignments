<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume</title>
  <link rel="stylesheet" href="{{ asset('css/biodata.css') }}">
</head>

<body>
  <div class="resume-border">
    <!-- this is for header -->
    <div class="resume-holder">
      <div class="header-container">
        <div class="left-info">
          <img src="{{ asset('images/picture.jpeg') }}" alt="Profile Picture">
        </div>
        <div class="right-info">
          <div class="right-top-content">
            <div class="name">{{ $name }}</div>
            <div class="job">{{ $job }}</div>
          </div>
          <div class="right-bottom-content">
            <div class="phone"><strong>Phone:</strong> {{ $phone }}</div>
            <div class="address"><strong>Address:</strong> {{ $address }}</div>
            <div class="email"><strong>Email:</strong> {{ $email }}</div>
            <div class="dob">
              <strong>Birthday:</strong> {{ $bday }} | <strong></strong>{{ $ageTag }}
            </div>
            <div class="linkedin"><strong>Linkedin:</strong> {{ $linkedin }}</div>
            <div class="gender"><strong>Gender:</strong> {{ $gender }}</div>
            <div class="gitlab"><strong>GitLab:</strong> {{ $gitlab }}</div>
            <div class="nationality"><strong>Nationality:</strong> {{ $nationality }}</div>
          </div>
        </div>
      </div>

      <!-- this is for main content -->
      <div class="main-body">
        <div class="section-1">{{ $description }}</div>
        <div class="section-2">
          <div class="section-2-border">
            <h2>Education</h2>
          </div>
          <div class="education-item">
            <div class="year-container">
              <div class="year">{{ $year1 }}</div>
            </div>
            <div class="highschool-info-container">
              <div class="diploma">{{ $diploma }}</div>
              <div class="shs-name">{{ $shs }}</div>
              <div class="activities-container">Activities:
                <li>{{ $list1 }}</li>
                <li>{{ $list2 }}</li>
                <li>{{ $list3 }}</li>
              </div>
            </div>
          </div>
          <div class="education-item-2">
            <div class="year-container">
              <div class="year">{{ $year2 }}</div>
            </div>
            <div class="college-info-container">
              <div class="diploma">{{ $collegeDiploma }}</div>
              <div class="shs-name">{{ $college }}</div>
              <div class="activities-container">Specialization:
                <li>{{ $list4 }}</li>
                <li>{{ $list5 }}</li>
                <li>{{ $list6 }}</li>
              </div>
            </div>
          </div>
        </div>

        <div class="section-3">
          <div class="section-3-border">
            <h2>Experience</h2>
          </div>
          <div class="education-item">
            <div class="year-container">
              <div class="year">{{ $year3 }}<br>{{ $year3_2 }}</div>
            </div>
            <div class="experience-info-container">
              <div class="forMargin">
                <div class="diploma">{{ $freelance }}</div>
                <div class="shs-name">{{ $company }}</div>
              </div>
              <div class="activities-container">
                <ul>
                  <li>{{ $list7 }}</li>
                  <li>{{ $list8 }}</li>
                  <li>{{ $list9 }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="section-4">
          <div class="section-4-border">
            <h2>Skills</h2>
          </div>
          <div class="education-item">
            <div class="skills-container">
              <li>{{ $skill1 }}</li>
              <li>{{ $skill2 }}</li>
              <li>{{ $skill3 }}</li>
              <li>{{ $skill4 }}</li>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>