<?php
require_once 'config.php';
header('Content-Type: application/json');

$conn = getDBConnection();

$petType = strtolower($_GET['pet_type'] ?? '');
$petFilter = '';
if ($petType) {
    $petFilter = " WHERE LOWER(pet_type) = '" . $conn->real_escape_string($petType) . "'";
}

$sql = "SELECT type_id, type_name FROM appointment_types" . $petFilter;
$result = $conn->query($sql);

$types = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $types[] = [
            'id' => $row['type_id'],
            'name' => $row['type_name']
        ];
    }
}

$conn->close();

echo json_encode(['success' => true, 'types' => $types]);
?>
