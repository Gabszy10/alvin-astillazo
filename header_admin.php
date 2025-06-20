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
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="admin_logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="admin_login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
