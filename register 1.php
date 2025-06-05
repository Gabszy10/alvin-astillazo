<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();
    
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if user exists
    $check = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) die("Email already registered");
    
    // Insert user
    $conn->query("INSERT INTO users (full_name, email, contact_number, password_hash) 
                 VALUES ('$full_name', '$email', '$phone', '$password')");
    
    header("Location: login.php?registered=1");
    exit();
}
?>