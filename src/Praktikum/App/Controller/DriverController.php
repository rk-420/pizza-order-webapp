<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Core/Router.php';
require_once 'App/Model/OrderModel.php';

class DriverController extends BaseController
{
    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $orderingId = (int)($_POST['ordering_id'] ?? 0);
        $status     = (int)($_POST['status'] ?? 0);

        if ($orderingId > 0) {
            $model = new OrderModel();

            if ($status === 2) {
                $model->delete($orderingId);
            } else {
                $model->updateOrderStatus($orderingId, $status);
            }
        }

        header('Location: ' . Router::generateUrl('driver'));
        exit;
    }

    private function getData(): array
    {
        $model = new OrderModel();
        return $model->getDeliveryOrders();
    }

    public function generateResponse(): void
    {
        $orders = $this->getData();
        $this->renderHtml('App/View/driver.view.php', ['orders' => $orders]);
    }

    public function handleRequest(): void
    {
        $this->requireRole('driver');
        $this->processData();
        $this->generateResponse();
    }
}
