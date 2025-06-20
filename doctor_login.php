<?php
session_start();
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $result = $conn->query("SELECT vet_id, full_name, password_hash FROM vets WHERE email = '$email'");
    if ($result && $result->num_rows === 1) {
        $doc = $result->fetch_assoc();
        if (password_verify($password, $doc['password_hash'])) {
            $_SESSION['vet_id'] = $doc['vet_id'];
            $_SESSION['vet_name'] = $doc['full_name'];
            header('Location: doctor_dashboard.php');
            exit();
        }
    }
    $error = 'Invalid email or password';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header_doctor.php'; ?>
    <div class="container">
        <h2>Doctor Login</h2>
        <br>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <br>
        <p>Back to the main <a href="login.php">User Login</a></p>
    </div>
</body>
</html>
