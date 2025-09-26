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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/fundacoes/cadastrar');
        }
        
        $cnpj = trim($_POST['cnpj']);
        $fundacaoExistente = $this->fundacaoRepository->findByCnpj($cnpj);
        
        if ($fundacaoExistente) {
            $this->redirect('/fundacoes/cadastrar?status=error&message=cnpj_duplicado');
        }

        $fundacao = new Fundacao(
            trim($_POST['nome']),
            $cnpj,
            trim($_POST['email']),
            trim($_POST['telefone']),
            trim($_POST['instituicao_apoiada'])
        );

        if ($this->fundacaoRepository->save($fundacao)) {
            $this->redirect('/?status=success');
        } else {
            $this->redirect('/fundacoes/cadastrar?status=error');
        }
    }
}