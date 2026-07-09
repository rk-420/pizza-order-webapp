<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Core/Router.php';
require_once 'App/Model/UserModel.php';

class RegisterController extends BaseController
{
    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $username = trim($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if (mb_strlen($username) < 3 || mb_strlen($username) > 50 || mb_strlen($password) < 8) {
            header('Location: ' . Router::generateUrl('register') . '?error=invalid');
            exit;
        }

        $model  = new UserModel();
        $userId = $model->register($username, $password, 'customer');

        if ($userId === false) {
            header('Location: ' . Router::generateUrl('register') . '?error=taken');
            exit;
        }

        // Log the new account in immediately.
        $_SESSION['user_id']  = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['role']     = 'customer';

        header('Location: ' . Router::generateUrl('customer'));
        exit;
    }

    public function generateResponse(): void
    {
        $this->renderHtml('App/View/register.view.php');
    }

    public function handleRequest(): void
    {
        $this->processData();
        $this->generateResponse();
    }
}
