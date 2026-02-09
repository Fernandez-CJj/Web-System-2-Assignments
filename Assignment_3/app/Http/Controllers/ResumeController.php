<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResumeController extends Controller
{
  public function show()
  {

    $bday = '2003-01-30'; // YYYY-MM-DD
    $gender = 'Male';      // or 'Female'

    // Calculate age using pure PHP
    $dob = new \DateTime($bday);
    $today = new \DateTime();
    $age = $today->diff($dob)->y; // full years

    // Determine language tag based on age
    if ($age == 21) {
      $ageTag = ' Edad: ' . $age . ''; // Tagalog
    } elseif ($age >= 22 && $age <= 23) {
      $ageTag = ' Tawen: ' . 'duapulo ket tallo' . ''; // Ilocano
    } elseif ($age > 24) {
      $ageTag = ' Edad: ' . $age . ''; // Pangasinan
    } else {
      $ageTag = ''; // no tag
    }

    $data = [
      'name' => 'Chris Joshua Fernandez',
      'job' => 'Aspiring Software Engineer',
      'phone' => '09929579473',
      'address' => 'Nibaliw Sur, Bautista, Pangasinan',
      'email' => '22ur0729@psu.edu.ph',
      'bday' => 'January 30, 2003',
      'age' => $age,
      'ageTag' => $ageTag,
      'gender' => $gender,
      'linkedin' => 'linkedin.com/in/chris-joshua-fernandez',
      'gender' => 'Male',
      'gitlab' => 'gitlab.com/Fernandez-CJj',
      'nationality' => 'Filipino',
      'description' => 'Motivated Information Technology student at Pangasinan State University with a strong foundation in software development and mobile applications. Experienced in academic projects that involve coding, debugging, and beta testing apps. Passionate about creating efficient and user-friendly solutions, with a keen interest in improving everyday user experiences. Eager to apply my skills in real-world projects and contribute to the growth of innovative software companies.',
      'year1' => '2016-2021',
      'diploma' => 'High School Diploma',
      'shs' => 'Internation Colleges for Excellence',
      'list1' => 'Member, Journalist Club',
      'list2' => 'Member, Youth Club',
      'list3' => 'Journalist of the year',
      'year2' => '2022-present',
      'collegeDiploma' => 'Bachelor of Science in Information Technology',
      'college' => 'Pangasinan State University',
      'list4' => 'Designing UI and UX',
      'list5' => 'Develop Mobile Application',
      'list6' => 'Develop Website',
      'year3' => 'June 2022',
      'year3_2' => '-present',
      'freelance' => 'Aspiring Software Engineer',
      'company' => 'N/A',
      'list7' => 'Created a prototype for deaf users that allow the non-deaf user to learn sign language in their own',
      'list8' => 'Created a prototype for organizer and talents that allow them to discover talents and events on their own',
      'list9' => 'Created a website for finding restaurants in the province of Tarlac',
      'skill1' => 'C++, C#, Java',
      'skill2' => 'HTML, CSS, Javascript, php',
      'skill3' => 'Dart, Flutter, mySQL',
      'skill4' => 'Figma'
    ];

    return view('biodata', $data);
  }
}
