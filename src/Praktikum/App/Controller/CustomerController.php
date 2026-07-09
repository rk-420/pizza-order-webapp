<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';

class CustomerController extends BaseController
{
    public function processData(): void {}

    public function generateResponse(): void
    {
        // The customer page is fully client-side rendered via customer.js + /api.
        // No server-side order data is needed here.
        $this->renderHtml('App/View/customer.view.php');
    }

    public function handleRequest(): void
    {
        $this->requireRole('customer');
        $this->processData();
        $this->generateResponse();
    }
}
