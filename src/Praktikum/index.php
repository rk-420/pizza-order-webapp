<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {   
    session_start();      // Create a new Session : 
}

require_once 'App/Core/Router.php';
require_once 'App/Core/DebugHelper.php';

// Routing light:
// .htaccess rewrites "/something" to "index.php?url=something"
$router = new Router();

try {
    switch ($router->getRoute()) {
        case '':
        case 'order':
            require_once 'App/Controller/OrderController.php';
            $controller = new OrderController();
            break;
        case 'baker':
            require_once 'App/Controller/BakerController.php';
            $controller = new BakerController();
            break;
        case 'driver':
            require_once 'App/Controller/DriverController.php';
            $controller = new DriverController();
            break;
        case 'customer':
            require_once 'App/Controller/CustomerController.php';
            $controller = new CustomerController();
            break;
        case 'api':
            require_once 'App/Controller/ApiController.php';
            $controller = new ApiController();
            break;
        case 'index':
            require_once 'App/Controller/IndexController.php';
            $controller = new IndexController();
            break;
        case 'about':
            require_once 'App/Controller/AboutController.php';
            $controller = new AboutController();
            break;
        case 'register':
            require_once 'App/Controller/RegisterController.php';
            $controller = new RegisterController();
            break;
        case 'login':
            require_once 'App/Controller/LoginController.php';
            $controller = new LoginController();
            break;
        case 'logout':
            require_once 'App/Controller/LogoutController.php';
            $controller = new LogoutController();
            break;

        default:
            http_response_code(404);
            $pageScripts = [];
            $pageTitle   = '404 | Pizza Shop';
            require 'App/View/partials/head.php';
            require 'App/View/partials/header.php';
            echo '<main><h1><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i> 404 &ndash; Seite nicht gefunden</h1><p>Die angeforderte Seite existiert nicht.</p></main>';
            require 'App/View/partials/footer.php';
            exit;
    }

    if (!isset($controller)) {
        http_response_code(404);
        throw new Exception('No controller selected for this route.');
    }

    $controller->handleRequest();
} catch (Exception $e) {
    header('Content-type: text/html; charset=UTF-8');
    echo '<h1>Unexpected error occurred</h1>';
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
