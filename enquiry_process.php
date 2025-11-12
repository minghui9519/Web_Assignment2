<?php
// enquiry_process.php
// Process enquiry form submissions

require_once 'db_connection.php';

// Get form data safely
$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$enquiry = trim($_POST['enquiry'] ?? '');
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

    if (empty($enquiry)) {
        $errors[] = "Enquiry Type is required.";
    }

    if (empty($comments)) {
        $errors[] = "Comments are required.";
    }
}

// Show validation errors if any
if (!empty($errors)) {
    echo "<!DOCTYPE html><html><head><title>Error - Enquiry Form</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head><body>";
    echo "<h2 class='error'>⚠️ Submission Failed</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
    echo "<p><a href='enquiry.php'>⬅ Go Back to Enquiry Form</a></p>";
    echo "</body></html>";
    exit;
}

// Map form values to database ENUM values (capitalize first letter)
$enquiryTypeMap = [
    'products' => 'Products',
    'membership' => 'Membership',
    'workshop' => 'Workshop',
    'others' => 'Others'
];
$enquiryType = $enquiryTypeMap[$enquiry] ?? 'Others';

// Insert into database
$sql = "INSERT INTO enquiry (first_name, last_name, email, phone_number, enquiry_type, comments)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $enquiryType, $comments);

// Run query and display result
if ($stmt->execute()) {
    echo "<!DOCTYPE html><html><head><title>Success - Enquiry Form</title>
     <link rel='stylesheet' href='styles.css'>
     </head>
     <body>
        <div class = 'modal-overlay'>
            <div class ='modal-card'>
                <div class = 'card-header header-success'>
                    <h3>Enquiry Form</h3>
                </div>
                <div class ='card-body success-message'>
                    <h2>✅ Enquiry Submitted Successfully!</h2>
                    <p>Thank you, <b>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</b>!</p>
                    <p>We have received your enquiry and will get back to you soon.</p>
                    <a class = 'back-btn' href='enquiry.php'>Back to Enquiry Form</a>
                </div>
            </div>
        </div>
     </body>
     </html>";
} else {
    echo "<!DOCTYPE html><html><head><title>Error - Enquiry Form</title>
     <link rel='stylesheet' href='styles.css'>
     </head>
     <body>
        <div class = 'modal-overlay'>
            <div class ='modal-card'>
                <h3>⚠️ Enquiry Failed</h3>
            </div>
            <div class='card-body error-message'>
                <h2>❌ Database Error:</h2>
                <p>" . htmlspecialchars($conn->error) . "</p>
                <a class = 'back-btn error-btn' href='enquiry.php'>Back to Enquiry Form</a>
            </div>
        </div>
    </div>
    </body>
    </html>";
}

$stmt->close();
$conn->close();
?>

