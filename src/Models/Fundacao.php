<?php
namespace Src\Models;

class Fundacao
{
    public ?int $id = null;
    public string $nome;
    public string $cnpj;
    public ?string $email;
    public ?string $telefone;
    public string $instituicao_apoiada;

    public function __construct(
        string $nome,
        string $cnpj,
        string $instituicao_apoiada,
        ?string $email = null,
        ?string $telefone = null
    ) {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->instituicao_apoiada = $instituicao_apoiada;
        $this->email = $email;
        $this->telefone = $telefone;
    }
}