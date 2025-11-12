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
    echo "<!DOCTYPE html><html><head><title>Error - Workshop Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='error'>⚠️ Registration Failed</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
    echo "<p><a href='register.php'>⬅ Go Back to Registration Form</a></p>";
    echo "</body></html>";
    exit;
}

// Map workshop values to full names
$workshopNameMap = [
    'handtied' => 'Handtied Bouquet (2 days / 5 classes)',
    'florist' => 'Florist To Be (4 days / 9 classes)',
    'hobby' => 'Hobby Class (Specific Dates)'
];
$workshopName = $workshopNameMap[$workshop] ?? $workshop;

// Ensure phone is exactly 10 characters for database
$phone = substr($phone, 0, 10);

// Insert into database
$sql = "INSERT INTO register (full_name, email, phone_number, workshop_name, preferred_date, notes)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $workshopName, $date, $comments);

// Run query and display result
if ($stmt->execute()) {
    echo "<!DOCTYPE html><html><head><title>Success - Workshop Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='successful'>✅ Workshop Registration Successful!</h2>";
    echo "<p>Thank you, <b>" . htmlspecialchars($name) . "</b>!</p>";
    echo "<p>Your registration for <b>" . htmlspecialchars($workshopName) . "</b> has been received.</p>";
    echo "<p>We will contact you soon to confirm your registration.</p>";
    echo "<a href='register.php'>⬅ Back to Registration Form</a>";
    echo "</body></html>";
} else {
    echo "<!DOCTYPE html><html><head><title>Error - Workshop Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='error'>❌ Database Error:</h2>";
    echo "<p>" . htmlspecialchars($conn->error) . "</p>";
    echo "<a href='register.php'>⬅ Back to Registration Form</a>";
    echo "</body></html>";
}

$stmt->close();
$conn->close();
?>

