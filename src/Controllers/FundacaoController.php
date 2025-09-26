<?php
namespace Src\Controllers;

use PDO;
use Src\Models\Fundacao;
use Src\Repositories\FundacaoRepository;

class FundacaoController extends BaseController
{
    private FundacaoRepository $fundacaoRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->fundacaoRepository = new FundacaoRepository($connection);
    }

    protected function input(array $source, string $key, bool $required = false)
    {
        $value = $source[$key] ?? null;

        if ($required && ($value === null || trim($value) === '')) {
            return $this->jsonResponse(['success' => false, 'message' => "O campo '{$key}' é obrigatório."]);
        }

        return $value !== null ? trim($value) : null;
    }
    protected function jsonResponse(array $data)
    {
        $response = json_encode($data);

        if (PHP_SAPI === 'cli') {
            return $response;
        }

        header('Content-Type: application/json');
        echo $response;
        exit;
    }

    public function index()
    {
        $this->view('home', ['pageTitle' => 'Página Inicial']);
    }

    public function create()
    {
        $this->view('fundacao/form', ['pageTitle' => 'Cadastro de Fundação']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['success' => false, 'message' => 'Método não permitido.']);
        }

        $cnpj = preg_replace('/\D/', '', $this->input($_POST, 'cnpj', true));

        if (strlen($cnpj) !== 14) {
            return $this->jsonResponse(['success' => false, 'message' => 'O CNPJ fornecido é inválido.']);
        }

        if ($this->fundacaoRepository->findByCnpj($cnpj)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Este CNPJ já foi cadastrado.']);
        }

        $fundacao = new Fundacao(
            $this->input($_POST, 'nome', true),
            $cnpj,
            $this->input($_POST, 'instituicao_apoiada', true),
            $this->input($_POST, 'email'),
            $this->input($_POST, 'telefone')
        );

        if ($this->fundacaoRepository->save($fundacao)) {
            $fundacao->id = $this->connection->lastInsertId();
            return $this->jsonResponse(['success' => true, 'fundacao' => $fundacao]);
        }

        return $this->jsonResponse(['success' => false, 'message' => 'Ocorreu um erro ao salvar no banco de dados.']);
    }

    public function list()
    {
        $fundacoes = $this->fundacaoRepository->findAll();

        $this->view('fundacao/list', [
            'pageTitle' => 'Fundações Cadastradas',
            'fundacoes' => $fundacoes
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['success' => false, 'message' => 'Método não permitido.']);
        }

        $id = $this->input($_POST, 'id', true);
        $cnpj = $this->input($_POST, 'cnpj', true);

        $fundacaoExistente = $this->fundacaoRepository->findByCnpj($cnpj);
        if ($fundacaoExistente && $fundacaoExistente->id != $id) {
            return $this->jsonResponse(['success' => false, 'message' => 'Este CNPJ já pertence a outro cadastro.']);
        }

        $fundacao = $this->fundacaoRepository->findById((int)$id);
        if (!$fundacao) {
            return $this->jsonResponse(['success' => false, 'message' => 'Fundação não encontrada.']);
        }

        $fundacao->nome = $this->input($_POST, 'nome', true);
        $fundacao->cnpj = $cnpj;
        $fundacao->instituicao_apoiada = $this->input($_POST, 'instituicao_apoiada', true);
        $fundacao->email = $this->input($_POST, 'email');
        $fundacao->telefone = $this->input($_POST, 'telefone');

        if ($this->fundacaoRepository->save($fundacao)) {
            return $this->jsonResponse(['success' => true, 'fundacao' => $fundacao]);
        }

        return $this->jsonResponse(['success' => false, 'message' => 'Erro ao atualizar a fundação.']);
    }

    public function find()
    {
        $cnpj = $this->input($_GET, 'cnpj', true);

        $fundacao = $this->fundacaoRepository->findByCnpj($cnpj);

        if ($fundacao) {
            return $this->jsonResponse(['success' => true, 'fundacao' => $fundacao]);
        }

        return $this->jsonResponse(['success' => false, 'message' => 'Fundação não encontrada.']);
    }

    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['success' => false, 'message' => 'Método não permitido.']);
        }

        $id = $this->input($_POST, 'id', true);

        if ($this->fundacaoRepository->delete((int)$id)) {
            return $this->jsonResponse(['success' => true, 'message' => 'Fundação deletada com sucesso.']);
        }

        return $this->jsonResponse(['success' => false, 'message' => 'Erro ao deletar a fundação.']);
    }
}
