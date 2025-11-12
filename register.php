<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Registration - Root Flower</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="workshop-page">
    
 <?php include("navigation.php"); ?>
    <!-- Main Content -->
    <main>
        <section class="registration-section">
            <h2>Workshop Registration</h2>
            <p>Please fill in the form below to register for our workshop in Kuching 🌸</p>

            <form action="register_process.php" method="post">
                <label for="name">Full Name*</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name">

                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" required placeholder="example@email.com">

                <label for="phone">Phone Number*</label>
                <input type="tel" id="phone" name="phone" required pattern="[0-9]{10,11}" placeholder="e.g. 0143399709">

                <label for="workshop">Select Workshop*</label>
                <select id="workshop" name="workshop" required>
                    <option value="">-- Please select --</option>
                    <option value="handtied">Handtied Bouquet (2 days / 5 classes)</option>
                    <option value="florist">Florist To Be (4 days / 9 classes)</option>
                    <option value="hobby">Hobby Class (Specific Dates)</option>
                </select>

                <label for="date">Preferred Workshop Date*</label>
                <input type="date" id="date" name="date" required>

                <label for="comments">Additional Notes</label>
                <textarea id="comments" name="comments" rows="4" placeholder="Any requests or notes (optional)"></textarea>

            <div class="form-actions">
                <button type="submit">
                <i class="fa-solid fa-paper-plane"></i> Submit
                </button>
                <button type="reset">
                <i class="fa-solid fa-rotate-left"></i> Reset
                  </button>
            </div>
            </form>
        </section>
    </main>

<?php include("footer.php"); ?>