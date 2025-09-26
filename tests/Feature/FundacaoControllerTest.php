<?php
namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Src\Controllers\FundacaoController;
use Src\Services\Database;

class FundacaoControllerTest extends TestCase
{
    private $connection;
    private $controller;

    protected function setUp(): void
    {
        $reflection = new \ReflectionClass(Database::class);
        $instance = $reflection->getProperty('instance');
        $instance->setAccessible(true);
        $instance->setValue(null, null);

        $db = Database::getInstance();
        $this->connection = $db->getConnection();
        $this->controller = new FundacaoController($this->connection);
    }
    
    public function it_returns_an_error_if_cnpj_is_invalid()
    {
        $_POST = [
            'nome' => 'Fundação com CNPJ Inválido',
            'cnpj' => '123',
            'instituicao_apoiada' => 'Teste',
            'email' => 'invalido@teste.com'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        $this->controller->store();
        $output = ob_get_clean();
        
        $response = json_decode($output, true);
        
        $this->assertFalse($response['success']);
        $this->assertEquals('O CNPJ fornecido é inválido.', $response['message']);
    }

    public function it_returns_an_error_if_cnpj_is_duplicated()
    {
        $_POST = [
            'nome' => 'Primeira Fundação',
            'cnpj' => '11.222.333/0001-44',
            'instituicao_apoiada' => 'Teste',
            'email' => 'primeira@teste.com'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        ob_start();
        $this->controller->store();
        ob_end_clean();

        ob_start();
        $this->controller->store();
        $output = ob_get_clean();

        $response = json_decode($output, true);
        
        $this->assertFalse($response['success']);
        $this->assertEquals('Este CNPJ já foi cadastrado.', $response['message']);
    }
}