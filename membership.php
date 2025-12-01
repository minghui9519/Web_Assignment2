<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Root Flower | Membership Registration</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="membership-page">

 <?php include("navigation.php"); ?>

  <!-- Main Content -->
  <main>
    <section class="registration-section">
      <h2>Membership Registration</h2>
      <p>Join Root Flower’s community for exclusive offers, member-only discounts, and early access to workshops 🌸</p>

      <form action="membership_process.php" method="post" novalidate>
        <label for="firstName">First Name *</label>
        <input type="text" id="firstName" name="firstName" maxlength="50" required placeholder="Enter your first name">

        <label for="lastName">Last Name *</label>
        <input type="text" id="lastName" name="lastName" maxlength="50" required placeholder="Enter your last name">

        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" maxlength="100" required placeholder="example@gmail.com">

        <label for="phone">Phone Number *</label>
        <input type="tel" id="phone" name="phone" maxlength="11" required placeholder="0123456789">

        <label for="membershipType">Membership Type *</label>
        <select id="membershipType" name="membershipType" required>
          <option value="">-- Please select --</option>
          <option value="Basic">Basic</option>
          <option value="Premium">Premium</option>
          <option value="VIP">VIP</option>
        </select>

        <label for="startDate">Start Date *</label>
        <input type="date" id="startDate" name="startDate" required>

        <label for="comments">Comments</label>
        <textarea id="comments" name="comments" rows="4" placeholder="Any additional information (optional)"></textarea>

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