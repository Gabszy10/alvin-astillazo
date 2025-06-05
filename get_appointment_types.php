<?php
require_once 'config.php';
header('Content-Type: application/json');

$conn = getDBConnection();

$sql = "SELECT type_id, type_name FROM appointment_types";
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
