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

$sql = "SELECT pet_id, pet_name, pet_type FROM pets WHERE user_id = $userId";
$result = $conn->query($sql);
$pets = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = [
            'id' => $row['pet_id'],
            'name' => $row['pet_name'],
            'type' => $row['pet_type']
        ];
    }
}

$conn->close();

echo json_encode(['success' => true, 'pets' => $pets]);

