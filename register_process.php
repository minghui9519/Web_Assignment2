<?php
// register_process.php
// Process workshop registration form submissions

require_once 'db_connection.php';

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

