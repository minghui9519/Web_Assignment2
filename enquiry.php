<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Root Flower | Inquiry Form</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="inquiry-page">
 <?php include("navigation.php"); ?>


  <!-- Main Content -->
  <main>
    <section class="inquiry-section">
      <h2>Inquiry Form</h2>
      <p>Have a question or need assistance? Fill out the form below and we’ll get back to you soon 💐</p>

      <form action="enquiry_process.php" method="post" novalidate>
        <label for="firstName">First Name *</label>
        <input type="text" id="firstName" name="firstName" maxlength="25" placeholder="Enter your first name">

        <label for="lastName">Last Name *</label>
        <input type="text" id="lastName" name="lastName" maxlength="25"  placeholder="Enter your last name">

        <label for="email">Email Address *</label>
        <input type="text" id="email" name="email"  placeholder="example@gmail.com">

        <label for="phone">Phone Number *</label>
        <input type="text" id="phone" name="phone" maxlength="11"  placeholder="0123456789">

        <label for="enquiry">Enquiry Type *</label>
        <select id="enquiry" name="enquiry" required>
          <option value="">-- Please select --</option>
          <option value="products">Products</option>
          <option value="membership">Membership</option>
          <option value="workshop">Workshop</option>
          <option value="others">Others</option>
        </select>

        <label for="comments">Comments *</label>
        <textarea id="comments" name="comments" rows="5" required placeholder="Write your message here..."></textarea>

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
