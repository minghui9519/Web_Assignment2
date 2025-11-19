<?php
// enquiry_process.php
// Process enquiry form submissions

session_start();  //track how many times the user submitted the form
require_once 'db_connection.php';

//ANTI-SPAM PROTECTION
$limit = 3; //allow only 3 submissions
$time_window = 300; //within 300 seconds (only submissions inside this window are counted)
$block_time = 300; //block for 5 minutes (300seconds)

//if user is still blocked
if (isset($_SESSION['enquiry_blocked_until']) && time() < $_SESSION['enquiry_blocked_until']){
    die("
    <!DOCTYPE html>
    <html>
    <head>
        <title>Blocked - Too Many Attempts</title>
        <link rel ='stylesheet' href = 'styles.css'>
    </head>
    <body>
        <div class = 'spam-block-container'>
            <div class ='spam-block-box'>
                <h2 class = 'spam-title'>⚠️ Temporarily Blocked</h2>
                <p>You Submitted too many enquires in a short time.</p>
                <p>Please try again later.</p>
                <a class ='spam-back-btn' href ='enquiry.php'>Back to Enquiry Page</a>
            </div>
        </div>
    </body>
    </html>
    ");
}

//Track how many Attempts
if (!isset($_SESSION['enquiry_attempts'])){
    $_SESSION['enquiry_attempts'] = [];
}
//ADD TIMESTAMP
$_SESSION['enquiry_attempts'][] = time();

//REMOVE OLD TIMESTAMPS (only keep attempts within the $time_window)
$_SESSION['enquiry_attempts'] = array_filter($_SESSION['enquiry_attempts'], function($t) use ($time_window){
    return $t >= time() - $time_window;
});

//IF LIMIT EXCEEDED (count how many attempts remain after filtering old ones)
if (count($_SESSION['enquiry_attempts']) > $limit){
    $_SESSION['enquiry_blocked_until'] = time() + $block_time;

    die("
    <!DOCTYPE html>
    <html>
    <head>
        <title>Blocked - Too Many Attempts</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='spam-block-container'>
            <div class='spam-block-box'>
                <h2 class='spam-title'>❌ Spam Protection Triggered</h2>
                <p>You have exceeded the submission limit.</p>
                <p>You are blocked for 5 minutes.</p>
                <a class='spam-back-btn' href='enquiry.php'>Back to Enquiry Page</a>
            </div>
        </div>
    </body>
    </html>
    ");
}

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
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error - Enquiry Form</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='modal-wrapper-register'>
            <div class='modal-container-register'>
                <div class='modal-header header-error-register'>
                    <h3>⚠️ Enquiry Failed</h3>
                </div>
                <div class='card-body error-message-register'>
                    <h2 class='error'>Submission Failed</h2>
                    <ul>";
    
    foreach ($errors as $error) {
        echo "<li class='error-item' data-cy='enquiry-error'>" . htmlspecialchars($error) . "</li>";
    }

    echo "</ul>
                    <a class='back-btn error-btn' href='enquiry.php'>Back to Enquiry Form</a>
                </div>
            </div>
        </div>
    </body>
    </html>";
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

