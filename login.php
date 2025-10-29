<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Root Flower</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="login-page">
 <?php include("navigation.php"); ?>
    <!-- Main Content -->
    <main>
      <div class="background">
      <div class="container">
          <section class="inquiry-section">
              <h2>Login</h2>
              <p>Please enter your login ID and password to access your account.</p>
              
              <form class="inquiry-form" action="#" method="post">
                  <div class="form-group">
                      <label for="login">Login ID *</label>
                      <input 
                          type="text" 
                          id="login" 
                          name="login" 
                          maxlength="10" 
                          pattern="[A-Za-z]+" 
                          title="Please enter only alphabetical characters (maximum 10 characters)"
                          required 
                          placeholder="Enter your login ID"
                          autocomplete="username"
                      >
                      <small class="form-help">*letters only, maximum 10 characters</small>
                  </div>

                  <div class="form-group">
                      <label for="password">Password *</label>
                      <input 
                          type="password" 
                          id="password" 
                          name="password" 
                          maxlength="25" 
                          pattern="[A-Za-z]+" 
                          title="Please enter only alphabetical characters (maximum 25 characters)"
                          required 
                          placeholder="Enter your password"
                          autocomplete="current-password"
                      >
                      <small class="form-help">*letters only, maximum 25 characters</small>
                  </div>

                  <div class="form-actions">
                      <button type="submit" class="submit-button">
                          <i class="fa-solid fa-sign-in-alt"></i>
                          Login
                      </button>
                      <button type="reset" class="reset-button">
                          <i class="fa-solid fa-undo"></i>
                          Reset
                      </button>
                  </div>
              </form>

              <div class="login-help">
                  <p><strong>Need help?</strong></p>
                  <ul>
                      <li>Forgot your password? <a href="mailto:rootflower@gmail.com">Contact us</a> for assistance</li>
                      <li>Don't have an account? <a href="registration.php">Register here</a></li>
                      <li>Having trouble logging in? <a href="enquiry.php">Submit an inquiry</a></li>
                  </ul>
              </div>
          </section>
      </div>
    </div>
  </main>

<?php include("footer.php"); ?>