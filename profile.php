<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<?php include("navigation.php"); ?>
    <main>
        <div class="container profile-container-override">
            <h2 class="profile-page-title">Our Team</h2>
            <section class="profile-grid">
                <div class="member-card">
                    <div class="member-avatar"><img src="images/profile1.jpg" alt="Member 1"></div>
                    <h3 class="member-name">LOI MING HUI</h3>
                    <a class="cta-button" href="aboutme1.php">View profile</a>
                </div>
                <div class="member-card">
                    <div class="member-avatar"><img src="images\profile2.png" alt="Member 2"></div>
                    <h3 class="member-name">Yap Yu Rou</h3>
                    <a class="cta-button" href="aboutme2.php">View profile</a>
                </div>
                <div class="member-card">
                    <div class="member-avatar"><img src="images/profile3.jpg" alt="Member 3"></div>
                    <h3 class="member-name">Sonia D'laila Binti Samsaini</h3>
                    <a class="cta-button" href="aboutme3.php">View profile</a>
                </div>
                <div class="member-card">
                    <div class="member-avatar"><img src="images/profile4.jpg" alt="Member 4"></div>
                    <h3 class="member-name">Ryan Lim Hao Yin</h3>
                    <a class="cta-button" href="aboutme4.php">View profile</a>
                </div>
            </section>
        </div>
    </main>

<?php include("footer.php"); ?>