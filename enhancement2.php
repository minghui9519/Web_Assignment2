<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhancement - Root Flower</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php include("navigation.php"); ?>

<main>
    <div class="container">
        <section class="enhancement-section">
            <h1>Enhancement Assignment 2</h1>

            <div class="enhancement-list">
                <article class="enhancement-item">
                    <h3>1. Unified Admin Dashboard Shell</h3>
                    <p><strong>How it goes beyond basic requirements:</strong> Instead of serving raw PHP tables, a dedicated dashboard (`View/dashboard.php`) loads vetted view partials inside a secured shell with sidebar navigation, contextual styles, and asset preloading that matches the public-facing theme.</p>

                    <p><strong>Code needed to implement:</strong></p>
                    <div class="code-example">
<pre><code>// View/dashboard.php
$is_dashboard_context = true;
$allowed_pages = [
    'view_register.php',
    'view_membership.php',
    'view_enquiry.php',
    'view_deleted_enquiry.php'
];

if (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
    include $_GET['page'];
} else {
    include 'view_register.php';
}</code></pre>
                    </div>

                    <p><strong>Hyperlink to implementation:</strong> <a href="View/dashboard.php" target="_blank">Admin Dashboard Shell</a></p>
                    <p><strong>Third-party sources:</strong></p>
                    <ul>
                        <li>Access control approach adapted from <a href="https://www.php.net/manual/en/function.in-array.php" target="_blank">PHP Manual – in_array</a></li>
                        <li>PHP template includes tutorial: <a href="https://www.youtube.com/watch?v=0NoyOIqB8d0" target="_blank">Creating a PHP template file with includes for header, navigation and footer</a></li>
                    </ul>
                </article>

                <article class="enhancement-item">
                    <h3>2. Enquiry Lifecycle Management (View, Update, Soft Delete, Restore)</h3>
                    <p><strong>How it goes beyond basic requirements:</strong> Admins can update enquiry statuses in-line, move records to a recycle bin (`deleted_enquiries`), and restore them with original timestamps—features commonly found in production CRMs.</p>

                    <p><strong>Code needed to implement:</strong></p>
                    <div class="code-example">
<pre><code>// View/view_enquiry.php (status update snippet)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $allowed_statuses = ['Pending', 'In Progress', 'Resolved', 'Closed'];
    if (in_array($new_status, $allowed_statuses)) {
        $stmt = $conn->prepare("UPDATE enquiry SET status = ? WHERE enquiry_id = ?");
        $stmt->bind_param("si", $new_status, $enquiry_id);
        $stmt->execute();
    }
}
// Handle delete enquiry confirmation and execution
if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 'yes' && isset($_GET['id'])) {
    $enquiry_id = intval($_GET['id']);
    
    // Get the enquiry data before deleting
    $sql = "SELECT enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, created_at 
            FROM enquiry WHERE enquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enquiry_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $enquiry_data = $result->fetch_assoc();
        $stmt->close();
        
        // Insert into deleted_enquiries table
        $sql = "INSERT INTO deleted_enquiries (original_enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, original_created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssss", 
            $enquiry_data['enquiry_id'],
            $enquiry_data['first_name'],
            $enquiry_data['last_name'],
            $enquiry_data['email'],
            $enquiry_data['phone_number'],
            $enquiry_data['enquiry_type'],
            $enquiry_data['comments'],
            $enquiry_data['status'],
            $enquiry_data['created_at']
        );
        
        if ($stmt->execute()) {
            $stmt->close();
            
            // Delete from enquiry table
            $sql = "DELETE FROM enquiry WHERE enquiry_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $enquiry_id);
            
            if ($stmt->execute()) {
                // Redirect to remove GET parameters and show success message
                $page_param = '?page=view_enquiry.php';
                if (isset($_GET['page'])) {
                    $page_param = '?page=' . urlencode($_GET['page']);
                }
                header("Location: dashboard.php" . $page_param . "&deleted=success");
                exit;
            } else {
                $update_message = "Error deleting enquiry: " . $conn->error;
                $update_type = "error";
            }
            $stmt->close();
        } else {
            $update_message = "Error moving enquiry to deleted: " . $conn->error;
            $update_type = "error";
            $stmt->close();
        }
    } else {
        $update_message = "Enquiry not found.";
        $update_type = "error";
        $stmt->close();
    }
}
</code></pre>
                    </div>

                    <p><strong>Hyperlink to implementation:</strong> <a href="View/dashboard.php?page=view_enquiry.php" target="_blank">Enquiry Manager</a> | <a href="View/dashboard.php?page=view_deleted_enquiry.php" target="_blank">Deleted Enquiries</a></p>
                    <p><strong>Third-party sources:</strong></p>
                    <ul>
                        <li>Prepared statement pattern referenced from <a href="https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php" target="_blank">PHP MySQLi Prepared Statements Guide</a></li>
                        <li>PHP CRUD operations tutorial: <a href="https://www.youtube.com/watch?v=ExW0bYNMTlo" target="_blank">PHP CRUD | Create, Read, Update, Delete, View using PHP MySql using Bootstrap 5</a></li>
                        <li>Complete CRUD application guide: <a href="https://www.tutorialrepublic.com/php-tutorial/php-mysql-crud-application.php" target="_blank">Tutorial Republic - PHP MySQL CRUD Application</a></li>
                        <li>Advanced CRUD with pagination: <a href="https://pbl-platform.vercel.app/tutorials/php/php-advanced-crud-tutorial" target="_blank">PBL Platform - PHP Advanced CRUD Tutorial</a></li>
                        <li>Soft delete pattern: <a href="https://www.simplilearn.com/tutorials/php-tutorial/php-crud-operations" target="_blank">Simplilearn - PHP CRUD Operations</a></li>
                    </ul>
                </article>

                <article class="enhancement-item">
                    <h3>3. Membership CRUD with Modal Forms & Validation</h3>
                    <p><strong>How it goes beyond basic requirements:</strong> Beyond viewing data, admins can create, edit, and delete membership accounts using modal overlays that validate names, emails, phone numbers, membership types, and start dates before persisting.</p>

                    <p><strong>Code needed to implement:</strong></p>
                    <div class="code-example">
<pre><code>// View/view_membership.php (server-side validation excerpt)
if (empty($firstName) || !preg_match("/^[A-Za-z' ]+$/", $firstName)) {
    $errors[] = "First Name must contain only letters and spacing only.";
}
if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Phone Number must be exactly 10 digits.";
}
// Persist only when $errors is empty

// Handle delete membership confirmation and execution
if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 'yes' && isset($_GET['id'])) {
    $membership_id = intval($_GET['id']);
    
    $sql = "DELETE FROM membership WHERE membership_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $membership_id);
    
    if ($stmt->execute()) {
        $page_param = '?page=view_membership.php';
        if (isset($_GET['page'])) {
            $page_param = '?page=' . urlencode($_GET['page']);
        }
        header("Location: dashboard.php" . $page_param . "&deleted=success");
        exit;
    } else {
        $update_message = "Error deleting membership: " . $conn->error;
        $update_type = "error";
    }
    $stmt->close();
}
</code></pre>
                    </div>

                    <p><strong>Hyperlink to implementation:</strong> <a href="View/dashboard.php?page=view_membership.php&create=1" target="_blank">Membership CRUD</a></p>
                    <p><strong>Third-party sources:</strong></p>
                    <ul>
                        <li>Regex validation pattern informed by <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes/pattern" target="_blank">MDN HTML Pattern Attribute</a></li>
                        <li>PHP form validation tutorial: <a href="https://www.cloudways.com/blog/crud-in-mysql-php/" target="_blank">Cloudways - Simple CRUD Using PHP and MySQL</a></li>
                        <li>Modal form design: <a href="https://www.youtube.com/watch?v=ExW0bYNMTlo" target="_blank">PHP CRUD with Bootstrap 5 Modal Forms</a></li>
                        <li>PDO CRUD application: <a href="https://codeshack.io/crud-application-php-pdo-mysql/" target="_blank">CodeShack - CRUD Application with PHP, PDO, and MySQL</a></li>
                    </ul>
                </article>

                <article class="enhancement-item">
                    <h3>4. Workshop Registration Edit Console</h3>
                    <p><strong>How it goes beyond basic requirements:</strong> Admins can open any workshop registration record in a modal, correct applicant data, and persist changes with server-side validation—bridging the front-office form submissions with controlled back-office governance.</p>

                    <p><strong>Code needed to implement:</strong></p>
                    <div class="code-example">
<pre><code>// View/view_register.php (update handler)
$stmt = $conn->prepare(
    "UPDATE register SET full_name = ?, email = ?, phone_number = ?, workshop_name = ?, preferred_date = ?, notes = ? WHERE register_id = ?"
);
$stmt->bind_param("ssssssi", $fullName, $email, $phone, $workshop, $preferredDate, $notes, $register_id);
$stmt->execute();
</code></pre>
                    </div>

                    <p><strong>Hyperlink to implementation:</strong> <a href="View/dashboard.php?page=view_register.php" target="_blank">Workshop Registrations</a></p>
                    <p><strong>Third-party sources:</strong></p>
                    <ul>
                        <li>PHP update operations: <a href="https://www.youtube.com/watch?v=mjVuBlwXASo" target="_blank">PHP CRUD (Create, Update, Delete) with MySQL on a single page</a></li>
                        <li>PHP 8 CRUD tutorial: <a href="https://startutorial.com/view/simple-php-crud-source-code-with-php-8-and-mysql" target="_blank">Start Tutorial - Simple PHP CRUD with PHP 8 and MySQL</a></li>
                        <li>Database update patterns: <a href="https://www.codexworld.com/php-crud-operations-with-search-and-pagination/" target="_blank">CodexWorld - PHP CRUD Operations with Search and Pagination</a></li>
                    </ul>
                </article>

                <article class="enhancement-item">
                    <h3>5. Anti-Spam Protection</h3>
                    <p><strong>How it goes beyond basic requirements:</strong>If a user repeatedly submits an empty form, the system will temporarily block them for 5 minutes to ensure proper usage and prevent misuse.</p>

                    <p><strong>Code needed to implement:</strong></p>
                    <div class="code-example">
<pre><code>//ANTI-SPAM PROTECTION
$limit = 3;            
$time_window = 180;    
$block_time = 300;     

// If user is still blocked
if (isset($_SESSION['membership_blocked_until']) && time() < $_SESSION['membership_blocked_until']) {
    die("
    <!DOCTYPE html>
    <html>...
    </html>
    ");
}

// Track attempts
if (!isset($_SESSION['membership_attempts'])) {
    $_SESSION['membership_attempts'] = [];
}

// Add current timestamp
$_SESSION['membership_attempts'][] = time();

// Remove old timestamps outside the time window
$_SESSION['membership_attempts'] = array_filter($_SESSION['membership_attempts'], function($t) use ($time_window) {
    return $t >= time() - $time_window;
});

// If limit exceeded, block user
if (count($_SESSION['membership_attempts']) > $limit) {
    $_SESSION['membership_blocked_until'] = time() + $block_time;

    die("
    <!DOCTYPE html>
    <html>...
    </html>
    ");
}
</code></pre>
                    </div>

                    <p><strong>Hyperlink to implementation:</strong> <a href="enquiry_process.php" target="_blank">Enquiry Process</a></p>
                </article>

</main>

<?php include("footer.php"); ?>