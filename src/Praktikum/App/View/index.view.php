<?php
$title = "EWA_Framework";
require 'partials/head.php';

// Basic usage of PHP as a template engine
$heading = 'Introduction';
$text = 'This framework follows the basic MVC (Model-View-Controller) architecture.';
$crud = ["Create – Insert new data", "Read – Fetch data", "Update – Modify existing data", "Delete – Remove data"];
?>
<?php require 'partials/header.php'; ?>
<main>
    <section>
        <h2><?= $heading ?></h2>
        <p><?= $text ?></p>

        <ul>
            <li><strong>Controller:</strong> Handles logic and user input
                (e.g. <code>IndexController.php</code>)
            </li>
            <li><strong>Model:</strong> Communicates with the database
                (e.g. <code>ExampleModel.php</code>).
                This is where you typically implement <strong>CRUD</strong> operations:
                <ul>
                    <?php foreach ($crud as $item): ?>
                        <li><?= $item ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><strong>View:</strong> Displays the HTML output
                (e.g. <code>index.view.php</code>)
            </li>
            <li><strong>Partials:</strong> Reusable view components like
                <code>head.php</code> and <code>footer.php</code>
            </li>
            <li><strong>Assets:</strong> Contains static resources like CSS, JavaScript, and images
                (e.g. <code>assets/css/style.css</code>, <code>assets/js/script.js</code>, <code>assets/images/logo.png</code>)
            </li>
        </ul>
        <h3>Create your own pages</h3>
        <p>To build your own pages, copy the structure and naming convention:</p>
        <ol>
            <li>
                Add your route to the <code>switch</code> in <code>index.php</code> (e.g. <code>case 'product':</code>)
            </li>
            <li>
                Create a new controller in the <code>Controller</code> folder: <code>{Name}Controller.php</code>
            </li>
            <li>
                Create a view in the <code>View</code> folder: <code>{name}.view.php</code>
            </li>
            <li>
               Optional: If your page needs database access, create a model in the <code>Model</code> folder: <code>{Name}Model.php</code>
            </li>
            <li>
                Optional: Create new partials in the <code>partials</code> folder and add CSS/JS files in the <code>assets/</code> folder
            </li>
        </ol>
        <p><strong>Route examples:</strong> <code>/index</code>, <code>/about</code> or <code>/product</code> (rewritten by <code>.htaccess</code> to <code>index.php?url=...</code>)</p>
        <p>Use the navigation above to see how routing works across different endpoints.</p>
        <h3>DebugHelper example</h3>
        <p>Make sure to include <code>DebugHelper.php</code> with <code>require_once</code> before using it, then call <code>dump($variable);</code> to output formatted debug info in any file you want.</p>
        <?= dump($data) ?>
        <h2>Next steps</h2>
        <p><strong>Use this example as a starting point. Extend it with your own logic, style, views, models, controllers, routes and features by following the same MVC pattern. Enjoy building your project!</strong></p>
    </section>
</main>
<?php require 'partials/footer.php'; ?>
