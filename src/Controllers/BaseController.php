<?php
namespace Src\Controllers;

use PDO;

abstract class BaseController
{
    protected PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    protected function view(string $viewPath, array $data = []): void
    {
        $data['currentUri'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        extract($data);

        require_once ROOT . '/src/Views/layouts/header.php';
        require_once ROOT . '/src/Views/' . $viewPath . '.php';
        require_once ROOT . '/src/Views/layouts/footer.php';
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}