<?php
declare(strict_types=1);

class Router
{
    /**
     * Returns the current route from the URL.
     * Example: "/index" -> "index"
     */
    public function getRoute(): string
    {
        return trim((string)($_GET['url'] ?? ''), '/');
    }

    /**
     * Creates a clean URL inside this project.
     * Example: Router::generateUrl('index') -> ".../index"
     */
    public static function generateUrl(string $path = ''): string
    {
        $base = rtrim(dirname((string)$_SERVER['SCRIPT_NAME']), '/');
        $path = ltrim($path, '/');
        return $path === '' ? $base . '/' : $base . '/' . $path;
    }
}
