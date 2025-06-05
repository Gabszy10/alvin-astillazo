<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="nav-container">
        <div class="logo">
            <i class="fas fa-paw"></i>
            <span>PetCare Pro</span>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
<?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="index.php#schedule">Schedule</a></li>
                <li><a href="index.php#register">Register Pet</a></li>
                <li><a href="index.php#appointments">My Appointments</a></li>
                <li><a href="logout.php">Logout</a></li>
<?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
<?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
