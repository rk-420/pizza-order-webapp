<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Core/Router.php';

class LogoutController extends BaseController
{
    public function processData(): void {}

    public function generateResponse(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Location: ' . Router::generateUrl('order'));
        exit;
    }

    public function handleRequest(): void
    {
        $this->processData();
        $this->generateResponse();
    }
}
