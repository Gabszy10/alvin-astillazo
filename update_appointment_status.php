<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: doctor_dashboard.php');
    exit();
}

if (!isset($_SESSION['vet_id'])) {
    header('Location: doctor_login.php');
    exit();
}

$appointmentId = (int)($_POST['appointment_id'] ?? 0);
$status = $_POST['status'] ?? '';

if (!$appointmentId || !in_array($status, ['completed', 'cancelled'])) {
    header('Location: doctor_dashboard.php');
    exit();
}

$conn = getDBConnection();
$vetId = (int)$_SESSION['vet_id'];

$stmt = $conn->prepare("UPDATE appointments SET status=? WHERE appointment_id=? AND vet_id=?");
$stmt->bind_param('sii', $status, $appointmentId, $vetId);
$stmt->execute();
$stmt->close();

$conn->close();

header('Location: doctor_dashboard.php');
exit();
?>
