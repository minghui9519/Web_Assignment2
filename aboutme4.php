<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile 4</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="profile4-page">
 <?php include("navigation.php"); ?>
    <!-- Main Content -->
   <main>
      <div class="background">
          <div class="profile-container">
              <div class="profile-pic">
              <img src="images\profile4.jpg"  alt="My Profile Picture">
              </div> 
          </div>
      </div>

      <div class="background">
          <div class="intro">
              <p id="name">Ryan Lim Hao Yin</p>
              <p id="id">105804524</p>
              <p id="course">Bachelor of Computer Science</p>
          </div>
      </div>

    <div class="table-background">
        <div class="information">
        <table class="info-table">
            <tr>
                <th>About me</th>
                <td>I'm an optimistic student who is always eager to make new friends and learn new skills that will benefit me greatly in the future. I often go rock climbing to kill time and to ease my mind when I'm stressed.</td>
            </tr>

            <tr>
                <th>Hometown</th>
                <td>Kuching, Sarawak. Kuching is known for its cultural diversity, history, and modern-day attractions.</td>
            </tr>

            <tr>
                <th>Achievements</th>
                <td>
                    <ul>
                        <li>2020: Achieved First Place for an Interschool Swimming Competition.</li>
                        <li>2023: Organizing Chairman for Love Book Association Charity Sale.</li>
                        <li>2025: Organizing Chairman for Love Book Association Charity Run.</li>
                        <li>2025: Achieved Second Place for a Local Bouldering Competition.</li>
                </td>
            </tr>

            <tr>
                <th>Favourite Movies</th>
                <td>
                    <ul>
                        <li>Guardians of the Galaxy</li>
                        <li>Superman (2025)</li>
                        <li>Spider-Man: Into the Spider-Verse</li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th>Hobbies</th>
                <td>
                    <ul>
                        <li>Rock climbing/Bouldering</li>
                        <li>Football</li>
                        <li>Playing video games</li>
                    </ul>
                </td>
            </tr>
        </table>
        </div>
    </div>
      
      <div class="background">
          <button class="email-button"><a href="mailto:105804524@students.swinburne.edu.my">Email Me</a></button>
      </div>
  </main>

<?php include("footer.php"); ?>