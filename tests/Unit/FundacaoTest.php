<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Models\Fundacao;

class FundacaoTest extends TestCase
{
    public function it_can_be_instantiated_with_required_properties()
    {
        $fundacao = new Fundacao(
            'Fundação Teste',
            '12.345.678/0001-99',
            'Instituição Apoiada Teste'
        );

        $this->assertInstanceOf(Fundacao::class, $fundacao);
        $this->assertEquals('Fundação Teste', $fundacao->nome);
        $this->assertEquals('12.345.678/0001-99', $fundacao->cnpj);
        $this->assertEquals('Instituição Apoiada Teste', $fundacao->instituicao_apoiada);
        $this->assertNull($fundacao->email);
        $this->assertNull($fundacao->telefone);
    }

    public function it_can_be_instantiated_with_all_properties()
    {
        $fundacao = new Fundacao(
            'Fundação Completa',
            '99.888.777/0001-66',
            'Instituição Completa',
            'contato@completo.com',
            '(31) 98765-4321'
        );

        $this->assertEquals('Fundação Completa', $fundacao->nome);
        $this->assertEquals('contato@completo.com', $fundacao->email);
        $this->assertEquals('(31) 98765-4321', $fundacao->telefone);
    }
}