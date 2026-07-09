<?php $role = $_SESSION['role'] ?? null; ?>
<nav class="navigation-bar">
    <a href="<?= htmlspecialchars(Router::generateUrl('order')) ?>" class="nav-link">
        <i class="fa-solid fa-pizza-slice" aria-hidden="true"></i> Bestellung
    </a>
    <?php if ($role === 'baker'): ?>
    <a href="<?= htmlspecialchars(Router::generateUrl('baker')) ?>" class="nav-link">
        <i class="fa-solid fa-fire" aria-hidden="true"></i> Pizzabäcker
    </a>
    <?php endif; ?>
    <?php if ($role === 'driver'): ?>
    <a href="<?= htmlspecialchars(Router::generateUrl('driver')) ?>" class="nav-link">
        <i class="fa-solid fa-truck" aria-hidden="true"></i> Fahrer
    </a>
    <?php endif; ?>
    <?php if ($role === 'customer'): ?>
    <a href="<?= htmlspecialchars(Router::generateUrl('customer')) ?>" class="nav-link">
        <i class="fa-solid fa-user" aria-hidden="true"></i> Kundenansicht
    </a>
    <?php endif; ?>
    <?php if ($role === null): ?>
    <a href="<?= htmlspecialchars(Router::generateUrl('login')) ?>" class="nav-link">
        <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Login
    </a>
    <a href="<?= htmlspecialchars(Router::generateUrl('register')) ?>" class="nav-link">
        <i class="fa-solid fa-user-plus" aria-hidden="true"></i> Registrieren
    </a>
    <?php else: ?>
    <a href="<?= htmlspecialchars(Router::generateUrl('logout')) ?>" class="nav-link">
        <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i> Logout (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)
    </a>
    <?php endif; ?>
</nav>
