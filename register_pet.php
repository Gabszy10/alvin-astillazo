<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();

    $ownerName = $conn->real_escape_string($_POST['ownerName'] ?? '');
    $ownerEmail = $conn->real_escape_string($_POST['ownerEmail'] ?? '');
    $ownerPhone = $conn->real_escape_string($_POST['ownerPhone'] ?? '');
    $petName = $conn->real_escape_string($_POST['petName'] ?? '');
    $petType = $conn->real_escape_string($_POST['petType'] ?? '');
    $petBreed = $conn->real_escape_string($_POST['petBreed'] ?? '');
    $petAge = (int)($_POST['petAge'] ?? 0);
    $petGender = $conn->real_escape_string($_POST['petGender'] ?? '');
    $petNotes = $conn->real_escape_string($_POST['petNotes'] ?? '');

    $sql = "INSERT INTO registered_pets (owner_name, owner_email, owner_phone, pet_name, pet_type, pet_breed, pet_age, pet_gender, pet_notes) " .
           "VALUES ('$ownerName', '$ownerEmail', '$ownerPhone', '$petName', '$petType', '$petBreed', $petAge, '$petGender', '$petNotes')";

    if ($conn->query($sql)) {
        $id = $conn->insert_id;
        echo json_encode(['success' => true, 'id' => $id]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    $conn->close();
    exit();
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);

