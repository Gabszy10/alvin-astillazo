<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();

    // Owner details are collected but, without a user system, they are not
    // persisted. A static user_id value will be used for now.
    $ownerName = $conn->real_escape_string($_POST['ownerName'] ?? '');
    $ownerEmail = $conn->real_escape_string($_POST['ownerEmail'] ?? '');
    $ownerPhone = $conn->real_escape_string($_POST['ownerPhone'] ?? '');
    $petName = $conn->real_escape_string($_POST['petName'] ?? '');
    $petType = $conn->real_escape_string($_POST['petType'] ?? '');
    $petBreed = $conn->real_escape_string($_POST['petBreed'] ?? '');
    $petAge = (int)($_POST['petAge'] ?? 0);
    $petGender = $conn->real_escape_string($_POST['petGender'] ?? '');
    $petNotes = $conn->real_escape_string($_POST['petNotes'] ?? '');

    // Normalize values to match enum types in the `pets` table
    $petTypeNormalized = strtolower($petType);
    if (!in_array($petTypeNormalized, ['dog', 'cat', 'bird', 'rabbit'])) {
        $petTypeNormalized = 'other';
    }

    $petGenderNormalized = strtolower($petGender);
    if (!in_array($petGenderNormalized, ['male', 'female'])) {
        $petGenderNormalized = 'other';
    }

    if ($petBreed === '') {
        $petBreed = 'Unknown';
    }

    // Insert into the existing `pets` table with a static user_id of 1
    $sql = "INSERT INTO pets (user_id, pet_name, pet_type, breed, age, gender, special_notes) " .
           "VALUES (1, '$petName', '$petTypeNormalized', '$petBreed', $petAge, '$petGenderNormalized', '$petNotes')";

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

