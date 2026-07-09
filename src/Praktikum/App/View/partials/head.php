<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pizza Shop – Bestellen Sie Ihre Lieblingspizza online und verfolgen Sie Ihre Bestellung in Echtzeit.">
    <link rel="preload" href="assets/fonts/CormorantGaramond-VariableFont_wght.woff2" as="font" type="font/woff2" crossorigin>
    <title><?= htmlspecialchars($pageTitle ?? 'Pizza Shop') ?></title>
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <link rel="preload" as="image" href="assets/hero-banner/hero-poster.png" fetchpriority="high">
    <?php if (!empty($pageScripts)): ?>
        <?php foreach ($pageScripts as $script): ?>
            <script src="<?= htmlspecialchars($script) ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>