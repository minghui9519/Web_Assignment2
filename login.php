<?php
// login.php
// Admin login with database authentication

session_start();

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    session_destroy();
    header("Location: login.php");
    exit;
}

require_once 'db_connection.php';

// Initialize variables
$error_message = '';
$login_error = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && isset($_POST['password'])) {
    $username = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error_message = "Please enter both username and password.";
        $login_error = true;
    } else {
        // Query admin table
        $sql = "SELECT admin_id, username, password FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();
                
                // Verify password (support both hashed and plain text for migration)
                $password_valid = false;
                
                // Check if password is hashed (starts with $2y$ for bcrypt)
                if (password_verify($password, $admin['password'])) {
                    $password_valid = true;
                } 
                // Fallback: check plain text password (for initial setup)
                elseif ($admin['password'] === $password) {
                    $password_valid = true;
                    // Upgrade to hashed password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE admin SET password = ? WHERE admin_id = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("si", $hashed_password, $admin['admin_id']);
                    $update_stmt->execute();
                    $update_stmt->close();
                }
                
                if ($password_valid) {
                    // Set session variables and redirect to dashboard
                    $_SESSION['admin_id'] = $admin['admin_id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_logged_in'] = true;
                    
                    // Redirect to dashboard
                    header("Location: View/dashboard.php");
                    exit;
                } else {
                    $error_message = "Invalid username or password.";
                    $login_error = true;
                }
            } else {
                $error_message = "Invalid username or password.";
                $login_error = true;
            }
            
            $stmt->close();
        } else {
            $error_message = "Database error. Please try again later.";
            $login_error = true;
        }
    }
}
?>
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
              
              <?php if ($login_error && $error_message): ?>
              <div class="error-message" style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                  <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
              </div>
              <?php endif; ?>
              
              <form class="inquiry-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
                      <li>Don't have an account? <a href="membership.php">Register here</a></li>
                      <li>Having trouble logging in? <a href="enquiry.php">Submit an inquiry</a></li>
                  </ul>
              </div>
          </section>
      </div>
    </div>
  </main>

<?php include("footer.php"); ?>