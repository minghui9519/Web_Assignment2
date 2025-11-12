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
    echo "<!DOCTYPE html><html><head><title>Error - Membership Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='error'>⚠️ Registration Failed</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
    echo "<p><a href='membership.php'>⬅ Go Back to Registration Form</a></p>";
    echo "</body></html>";
    exit;
}

// Insert into database
$sql = "INSERT INTO membership (first_name, last_name, email, phone_number, membership_type, start_date, comments)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $membershipType, $startDate, $comments);

// Run query and display result
if ($stmt->execute()) {
    echo "<!DOCTYPE html><html><head><title>Success - Membership Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='successful'>✅ Membership Registration Successful!</h2>";
    echo "<p>Welcome, <b>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</b>!</p>";
    echo "<p>Your <b>" . htmlspecialchars($membershipType) . "</b> membership has been registered successfully.</p>";
    echo "<p>Start Date: <b>" . htmlspecialchars($startDate) . "</b></p>";
    echo "<a href='membership.php'>⬅ Back to Membership Form</a>";
    echo "</body></html>";
} else {
    echo "<!DOCTYPE html><html><head><title>Error - Membership Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='error'>❌ Database Error:</h2>";
    echo "<p>" . htmlspecialchars($conn->error) . "</p>";
    echo "<a href='membership.php'>⬅ Back to Membership Form</a>";
    echo "</body></html>";
}

$stmt->close();
$conn->close();
?>
