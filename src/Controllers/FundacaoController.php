<?php

class FundacaoController extends BaseController
{
    private FundacaoRepository $fundacaoRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->fundacaoRepository = new FundacaoRepository($connection);
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
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
            exit;
        }

        $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']);

        if (strlen($cnpj) !== 14) {
            echo json_encode(['success' => false, 'message' => 'O CNPJ fornecido é inválido.']);
            exit;
        }

        $fundacaoExistente = $this->fundacaoRepository->findByCnpj($cnpj);
        
        if ($fundacaoExistente) {
            echo json_encode(['success' => false, 'message' => 'Este CNPJ já foi cadastrado.']);
            exit;
        }

        $fundacao = new Fundacao(
            trim($_POST['nome']),
            $cnpj,
            trim($_POST['email']),
            trim($_POST['telefone']),
            trim($_POST['instituicao_apoiada'])
        );

        if ($this->fundacaoRepository->save($fundacao)) {
            $fundacao->id = $this->connection->lastInsertId();
            
            echo json_encode(['success' => true, 'fundacao' => $fundacao]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao salvar no banco de dados.']);
        }
        exit;
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
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
            exit;
        }
        
        $id = $_POST['id'] ?? null;
        $cnpj = trim($_POST['cnpj']);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
            exit;
        }

        $fundacaoExistente = $this->fundacaoRepository->findByCnpj($cnpj);
        if ($fundacaoExistente && $fundacaoExistente->id != $id) {
            echo json_encode(['success' => false, 'message' => 'Este CNPJ já pertence a outro cadastro.']);
            exit;
        }

        $fundacao = $this->fundacaoRepository->findById((int)$id);
        if (!$fundacao) {
            echo json_encode(['success' => false, 'message' => 'Fundação não encontrada.']);
            exit;
        }
        
        $fundacao->nome = trim($_POST['nome']);
        $fundacao->cnpj = $cnpj;
        $fundacao->email = trim($_POST['email']);
        $fundacao->telefone = trim($_POST['telefone']);
        $fundacao->instituicao_apoiada = trim($_POST['instituicao_apoiada']);

        if ($this->fundacaoRepository->save($fundacao)) {
            echo json_encode(['success' => true, 'fundacao' => $fundacao]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a fundação.']);
        }
        exit;
    }

    public function destroy()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
            exit;
        }

        if ($this->fundacaoRepository->delete((int)$id)) {
            echo json_encode(['success' => true, 'message' => 'Fundação deletada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar a fundação.']);
        }
        exit;
    }
}