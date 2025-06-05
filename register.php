<?php
session_start();
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();
    $full_name = $conn->real_escape_string($_POST['full_name'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $phone = $conn->real_escape_string($_POST['phone'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

    $check = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($check && $check->num_rows > 0) {
        $error = 'Email already registered';
    } else {
        $conn->query("INSERT INTO users (full_name, email, contact_number, password_hash) VALUES ('$full_name', '$email', '$phone', '$password')");
        header('Location: login.php?registered=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 400px; margin: 0 auto; }
        .error { color: red; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; }
        button { padding: 10px 15px; }
    </style>
</head>
<body>
<h2>Create Account</h2>
<?php if ($error): ?>
<p class="error"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST">
    <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="phone">Contact Number</label>
        <input type="text" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
