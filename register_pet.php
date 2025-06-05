<?php
require_once 'config.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        exit();
    }

    $conn = getDBConnection();

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

    // Insert pet for the logged in user
    $userId = (int)$_SESSION['user_id'];
    $sql = "INSERT INTO pets (user_id, pet_name, pet_type, breed, age, gender, special_notes) " .
           "VALUES ($userId, '$petName', '$petTypeNormalized', '$petBreed', $petAge, '$petGenderNormalized', '$petNotes')";

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

