<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Model/OrderModel.php';

class ApiController extends BaseController
{
    public function processData(): void {}

    public function generateResponse(): void
    {  // API only returns data for the session that is asking
        $orderingId = isset($_SESSION['ordering_id']) ? (int)$_SESSION['ordering_id'] : null;

        if (!$orderingId) {
            $this->renderJson(['ordering_id' => null]);
            return;
        }

        $model = new OrderModel();
        $this->renderJson($model->getOrderStatus($orderingId));
    }

    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            header('Allow: GET');
            $this->renderJson(['error' => 'Method Not Allowed']);
            return;
        }

        $this->generateResponse();
    }
}
