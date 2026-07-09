<?php
$title = "About";
require 'partials/head.php';
require 'partials/header.php';
?>
<main>
    <section>
        <h2>About</h2>
        <p>This demo page is reachable via <code>/about</code>.</p>
        <p>The URL is rewritten by <code>.htaccess</code> to <code>index.php?url=about</code>.</p>
        <p>In <code>index.php</code>, the router reads <code>url</code> and selects <code>AboutController</code> in the <code>switch</code>.</p>
        <p>This is the same pattern you can use for your own routes and pages.</p>
    </section>
</main>
<?php require 'partials/footer.php'; ?>
