<?php
$pageTitle   = 'Login | Pizza Shop';
$pageScripts = [];
require_once 'partials/head.php';
require_once 'partials/header.php';?>

<main>
    <h1><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Login</h1>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
        <p class="error-msg"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Benutzername oder Passwort ist falsch.</p>
    <?php endif; ?>

    <section>
        <form action="<?= htmlspecialchars(Router::generateUrl('login')) ?>" method="POST">
            <div>
                <label for="username">Benutzername:</label><br>
                <input type="text" name="username" id="username" required autocomplete="username">
            </div>
            <br>
            <div>
                <label for="password">Passwort:</label><br>
                <input type="password" name="password" id="password" required autocomplete="current-password">
            </div>
            <br>
            <div>
                <button type="submit"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Einloggen</button>
            </div>
        </form>
        <p>Noch kein Konto? <a href="<?= htmlspecialchars(Router::generateUrl('register')) ?>">Jetzt registrieren</a></p>
    </section>
</main>

<?php require_once 'partials/footer.php'; ?>
