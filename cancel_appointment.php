<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$appointmentId = (int)($_POST['appointment_id'] ?? 0);
if (!$appointmentId) {
    echo json_encode(['success' => false, 'error' => 'Missing appointment id']);
    exit();
}

$conn = getDBConnection();
$userId = (int)$_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE appointments SET status='cancelled' WHERE appointment_id=? AND user_id=?");
$stmt->bind_param('ii', $appointmentId, $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Appointment not found']);
}

$stmt->close();
$conn->close();
