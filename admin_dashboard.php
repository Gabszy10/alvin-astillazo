<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$conn = getDBConnection();
$vets = [];
$result = $conn->query("SELECT vet_id, full_name, email FROM vets ORDER BY full_name");
if ($result) {
    $vets = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'header_admin.php'; ?>
    <div class="container form-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h2>
        <br />
        <h3>Registered Veterinarians</h3>
        <br />
        <p><a class="btn" href="manage_vets.php">Add / Edit Vets</a></p>

        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vets as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>