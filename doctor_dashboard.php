<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['vet_id'])) {
    header('Location: doctor_login.php');
    exit();
}

$conn = getDBConnection();
$vetId = (int)$_SESSION['vet_id'];

$pendingSql = "SELECT a.appointment_id, p.pet_name, u.full_name AS owner_name, a.appointment_date, a.start_time, a.end_time, t.type_name, a.status
               FROM appointments a
               JOIN pets p ON a.pet_id = p.pet_id
               JOIN users u ON a.user_id = u.user_id
               JOIN appointment_types t ON a.type_id = t.type_id
               WHERE a.vet_id = $vetId AND a.status='scheduled'
               ORDER BY a.appointment_date, a.start_time";
$pendingResult = $conn->query($pendingSql);
$pending = $pendingResult ? $pendingResult->fetch_all(MYSQLI_ASSOC) : [];

$historySql = "SELECT a.appointment_id, p.pet_name, u.full_name AS owner_name, a.appointment_date, a.start_time, a.end_time, t.type_name, a.status
               FROM appointments a
               JOIN pets p ON a.pet_id = p.pet_id
               JOIN users u ON a.user_id = u.user_id
               JOIN appointment_types t ON a.type_id = t.type_id
               WHERE a.vet_id = $vetId AND a.status!='scheduled'
               ORDER BY a.appointment_date DESC, a.start_time DESC";
$historyResult = $conn->query($historySql);
$history = $historyResult ? $historyResult->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header_doctor.php'; ?>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['vet_name']); ?></h2>
    <h3>Pending Appointments</h3>
    <table class="schedule-table">
        <thead>
            <tr>
                <th>Pet</th>
                <th>Owner</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pending as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
                <td><?php echo htmlspecialchars($row['owner_name']); ?></td>
                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($row['start_time'] . ' - ' . $row['end_time']); ?></td>
                <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <form method="POST" action="update_appointment_status.php" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn" style="padding:0.3rem 0.6rem;">Complete</button>
                    </form>
                    <form method="POST" action="update_appointment_status.php" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn" style="background-color: var(--danger-color); padding:0.3rem 0.6rem;">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Appointment History</h3>
    <table class="schedule-table">
        <thead>
            <tr>
                <th>Pet</th>
                <th>Owner</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($history as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
                <td><?php echo htmlspecialchars($row['owner_name']); ?></td>
                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($row['start_time'] . ' - ' . $row['end_time']); ?></td>
                <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
