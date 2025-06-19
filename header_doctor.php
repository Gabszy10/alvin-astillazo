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
                <?php if (isset($_SESSION['vet_id'])): ?>
                    <li><a href="doctor_dashboard.php">Dashboard</a></li>
                    <li><a href="doctor_logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="doctor_login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
