<?php
$pageTitle   = 'Pizzabäcker | Pizza Shop';
$pageScripts = ['assets/js/script.js'];
require_once 'partials/head.php';
require_once 'partials/header.php';?>

<main>
    <h1><i class="fa-solid fa-fire" aria-hidden="true"></i> Pizzab&auml;cker Ansicht</h1>

    <?php if (empty($pizzas)): ?>
        <p>Keine offenen Bestellungen.</p>
    <?php else: ?>

        <?php
        /* One hidden <form> per pizza, placed outside the <table> so the HTML is W3C-valid.
           Each radio in the table references its form via the HTML5 "form" attribute.
           Radios that share the same form id and the same name are mutually exclusive. */
        foreach ($pizzas as $pizza):
            $fid = 'baker-form-' . (int)$pizza['ordered_article_id'];
        ?>
            <form id="<?= $fid ?>"
                  method="POST"
                  action="<?= htmlspecialchars(Router::generateUrl('baker')) ?>">
                <input type="hidden" name="id" value="<?= (int)$pizza['ordered_article_id'] ?>">
            </form>
        <?php endforeach; ?>

        <table class="status-table">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-pizza-slice" aria-hidden="true"></i> Pizza</th>
                    <th><i class="fa-solid fa-hashtag" aria-hidden="true"></i> Bestellung</th>
                    <th><i class="fa-solid fa-clock" aria-hidden="true"></i> Bestellt</th>
                    <th><i class="fa-solid fa-fire" aria-hidden="true"></i> Im Ofen</th>
                    <th><i class="fa-solid fa-check" aria-hidden="true"></i> Fertig</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pizzas as $pizza):
                    $fid    = 'baker-form-' . (int)$pizza['ordered_article_id'];
                    $status = (int)$pizza['status'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($pizza['name']) ?></td>
                        <td>#<?= (int)$pizza['ordering_id'] ?></td>
                        <td><input form="<?= $fid ?>" type="radio" name="status" value="0"
                                   class="auto-submit" <?= $status === 0 ? 'checked' : '' ?>></td>
                        <td><input form="<?= $fid ?>" type="radio" name="status" value="1"
                                   class="auto-submit" <?= $status === 1 ? 'checked' : '' ?>></td>
                        <td><input form="<?= $fid ?>" type="radio" name="status" value="2"
                                   class="auto-submit"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</main>

<?php require_once 'partials/footer.php'; ?>
