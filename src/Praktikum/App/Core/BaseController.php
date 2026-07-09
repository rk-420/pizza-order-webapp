<?php
declare(strict_types=1);

require_once 'App/Core/Router.php';

/**
 * Abstract BaseController class providing common methods for all controllers.
 *
 * This class offers utility functions to:
 * - Render HTML views by extracting data variables and including the view file.
 * - Return JSON responses with proper headers and formatting.
 * - Guard controllers so only the correct logged-in role can reach them.
 *
 * Controllers extending this base class can use these methods to simplify response handling.
 */
abstract class BaseController
{
    /**
     * Access-control guard: call as the first line of handleRequest() in any
     * controller that must be restricted to specific roles.
     *
     * Not logged in -> redirect to the login page.
     * Logged in with the wrong role -> 403.
     *
     * @param string ...$roles One or more of UserModel::ROLES.
     */
    protected function requireRole(string ...$roles): void
    {
        $currentRole = $_SESSION['role'] ?? null;

        if ($currentRole === null) {
            header('Location: ' . Router::generateUrl('login'));
            exit;
        }

        if (!in_array($currentRole, $roles, true)) {
            http_response_code(403);
            header('Content-Type: text/html; charset=UTF-8');
            echo '<h1>403 &ndash; Kein Zugriff</h1><p>Diese Seite steht Ihrer Rolle nicht zur Verf&uuml;gung.</p>';
            exit;
        }
    }

    /**
     * Extract data variables and include the view file.
     *
     * @param string $viewFile Path to the PHP view file.
     * @param array $data Variables to extract and pass to the view.
     * @return void
     */
    protected function renderHtml(string $viewFile, array $viewData = []): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        extract($viewData); // Extract variables so keys become variable names in the view
        require $viewFile;
    }

    /**
     * Outputs the response as JSON.
     *
     * @param mixed $data The data to encode and return.
     * @return void
     */
    protected function renderJson(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
