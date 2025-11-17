<?php
// membership_process.php
// Process membership form submissions

require_once 'db_connection.php';

// Get form data safely
$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$membershipType = trim($_POST['membershipType'] ?? '');
$startDate = trim($_POST['startDate'] ?? '');
$comments = trim($_POST['comments'] ?? '');

// Validate inputs
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $firstName)) {
        $errors[] = "First Name must contain only letters and spacing only.";
    }

    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $lastName)) {
        $errors[] = "Last Name must contain only letters and spacing only.";
    }

    if (empty($email)) {
        $errors[] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }

    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone Number must be exactly 10 digits.";
    }

    if (empty($membershipType)) {
        $errors[] = "Membership Type is required.";
    } elseif (!in_array($membershipType, ['Basic', 'Premium', 'VIP'])) {
        $errors[] = "Invalid Membership Type.";
    }

    if (empty($startDate)) {
        $errors[] = "Start Date is required.";
    }
}

// Show validation errors if any
if (!empty($errors)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error - Membership Registration</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='modal-wrapper'>
            <div class='modal-container'>
                <div class='modal-header header-error'>
                    <h3>⚠️ Registration Failed</h3>
                </div>
                <div class='card-body error-message'>
                    <h2 class='error'>Submission Failed</h2>
                    <ul>";
    
    foreach ($errors as $error) {
        echo "<li class='error-item'>" . htmlspecialchars($error) . "</li>";
    }

    echo "</ul>
                    <a class='back-btn error-btn' href='membership.php'>Back to Membership Form</a>
                </div>
            </div>
        </div>
    </body>
    </html>";
    exit;
}


// Insert into database
$sql = "INSERT INTO membership (first_name, last_name, email, phone_number, membership_type, start_date, comments)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database prepare error: " . htmlspecialchars($conn->error));
}
$stmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $membershipType, $startDate, $comments);

// Run query and display result
if ($stmt->execute()) {
    echo "<!DOCTYPE html><html>
    <head>
     <title>Success - Membership Registration</title>
     <link rel='stylesheet' href='styles.css'>
     </head>
     <body>
        <div class = 'modal-overlay'>
            <div class ='modal-card'>
                <div class = 'card-header header-success'>
                    <h3>Membership Registration</h3>
                </div>
                <div class ='card-body success-message'>
                    <h2>✅ Membership Registration Successful!</h2>
                    <p>Welcome, <b>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</b>!</p>
                    <p>Your <b>" . htmlspecialchars($membershipType) . "</b> membership has been registered successfully.</p>
                    <p>Start Date: <b>" . htmlspecialchars($startDate) . "</b></p>
                    <a class = 'back-btn' href='membership.php'>Back to Membership Registration</a>
                </div>
            </div>
        </div>
     </body>
     </html>";
} else {
    echo "<!DOCTYPE html><html><head><title>Error - Membership Registration</title>
     <link rel='stylesheet' href='styles.css'>
     </head
     <body>
        <div class = 'modal-overlay'>
            <div class ='modal-card'>
                <div class = 'card-header header-error'>
                    <h3>⚠️ Registration Failed</h3>
                </div>
                <div class='card-body error-message'>
                    <h2 class='error'>❌ Database Error:</h2>
                    <p>" . htmlspecialchars($conn->error) . "</p>
                    <a class = 'back-btn error-btn' href='membership.php'>Back to Registration Form</a>
                </div>
            </div>
        </div>
    </body>
    </html>";
}

$stmt->close();
$conn->close();
?>
