<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Core/Router.php';
require_once 'App/Model/OrderModel.php';

class OrderController extends BaseController
{
    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $address = trim($_POST['address'] ?? '');    // Security :
        $selectedPizzas = $_POST['selected-pizzas'] ?? [];

        if (empty($address) || empty($selectedPizzas)) {
            header('Location: ' . Router::generateUrl('order') . '?error=invalid');
            exit;
        }

        $model = new OrderModel();
        $orderingId = $model->create($address, $selectedPizzas);

        if ($orderingId !== false) {      // Order ID saved into broswer tab Session:
            $_SESSION['ordering_id'] = $orderingId;
        }

        header('Location: ' . Router::generateUrl('customer'));
        exit;
    }

    private function getData(): array
    {
        $model = new OrderModel();
        return $model->getAll();
    }

    public function generateResponse(): void      // SSR 
    {
        $articles = $this->getData();
        $this->renderHtml('App/View/order.view.php', ['articles' => $articles]);
    }

    public function handleRequest(): void
    {
        $this->processData();
        $this->generateResponse();
    }
}
