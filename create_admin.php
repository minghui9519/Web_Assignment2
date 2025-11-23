<?php
// create_admin.php
// Script to create default admin user
// Run this file once to create the initial admin account

require_once 'db_connection.php';

// Default admin credentials (change these to set/update password!)
$default_username = 'Admin';
$default_password = 'Admin'; // Change this password to update admin password!

// Check if admin already exists
$check_sql = "SELECT admin_id FROM admin WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $default_username);
$check_stmt->execute();
$result = $check_stmt->get_result();

$admin_exists = $result->num_rows > 0;
$check_stmt->close();

if ($admin_exists) {
    // Admin exists - update password instead
    $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE admin SET password = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_sql);
    
    if ($update_stmt) {
        $update_stmt->bind_param("ss", $hashed_password, $default_username);
        
        if ($update_stmt->execute()) {
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Admin Password Updated</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div style='padding: 50px; text-align: center;'>
                    <h2 style='color: green;'>✓ Admin password updated successfully!</h2>
                    <div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; margin: 20px auto; max-width: 500px;'>
                        <p><strong>Username:</strong> {$default_username}</p>
                        <p><strong>New Password:</strong> {$default_password}</p>
                        <p style='color: #856404; margin-top: 15px;'><strong>⚠️ Important:</strong> Password has been updated. You can now login with the new password.</p>
                    </div>
                    <p><a href='login.php' style='display: inline-block; padding: 10px 20px; background: #0078d7; color: white; text-decoration: none; border-radius: 6px; margin-top: 20px;'>Go to Login Page</a></p>
                </div>
            </body>
            </html>";
            $update_stmt->close();
            $conn->close();
            exit;
        } else {
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Error Updating Password</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div style='padding: 50px; text-align: center;'>
                    <h2 style='color: red;'>Error updating admin password</h2>
                    <p>" . htmlspecialchars($conn->error) . "</p>
                    <p><a href='login.php'>Go to Login Page</a></p>
                </div>
            </body>
            </html>";
            $update_stmt->close();
            $conn->close();
            exit;
        }
    }
}

// Hash the password
$hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

// Insert admin user
$sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $default_username, $hashed_password);
    
    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Admin Created Successfully</title>
            <link rel='stylesheet' href='styles.css'>
        </head>
        <body>
            <div style='padding: 50px; text-align: center;'>
                <h2 style='color: green;'>✓ Admin user created successfully!</h2>
                <div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; margin: 20px auto; max-width: 500px;'>
                    <p><strong>Username:</strong> {$default_username}</p>
                    <p><strong>Password:</strong> {$default_password}</p>
                    <p style='color: #856404; margin-top: 15px;'><strong>⚠️ Important:</strong> Please change this password after first login!</p>
                </div>
                <p><a href='login.php' style='display: inline-block; padding: 10px 20px; background: #0078d7; color: white; text-decoration: none; border-radius: 6px;'>Go to Login Page</a></p>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Error Creating Admin</title>
            <link rel='stylesheet' href='styles.css'>
        </head>
        <body>
            <div style='padding: 50px; text-align: center;'>
                <h2 style='color: red;'>Error creating admin user</h2>
                <p>" . htmlspecialchars($conn->error) . "</p>
                <p><a href='login.php'>Go to Login Page</a></p>
            </div>
        </body>
        </html>";
    }
    
    $stmt->close();
} else {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Database Error</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div style='padding: 50px; text-align: center;'>
            <h2 style='color: red;'>Database Error</h2>
            <p>" . htmlspecialchars($conn->error) . "</p>
            <p><a href='login.php'>Go to Login Page</a></p>
        </div>
    </body>
    </html>";
}

$conn->close();
?>

