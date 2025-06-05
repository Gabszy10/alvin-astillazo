<?php
require_once 'config.php';
header('Content-Type: application/json');

$conn = getDBConnection();

$sql = "SELECT a.availability_id, a.vet_id, a.day_of_week, a.start_time, a.end_time, v.full_name FROM vet_availability a JOIN vets v ON a.vet_id = v.vet_id WHERE a.is_available = 1 ORDER BY FIELD(a.day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday'), a.start_time";
$result = $conn->query($sql);

$times = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $times[] = [
            'id' => $row['availability_id'],
            'vet_id' => $row['vet_id'],
            'day' => $row['day_of_week'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'vet' => $row['full_name']
        ];
    }
}

$conn->close();

echo json_encode(['success' => true, 'times' => $times]);

