<?php

class FundacaoRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findByCnpj(string $cnpj): ?Fundacao
    {
        $stmt = $this->connection->prepare("SELECT * FROM fundacoes WHERE cnpj = :cnpj");
        $stmt->execute(['cnpj' => $cnpj]);
        $data = $stmt->fetch();

        if ($data) {
            $fundacao = new Fundacao(
                $data['nome'],
                $data['cnpj'],
                $data['email'],
                $data['telefone'],
                $data['instituicao_apoiada']
            );
            $fundacao->id = $data['id'];
            return $fundacao;
        }

        return null;
    }

    public function save(Fundacao $fundacao): bool
    {
        if (is_null($fundacao->id)) {
            $sql = "INSERT INTO fundacoes (nome, cnpj, email, telefone, instituicao_apoiada) 
                    VALUES (:nome, :cnpj, :email, :telefone, :instituicao_apoiada)";
            $stmt = $this->connection->prepare($sql);
        } else {
            $sql = "UPDATE fundacoes SET nome = :nome, cnpj = :cnpj, email = :email, 
                    telefone = :telefone, instituicao_apoiada = :instituicao_apoiada 
                    WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $fundacao->id, PDO::PARAM_INT);
        }

        $stmt->bindValue(':nome', $fundacao->nome);
        $stmt->bindValue(':cnpj', $fundacao->cnpj);
        $stmt->bindValue(':email', $fundacao->email);
        $stmt->bindValue(':telefone', $fundacao->telefone);
        $stmt->bindValue(':instituicao_apoiada', $fundacao->instituicao_apoiada);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM fundacoes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}