<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "createtable";

// connect to MySQL server without selecting a database
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database '$dbname' created or already exists.<br>";
} else {
  die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

// create enquiry table
$sql = "CREATE TABLE IF NOT EXISTS enquiry (
  enquiry_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone_number VARCHAR(10) NOT NULL,
  enquiry_type ENUM('Products', 'Membership', 'Workshop', 'Others') NOT NULL,
  comments TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
  echo "Table 'enquiry' created successfully.<br>";
} else {
  echo "Error creating 'enquiry' table: " . $conn->error . "<br>";
}

// create membership table
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
if ($conn->query($sql) === TRUE) {
  echo "Table 'membership' created successfully.<br>";
} else {
  echo "Error creating 'membership' table: " . $conn->error . "<br>";
}

// create register table
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
if ($conn->query($sql) === TRUE) {
  echo "Table 'register' created successfully.<br>";
} else {
  echo "Error creating 'register' table: " . $conn->error . "<br>";
}

$conn->close();
?>
