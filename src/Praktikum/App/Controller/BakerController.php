<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Core/Router.php';
require_once 'App/Model/OrderModel.php';

class BakerController extends BaseController
{
    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $id     = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);

        if ($id > 0) {
            $model = new OrderModel();
            $model->updatePizzaStatus($id, $status);
        }

        header('Location: ' . Router::generateUrl('baker'));
        exit;
    }

    private function getData(): array
    {
        $model = new OrderModel();
        return $model->getBakerPizzas();
    }

    public function generateResponse(): void
    {
        $pizzas = $this->getData();
        $this->renderHtml('App/View/baker.view.php', ['pizzas' => $pizzas]);
    }

    public function handleRequest(): void
    {
        $this->requireRole('baker');
        $this->processData();
        $this->generateResponse();
    }
}
