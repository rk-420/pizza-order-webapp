<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Core/Router.php';
require_once 'App/Model/UserModel.php';

class LoginController extends BaseController
{
    private const HOME_ROUTE_BY_ROLE = [
        'customer' => 'customer',
        'baker'    => 'baker',
        'driver'   => 'driver',
    ];

    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $username = trim($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        $model = new UserModel();
        $user  = $model->verifyLogin($username, $password);

        if ($user === null) {
            header('Location: ' . Router::generateUrl('login') . '?error=invalid');
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['user_id']  = (int)$user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        header('Location: ' . Router::generateUrl(self::HOME_ROUTE_BY_ROLE[$user['role']]));
        exit;
    }

    public function generateResponse(): void
    {
        $this->renderHtml('App/View/login.view.php');
    }

    public function handleRequest(): void
    {
        $this->processData();
        $this->generateResponse();
    }
}
