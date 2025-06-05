<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$conn = getDBConnection();
$userId = (int)$_SESSION['user_id'];

$sql = "SELECT a.appointment_id, a.pet_id, a.appointment_date, a.start_time, a.end_time, a.notes, a.created_at, v.full_name AS vet_name, t.type_name FROM appointments a JOIN vets v ON a.vet_id = v.vet_id JOIN appointment_types t ON a.type_id = t.type_id WHERE a.user_id = $userId AND a.status='scheduled' ORDER BY a.appointment_date DESC, a.start_time DESC";
$result = $conn->query($sql);
$appointments = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = [
            'id' => $row['appointment_id'],
            'petId' => $row['pet_id'],
            'date' => $row['appointment_date'],
            'time' => $row['start_time'] . ' - ' . $row['end_time'],
            'vet' => $row['vet_name'],
            'reason' => $row['type_name'],
            'notes' => $row['notes'],
            'bookingDate' => date('Y-m-d', strtotime($row['created_at']))
        ];
    }
}

$conn->close();

echo json_encode(['success' => true, 'appointments' => $appointments]);
