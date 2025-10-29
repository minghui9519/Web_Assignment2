<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile 2</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="profile2-page">
 <?php include("navigation.php"); ?>
  
    <!-- Main Content -->
  <main>
      <div class="background">
          <div class="profile-container">
              <div class="profile-pic">
              <img src="images\profile2.png"  alt="My Profile Picture">
              </div> 
          </div>
      </div>

      <div class="background">
          <div class="intro">
              <p id="name">Yap Yu Rou</p>
              <p id="id">105805297</p>
              <p id="course">Bachelor of Data Science</p>
          </div>
      </div>

      <div class="table-background">
          <div class="information">
          <table class="info-table">
              <tr>
                  <th>About me</th>
                  <td>I've been playing basketball since the age of ten and represented Malaysia in several tournaments. 
                      That experience taught me the value of teamwork and perseverance, lessons I'm now applying as I begin my journey as a university student, where I'm enjoying the challenges of learning new things.</td>
              </tr>

              <tr>
                  <th>Hometown</th>
                  <td>Kuching, Sarawak. A city where rich cultural heritage and modern growth exist in perfect harmony.</td>
              </tr>

              <tr>
                  <th>Achievements</th>
                  <td>
                      <ul>
                          <li>2025: Gold Medalist in <a href="https://maba.web.geniussports.com/competitions/?WHurl=%2Fcompetition%2F41593%2Fperson%2F2026983%2Fgamelog%3F" target="_blank">U-20 Major Basketball League.</a></li>
                          <li>2025: Division Champions in Kuching Secondary School Basketball League.</li>
                          <li>2024: Participated in the <a href="https://www.fiba.basketball/en/players/364716-yu-rou-yap#achievements" target="_blank">FIBA U18 Asia Cup SEABA Qualifier.</a></li>
                          <li>2024: Participated in the <a href="https://www.fiba.basketball/en/events/fiba-u18-womens-asiacup-2024/teams/malaysia/364716-yu-rou-yap" target="_blank">FIBA U18 Asia Cup.</a></li>
                          <li>2024: Participated in Asean School Games.</li>
                          <li>2024: Gold Medalist in <a href="https://basketball.asia-basket.com/player/Yap-Yu-Rou/742899" target="_blank">WMBL Pro-league.</a></li>
                          <li>2019-present: State Player for Sarawak.</li>
                      </ul>
                  </td>
              </tr>

              <tr>
                <th>Favourite Movies</th>
                <td>
                    <ul>
                        <li>The Conjuring</li>
                        <li>The Nun</li>
                        <li>Annabelle</li>
                    </ul>
                </td>
              </tr>

              <tr>
                  <th>Interests</th>
                  <td>
                      <ul>
                          <li><strong>Physical Fitness & Conditioning: </strong>Maintaining peak physical fitness through regular training and exercise.</li>
                          <li><strong>Basketball Analytics: </strong>Studying game films and statistics to appreciate the nuances of the game.</li>
                      </ul>
                  </td>
              </tr>
          </table>
          </div>
      </div>
      
      <div class="background">
          <button class="email-button"><a href="mailto:yapyurou@gmail.com">Email Me</a></button>
      </div>
  </main>
<?php include("footer.php"); ?>