<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile 1</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="profile1-page">
 <?php include("navigation.php"); ?>

    <!-- Main Content -->
    <main>
      <div class="background">
        <div class="profile-container">
            <div class="profile-pic">
            <img src="images/profile1.jpg"  alt="My Profile Picture">
            </div> 
        </div>
    </div>

    <div class="background">
        <div class="intro">
            <p id="name">LOI MING HUI</p>
            <p id="id">105805721</p>
            <p id="course">Bachelor of Computer Science</p>
        </div>
    </div>

    <div class="table-background">
        <div class="information">
        <table class="info-table">
            <tr>
                <th>About me</th>
                <td>I'm a passionate and dedicated student who is always looking for new challenges and opportunities to grow. I'm a quick learner and I'm always looking for new ways to improve my skills.</td>
            </tr>

            <tr>
                <th>Hometown</th>
                <td>Sibu, Sarawak. Sibu is a vibrant town located in central Sarawak, Malaysia, along the banks of the Rajang River, which is the longest river in Malaysia. </td>
            </tr>

            <tr>
                <th>Greater Achievements</th>
                <td>
                    <ul>
                        <li><strong>2017: Served as President of the Red Cross Club in my school</strong></li>
                        <li><strong>2018: Received a Best Monitors Award in my school</strong></li>
                        <li><strong>2022: Won the Championship in the School Basketball Tournament</strong></li>
                        <li><strong>2023: Received the Excellence Award SPM 2023 in my school</strong></li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th>Favourite Movies</th>
                <td>
                    <ul>
                        <li>Avengers: Endgame</li>
                        <li>The Shadow's Edge</li>
                        <li>Train to Busan</li>
                        <li>Jurassic Park</li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th>Interests</th>
                <td>
                    <ul>
                        <li><strong>Playing Badminton </strong>Weekend badminton smash with the gang.</li>
                        <li><strong>Watching Movie </strong>Have a movie time with my family.</li>
                        <li><strong>Hiking </strong>Sweat it out in the nature.</li>
                    </ul>
                </td>
            </tr>
        </table>
        </div>
    </div>
    
    <div class="background">
        <a class="email-button" href="mailto:105805721@students.swinburne.edu.my">Email Me</a>
    </div>
   </main>

 <?php include("footer.php"); ?>