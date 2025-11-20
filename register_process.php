<?php
// register_process.php
// Process workshop registration form submissions

session_start();
require_once 'db_connection.php';

//ANTI-SPAM PROTECTION
$limit = 5;            // Max submissions
$time_window = 180;    // Within 180 seconds
$block_time = 300;     // 5 minutes block

// If user is still blocked
if (isset($_SESSION['register_blocked_until']) && time() < $_SESSION['register_blocked_until']) {
    die("
    <!DOCTYPE html>
    <html>
    <head>
        <title>Blocked - Too Many Attempts</title>
        <link rel='stylesheet' href='styles.css?v=3'>
    </head>
    <body>
        <div class='spam-block-container'>
            <div class='spam-block-box'>
                <h2 class='spam-title'>⚠️ Temporarily Blocked</h2>
                <p>You submitted too many workshop registrations in a short time.</p>
                <p>Please wait a few minutes and try again.</p>
                <a class='spam-back-btn' href='register.php'>Back to Registration Form</a>
            </div>
        </div>
    </body>
    </html>
    ");
}

// Track attempts
if (!isset($_SESSION['register_attempts'])) {
    $_SESSION['register_attempts'] = [];
}

// Add timestamp
$_SESSION['register_attempts'][] = time();

// Remove old timestamps outside the time window
$_SESSION['register_attempts'] = array_filter($_SESSION['register_attempts'], function($t) use ($time_window) {
    return $t >= time() - $time_window;
});

// If limit exceeded → block user
if (count($_SESSION['register_attempts']) > $limit) {
    $_SESSION['register_blocked_until'] = time() + $block_time;

    die("
    <!DOCTYPE html>
    <html>
    <head>
        <title>Blocked - Too Many Attempts</title>
        <link rel='stylesheet' href='styles.css?v=3'>
    </head>
    <body>
        <div class='spam-block-container'>
            <div class='spam-block-box'>
                <h2 class='spam-title'>❌ Spam Protection Triggered</h2>
                <p>You have exceeded the submission limit.</p>
                <p>You are blocked for 5 minutes.</p>
                <a class='spam-back-btn' href='register.php'>Back to Registration Form</a>
            </div>
        </div>
    </body>
    </html>
    ");
}

// Get form data safely
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$workshop = trim($_POST['workshop'] ?? '');
$date = trim($_POST['date'] ?? '');
$comments = trim($_POST['comments'] ?? '');

// Validate inputs
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($name)) {
        $errors[] = "Full Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $name)) {
        $errors[] = "Full Name must contain only letters and spacing only.";
    }

    if (empty($email)) {
        $errors[] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }

    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9]{10,11}$/", $phone)) {
        $errors[] = "Phone Number must be 10 or 11 digits.";
    }

    if (empty($workshop)) {
        $errors[] = "Workshop selection is required.";
    }

    if (empty($date)) {
        $errors[] = "Preferred Date is required.";
    }
}

// Show validation errors if any
if (!empty($errors)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error - Workshop Registration</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='register-wrap' data-cy='register-error'>
            <div class='register-container'>
                <div class='register error'>
                    <h3>⚠️ Registration Failed</h3>
                </div>
                <div class='register-error-message'>
                    <h2 class='error'>Submission Failed</h2>
                    <ul>";
    
    foreach ($errors as $error) {
        echo "<li class='error-item'>" . htmlspecialchars($error) . "</li>";
    }

    echo "</ul>
                    <a class='back-btn error-btn' href='register.php'>Back to Registration Form</a>
                </div>
            </div>
        </div>
    </body>
    </html>";
    exit;
}


// Map workshop values to full names
$workshopNameMap = [
    'handtied' => 'Handtied Bouquet (2 days / 5 classes)',
    'florist' => 'Florist To Be (4 days / 9 classes)',
    'hobby' => 'Hobby Class (Specific Dates)'
];
$workshopName = $workshopNameMap[$workshop] ?? $workshop;

// Insert into database
$sql = "INSERT INTO register (full_name, email, phone_number, workshop_name, preferred_date, notes)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database prepare failed: " . htmlspecialchars($conn->error));
}

$stmt->bind_param(
    "ssssss",
    $name,
    $email,
    $phone,
    $workshopName,
    $date,
    $comments
);

// Run query and display result
if ($stmt->execute()) {
    echo "<!DOCTYPE html><html><head><title>Success - Workshop Registration</title>
     <link rel='stylesheet' href='styles.css'>
     </head>
     <body>
        <div class = 'modal-overlay' data-cy='register-success'>
            <div class ='modal-card'>
                <div class = 'card-header header-success'>
                    <h3>Workshop Registration</h3>
                </div>
                <div class ='card-body success-message'>
                    <h2>✅ Workshop Registration Successful!</h2>
                    <p>Thank you, <b>" . htmlspecialchars($name) . "</b>!</p>
                    <p>Your registration for <b>" . htmlspecialchars($workshopName) . "</b> has been received.</p>
                    <p>We will contact you soon to confirm your registration.</p>
                    <a class = 'back-btn' href='register.php'>Back to Registration Form</a>
                </div>
            </div>
        </div>
     </body>
     </html>";
} else {
    echo "<!DOCTYPE html><html><head><title>Error - Workshop Registration</title>
     <link rel='stylesheet' href='styles.css'>
     </head>
     <body>
        <div class = 'modal-overlay' data-cy='register-db-error'>
            <div class ='modal-card'>
                <div class = 'card-header header-error'>
                    <h3>⚠️Registration Failed</h3>
                </div>
                <div class='card-body error-message'>
                    <h2>❌Database Error:</h2>
                    <p>" . htmlspecialchars($conn->error) . "</p>
                    <a class = 'back-btn error-btn' href='register.php'>Back to Register Form</a>
                </div>
            </div>
        </div>
     </body>
     </html>";
}

$stmt->close();
$conn->close();
?>

