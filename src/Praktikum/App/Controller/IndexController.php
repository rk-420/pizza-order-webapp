<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';
require_once 'App/Model/ExampleModel.php';

class IndexController extends BaseController {
    /**
     * Process incoming HTTP request data (GET, POST, etc.).
     *
     * @return void
     */
    public function processData(): void {
         /**
        * Example usage 
        * $model = new ExampleModel();
        * $data = $model->create();
        * $data = $model->update();
        */
    }

    /**
     * Retrieve all data necessary for the response.
     *
     * @return array Data array (associative or indexed) to be used in generateResponse
     */
    private function getData(): array {
        /**
        * Demo placeholder:
        * The returned array is only sample data for teaching purposes.
        * Replace it with real model data in your own project.
        *
        * Example usage with a model:
        * $model = new ExampleModel();
        * $data = $model->getAll();
        * $data = $model->getById();
        */
        $data = ['example_string' => 'Lorem ipsum dolor sit amet', 'example_int' => 42, 'example_array' => [1, 2]];
        return $data;
    }

    /**
     * Generate the full response output.
     * This method may output HTML, JSON, or other formats as needed.
     *
     * @return void
     */
    public function generateResponse(): void {
        $data = $this->getData();
        $this->renderHtml('App/View/index.view.php', ['data' => $data]);
    }

    /**
     * Handles the full request lifecycle
     *
     * @return void
     */
    public function handleRequest(): void {
        $this->processData();
        $this->generateResponse();
    }
}
