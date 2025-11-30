<?php
// db_connection.php
// Database connection configuration

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "createtable";

// First, connect to MySQL server without selecting a database
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    
    // Provide helpful message if connection is refused
    if (strpos($conn->connect_error, "refused") !== false || strpos($conn->connect_error, "2002") !== false) {
        $errorMsg .= "<br><br><strong>💡 Solution:</strong> Please make sure MySQL/MariaDB service is running in XAMPP Control Panel.";
    }
    
    // Provide helpful message if host is not allowed (localhost issue)
    if (strpos($conn->connect_error, "not allowed to connect") !== false || strpos($conn->connect_error, "1130") !== false) {
        $errorMsg .= "<br><br><strong>💡 Solution:</strong> This error occurs when using 'localhost' on Windows. The connection has been configured to use '127.0.0.1' instead. If this error persists, please check your MySQL user permissions.";
    }
    
    die($errorMsg);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create tables if they don't exist
// Create enquiry table
$sql = "CREATE TABLE IF NOT EXISTS enquiry (
  enquiry_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone_number VARCHAR(10) NOT NULL,
  enquiry_type ENUM('Products', 'Membership', 'Workshop', 'Others') NOT NULL,
  comments TEXT NOT NULL,
  status ENUM('Pending', 'In Progress', 'Resolved', 'Closed') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Add status column to existing enquiry table if it doesn't exist
$sql = "SHOW COLUMNS FROM enquiry LIKE 'status'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE enquiry ADD COLUMN status ENUM('Pending', 'In Progress', 'Resolved', 'Closed') DEFAULT 'Pending' AFTER comments";
    $conn->query($sql);
}

// Create membership table
$sql = "CREATE TABLE IF NOT EXISTS membership (
  membership_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone_number VARCHAR(10) NOT NULL,
  membership_type ENUM('Basic', 'Premium', 'VIP') NOT NULL,
  start_date DATE NOT NULL,
  comments TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Create register table
$sql = "CREATE TABLE IF NOT EXISTS register (
  register_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone_number VARCHAR(10) NOT NULL,
  workshop_name VARCHAR(100) NOT NULL,
  preferred_date DATE NOT NULL,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Create deleted_enquiries table for soft delete functionality
$sql = "CREATE TABLE IF NOT EXISTS deleted_enquiries (
  deleted_id INT AUTO_INCREMENT PRIMARY KEY,
  original_enquiry_id INT NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone_number VARCHAR(10) NOT NULL,
  enquiry_type ENUM('Products', 'Membership', 'Workshop', 'Others') NOT NULL,
  comments TEXT NOT NULL,
  status ENUM('Pending', 'In Progress', 'Resolved', 'Closed') DEFAULT 'Pending',
  original_created_at TIMESTAMP,
  deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Create admin table for login authentication
$sql = "CREATE TABLE IF NOT EXISTS admin (
  admin_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Automatically create default admin account if it doesn't exist
// This ensures the admin account is available on any device without manual setup
$default_username = 'Admin';
$default_password = 'Admin'; // Default password - should be changed after first login

// Check if admin account exists
$check_sql = "SELECT admin_id FROM admin WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt) {
    $check_stmt->bind_param("s", $default_username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    // If admin doesn't exist, create it
    if ($result->num_rows == 0) {
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        if ($insert_stmt) {
            $insert_stmt->bind_param("ss", $default_username, $hashed_password);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
    }
    $check_stmt->close();
}

// Set charset to utf8 for proper character encoding
$conn->set_charset("utf8");
?>

