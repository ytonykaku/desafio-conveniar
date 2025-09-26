<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__DIR__) . '/');

require_once ROOT . 'src/Services/Database.php';
require_once ROOT . 'src/Models/Fundacao.php';
require_once ROOT . 'src/Repositories/FundacaoRepository.php';
require_once ROOT . 'src/Controllers/BaseController.php';
require_once ROOT . 'src/Controllers/FundacaoController.php';
require_once ROOT . 'src/helpers.php';

function loadEnvFile(string $path): void
{
    if (!file_exists($path)) {
        throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

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
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            echo '<div style="background-color: #d4edda; color: #155724; padding: 1rem; border: 1px solid #c3e6cb; border-radius: .25rem; margin-bottom: 1rem;">Cadastro efetuado com sucesso!</div>';
        }
        echo '<h1>Página Inicial</h1><a href="/fundacoes/cadastrar">Cadastrar Nova Fundação</a>';
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

    default:
        http_response_code(404);
        echo "404 - Página não encontrada";
        break;
}