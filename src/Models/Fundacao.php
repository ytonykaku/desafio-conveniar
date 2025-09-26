<?php
namespace Src\Models;

class Fundacao
{
    public ?int $id = null;
    public string $nome;
    public string $cnpj;
    public string $email;
    public ?string $telefone;
    public ?string $instituicao_apoiada;

    public function __construct(
        string $nome,
        string $cnpj,
        string $email,
        ?string $telefone = null,
        ?string $instituicao_apoiada = null
    ) {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->instituicao_apoiada = $instituicao_apoiada;
    }
}