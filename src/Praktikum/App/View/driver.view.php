<?php
$pageTitle   = 'Fahrer | Pizza Shop';
$pageScripts = ['assets/js/script.js'];
require_once 'partials/head.php';
require_once 'partials/header.php';?>

<main>
    <h1><i class="fa-solid fa-truck" aria-hidden="true"></i> Fahrer Ansicht</h1>

    <?php
    $readyOrders      = array_filter($orders, fn($o) => (int)$o['status'] === 0);
    $inDeliveryOrders = array_filter($orders, fn($o) => (int)$o['status'] === 1);

    /* One hidden <form> per order, placed outside all tables (W3C-valid).
       Each radio references its form via the HTML5 "form" attribute. */
    foreach ($orders as $order):
        $fid = 'driver-form-' . (int)$order['ordering_id'];
    ?>
        <form id="<?= $fid ?>"
              method="POST"
              action="<?= htmlspecialchars(Router::generateUrl('driver')) ?>">
            <input type="hidden" name="ordering_id" value="<?= (int)$order['ordering_id'] ?>">
        </form>
    <?php endforeach; ?>

    <section>
        <h2>Bereit zu liefern</h2>
        <?php if (empty($readyOrders)): ?>
            <p>Keine Bestellungen bereit.</p>
        <?php else: ?>
            <table class="status-table">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-hashtag" aria-hidden="true"></i> Bestellung</th>
                        <th><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Adresse</th>
                        <th><i class="fa-solid fa-check" aria-hidden="true"></i> Fertig</th>
                        <th><i class="fa-solid fa-truck" aria-hidden="true"></i> Unterwegs</th>
                        <th><i class="fa-solid fa-flag-checkered" aria-hidden="true"></i> Geliefert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($readyOrders as $order):
                        $fid = 'driver-form-' . (int)$order['ordering_id'];
                    ?>
                        <tr>
                            <td>#<?= (int)$order['ordering_id'] ?></td>
                            <td><?= htmlspecialchars($order['address']) ?></td>
                            <td><input form="<?= $fid ?>" type="radio" name="status" value="0"
                                       class="auto-submit" checked></td>
                            <td><input form="<?= $fid ?>" type="radio" name="status" value="1"
                                       class="auto-submit"></td>
                            <td><input form="<?= $fid ?>" type="radio" name="status" value="2"
                                       class="auto-submit"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section>
        <h2>Unterwegs</h2>
        <?php if (empty($inDeliveryOrders)): ?>
            <p>Keine Bestellungen unterwegs.</p>
        <?php else: ?>
            <table class="status-table">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-hashtag" aria-hidden="true"></i> Bestellung</th>
                        <th><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Adresse</th>
                        <th><i class="fa-solid fa-check" aria-hidden="true"></i> Fertig</th>
                        <th><i class="fa-solid fa-truck" aria-hidden="true"></i> Unterwegs</th>
                        <th><i class="fa-solid fa-flag-checkered" aria-hidden="true"></i> Geliefert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inDeliveryOrders as $order):
                        $fid = 'driver-form-' . (int)$order['ordering_id'];
                    ?>
                        <tr>
                            <td>#<?= (int)$order['ordering_id'] ?></td>
                            <td><?= htmlspecialchars($order['address']) ?></td>
                            <td><input form="<?= $fid ?>" type="radio" name="status" value="0"
                                       class="auto-submit"></td>
                            <td><input form="<?= $fid ?>" type="radio" name="status" value="1"
                                       class="auto-submit" checked></td>
                            <td><input form="<?= $fid ?>" type="radio" name="status" value="2"
                                       class="auto-submit"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</main>

<?php require_once 'partials/footer.php'; ?>
