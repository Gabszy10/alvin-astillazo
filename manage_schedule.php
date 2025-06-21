<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['availability_id'] ?? 0);
    $vetId = (int) ($_POST['vet_id'] ?? 0);
    $day = $conn->real_escape_string($_POST['day_of_week'] ?? '');
    $start = $conn->real_escape_string($_POST['start_time'] ?? '');
    $end = $conn->real_escape_string($_POST['end_time'] ?? '');
    $available = isset($_POST['is_available']) ? 1 : 0;

    if ($action === 'create' && $vetId && $day && $start && $end) {
        $conn->query("INSERT INTO vet_availability (vet_id, day_of_week, start_time, end_time, is_available) VALUES ($vetId, '$day', '$start', '$end', $available)");
    } elseif ($action === 'delete' && $id) {
        $conn->query("DELETE FROM vet_availability WHERE availability_id=$id");
    }

    header('Location: manage_schedule.php');
    exit();
}

$vets = [];
$res = $conn->query("SELECT vet_id, full_name FROM vets ORDER BY full_name");
if ($res) {
    $vets = $res->fetch_all(MYSQLI_ASSOC);
}

$slots = [];
$sql = "SELECT a.availability_id, a.day_of_week, a.start_time, a.end_time, a.is_available, v.full_name FROM vet_availability a JOIN vets v ON a.vet_id = v.vet_id ORDER BY FIELD(a.day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday'), a.start_time";
$res = $conn->query($sql);
if ($res) {
    $slots = $res->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'header_admin.php'; ?>
    <div class="container form-container">
        <h2>Manage Vet Availability</h2>
        <h3>Add New Slot</h3>
        <form method="POST">
            <input type="hidden" name="action" value="create">
            <div class="form-row">
                <div class="form-group">
                    <label for="vet_id">Veterinarian</label>
                    <select class="form-control" id="vet_id" name="vet_id" required>
                        <option value="">Select vet</option>
                        <?php foreach ($vets as $v): ?>
                            <option value="<?php echo $v['vet_id']; ?>"><?php echo htmlspecialchars($v['full_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="day_of_week">Day</label>
                    <select class="form-control" id="day_of_week" name="day_of_week" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input class="form-control" type="time" id="start_time" name="start_time" required>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input class="form-control" type="time" id="end_time" name="end_time" required>
                </div>
                <div class="form-group form-check">
                    <label><input type="checkbox" name="is_available" checked> Available</label>
                </div>
            </div>
            <button type="submit" class="btn">Add Slot</button>

        </form>
        <br />
        <h3 class="mt-2">Existing Slots</h3>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Vet</th>
                    <th>Day</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slots as $slot): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($slot['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($slot['day_of_week']); ?></td>
                        <td><?php echo htmlspecialchars(substr($slot['start_time'], 0, 5)); ?></td>
                        <td><?php echo htmlspecialchars(substr($slot['end_time'], 0, 5)); ?></td>
                        <td><?php echo $slot['is_available'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Delete this slot?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="availability_id" value="<?php echo $slot['availability_id']; ?>">
                                <button type="submit" class="btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>