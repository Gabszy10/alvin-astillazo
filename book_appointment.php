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

$conn = getDBConnection();

$userId = (int)$_SESSION['user_id'];
$petId = (int)($_POST['pet_id'] ?? 0);
$vetId = (int)($_POST['vet_id'] ?? 0);
$typeId = (int)($_POST['type_id'] ?? 0);
$date = $conn->real_escape_string($_POST['appointment_date'] ?? '');
$start = $conn->real_escape_string($_POST['start_time'] ?? '');
$end = $conn->real_escape_string($_POST['end_time'] ?? '');
$notes = $conn->real_escape_string($_POST['notes'] ?? '');

// Basic validation
if (!$petId || !$vetId || !$date || !$start || !$end) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit();
}

$dayOfWeek = date('l', strtotime($date));

// Insert appointment
$stmt = $conn->prepare("INSERT INTO appointments (user_id, pet_id, vet_id, type_id, appointment_date, start_time, end_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('iiiissss', $userId, $petId, $vetId, $typeId, $date, $start, $end, $notes);

if ($stmt->execute()) {
    $id = $stmt->insert_id;
    echo json_encode(['success' => true, 'id' => $id]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
$stmt->close();
$conn->close();

