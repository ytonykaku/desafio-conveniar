<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('ROOT', dirname(__DIR__) . '/');

use Src\Controllers\FundacaoController;
use Src\Services\Database;

try {
    $db = Database::getInstance();
    $connection = $db->getConnection();
    $controller = new FundacaoController($connection);
} catch (Exception $e) {
    die('Erro de conexão com o banco de dados: ' . $e->getMessage());
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        $controller->index();
        break;
    
    case '/fundacoes/cadastrar':
        $controller->create();
        break;

    case '/fundacoes/salvar':
        $controller->store();
        break;

    case '/fundacoes/listar':
        $controller->list();
        break;

    case '/fundacoes/deletar':
        $controller->destroy();
        break;
    
    case '/fundacoes/atualizar':
        $controller->update();
        break;
    
    case '/fundacoes/buscar':
        $controller->find();
        break;

    default:
        http_response_code(404);
        echo "404 - Página não encontrada";
        break;
}