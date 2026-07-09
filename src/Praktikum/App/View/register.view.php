<?php
$pageTitle   = 'Registrieren | Pizza Shop';
$pageScripts = [];
require_once 'partials/head.php';
require_once 'partials/header.php';?>

<main>
    <h1><i class="fa-solid fa-user-plus" aria-hidden="true"></i> Registrieren</h1>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
        <p class="error-msg"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Benutzername (mind. 3 Zeichen) und Passwort (mind. 8 Zeichen) angeben.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'taken'): ?>
        <p class="error-msg"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Dieser Benutzername ist bereits vergeben.</p>
    <?php endif; ?>

    <section>
        <form action="<?= htmlspecialchars(Router::generateUrl('register')) ?>" method="POST">
            <div>
                <label for="username">Benutzername:</label><br>
                <input type="text" name="username" id="username" required minlength="3" maxlength="50" autocomplete="username">
            </div>
            <br>
            <div>
                <label for="password">Passwort:</label><br>
                <input type="password" name="password" id="password" required minlength="8" autocomplete="new-password">
            </div>
            <br>
            <div>
                <button type="submit"><i class="fa-solid fa-user-plus" aria-hidden="true"></i> Konto erstellen</button>
            </div>
        </form>
        <p>Bereits registriert? <a href="<?= htmlspecialchars(Router::generateUrl('login')) ?>">Jetzt einloggen</a></p>
    </section>
</main>

<?php require_once 'partials/footer.php'; ?>
