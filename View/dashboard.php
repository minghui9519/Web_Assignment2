<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Root Flower</title>
    <link rel="stylesheet" href="viewstyles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
        <div class="container">
                <!-- Sidebar -->
            <div class="sidebar">
                    <h1><strong>Root Flower</strong></h1>
                    <h3>Admin Dashboard</h3>
                    
                    <ul>
                        <li><a href="?page=view_register.php"><i class="fas fa-clipboard-list"></i> Registration</a></li>
                        <li><a href="?page=view_membership.php"><i class="fas fa-users"></i> Accounts</a></li>
                        <li><a href="?page=view_enquiry.php"><i class="fas fa-envelope"></i> Enquiries</a></li>
                        <li><a href="?page=view_deleted_enquiry.php"><i class="fas fa-trash-alt"></i> Deleted Enquiries</a></li>
                    </ul>
            </div>
            <div class="main-content">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    // Security: Only allow specific page files
                    $allowed_pages = ['view_register.php', 'view_membership.php', 'view_enquiry.php', 'view_deleted_enquiry.php'];
                    if (in_array($page, $allowed_pages)) {
                        include $page;
                    } else {
                        echo '<div class="enquiry-container"><h2>Page not found</h2></div>';
                    }
                } else {
                    // Default page
                    include 'view_register.php';
                }
                ?>
            </div>
        </div>
</body>
</html>