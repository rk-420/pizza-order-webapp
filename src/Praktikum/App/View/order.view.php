<?php
$pageTitle   = 'Bestellung | Pizza Shop';
$pageScripts = ['assets/js/script.js'];
require_once 'partials/head.php';
require_once 'partials/header.php';?>

<video autoplay muted loop playsinline class="hero-video" poster="assets/hero-banner/hero-poster.png" fetchpriority="high">
    <source src="assets/hero-banner/hero-banner.mp4" type="video/mp4">
</video>

<main>
    <h1><i class="fa-solid fa-pizza-slice" aria-hidden="true"></i> Bestellung</h1>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
        <p class="error-msg"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Bitte Adresse eingeben und mindestens eine Pizza auswählen.</p>
    <?php endif; ?>

    <section>
        <h2><i class="fa-solid fa-utensils" aria-hidden="true"></i> Speisekarte</h2>
        <div class="article-box">
            <?php foreach ($articles as $article): ?>
                <article class="article-item"
                         data-id="<?= htmlspecialchars((string)$article['article_id']) ?>"
                         data-name="<?= htmlspecialchars($article['name']) ?>"
                         data-price="<?= htmlspecialchars((string)$article['price']) ?>">
                    <h3><?= htmlspecialchars($article['name']) ?> &ndash; <?= number_format((float)$article['price'], 2, ',', '.') ?>&euro;</h3>
                    <img src="<?= htmlspecialchars($article['picture']) ?>" alt="<?= htmlspecialchars($article['name']) ?>" width="300" height="250">
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="warenkorb">
        <h2><i class="fa-solid fa-basket-shopping" aria-hidden="true"></i> Warenkorb</h2>
        <form id="order-form" action="<?= htmlspecialchars(Router::generateUrl('order')) ?>" method="POST">
            <div>
                <label for="user-address"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Lieferadresse:</label><br>
                <input type="text" name="address" id="user-address" placeholder="Adresse eingeben" aria-label="Lieferadresse eingeben">
            </div>
            <br>
            <div>
                <label for="cart-select">Ausgewählte Pizzen:</label><br>
                <select name="selected-pizzas[]" id="cart-select" multiple size="5">
                </select>
            </div>
            <br>
            <div>
                <p>Gesamtpreis: <span id="total-price">0,00</span>&euro;</p>
            </div>
            <br>
            <div>
                <button type="button" id="delete-selected-btn" aria-label="Ausgewählte Pizzen löschen">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> Auswahl l&ouml;schen
                </button>
                <button type="button" id="delete-all-btn" aria-label="Alle Pizzen löschen">
                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i> Alles l&ouml;schen
                </button>
                <button type="submit" id="order-btn" disabled aria-label="Bestellung aufgeben">
                    <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i> Bestellen
                </button>
            </div>
        </form>
    </section>
</main>

<?php require_once 'partials/footer.php'; ?>
