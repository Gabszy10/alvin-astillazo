<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$conn = getDBConnection();

// Handle create, update, delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = isset($_POST['vet_id']) ? (int)$_POST['vet_id'] : 0;
    $full_name = $conn->real_escape_string($_POST['full_name'] ?? '');
    $specialization = $conn->real_escape_string($_POST['specialization'] ?? '');
    $contact = $conn->real_escape_string($_POST['contact_number'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($action === 'create') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO vets (full_name, specialization, contact_number, email, password_hash) VALUES ('$full_name', '$specialization', '$contact', '$email', '$hash')";
        $conn->query($sql);
    } elseif ($action === 'update' && $id) {
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE vets SET full_name='$full_name', specialization='$specialization', contact_number='$contact', email='$email', password_hash='$hash' WHERE vet_id=$id";
        } else {
            $sql = "UPDATE vets SET full_name='$full_name', specialization='$specialization', contact_number='$contact', email='$email' WHERE vet_id=$id";
        }
        $conn->query($sql);
    } elseif ($action === 'delete' && $id) {
        $conn->query("DELETE FROM vets WHERE vet_id=$id");
    }

    header('Location: manage_vets.php');
    exit();
}

$editVet = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = $conn->query("SELECT * FROM vets WHERE vet_id=$id");
    if ($res && $res->num_rows === 1) {
        $editVet = $res->fetch_assoc();
    }
}

$vets = [];
$result = $conn->query("SELECT * FROM vets ORDER BY full_name");
if ($result) {
    $vets = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Vets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header_admin.php'; ?>
<div class="container">
    <h2>Manage Veterinarians</h2>
    <h3><?php echo $editVet ? 'Edit Vet' : 'Add New Vet'; ?></h3>
    <form method="POST">
        <input type="hidden" name="action" value="<?php echo $editVet ? 'update' : 'create'; ?>">
        <?php if ($editVet): ?>
            <input type="hidden" name="vet_id" value="<?php echo $editVet['vet_id']; ?>">
        <?php endif; ?>
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input class="form-control" type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($editVet['full_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="specialization">Specialization</label>
            <input class="form-control" type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($editVet['specialization'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number</label>
            <input class="form-control" type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($editVet['contact_number'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" value="<?php echo htmlspecialchars($editVet['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password <?php if ($editVet) echo '(leave blank to keep current password)'; ?></label>
            <input class="form-control" type="password" id="password" name="password" <?php echo $editVet ? '' : 'required'; ?>>
        </div>
        <button type="submit" class="btn"><?php echo $editVet ? 'Update Vet' : 'Add Vet'; ?></button>
        <?php if ($editVet): ?>
            <a href="manage_vets.php" class="btn">Cancel</a>
        <?php endif; ?>
    </form>

    <h3 style="margin-top:2rem;">Existing Vets</h3>
    <table class="schedule-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Specialization</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($vets as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <a class="btn" href="manage_vets.php?edit=<?php echo $row['vet_id']; ?>">Edit</a>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this vet?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="vet_id" value="<?php echo $row['vet_id']; ?>">
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
