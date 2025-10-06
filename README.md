# Desafio Técnico Conveniar

Desafio técnico do processo seletivo da **Conveniar**. Consiste em um sistema de **CRUD (Cadastro, Consulta, Alteração e Exclusão)** para gerenciar **Fundações de Apoio**, construído em **PHP puro**.

---

### ✅ Requisitos Obrigatórios

* **Funcionamento Correto**: A aplicação implementa todas as funcionalidades solicitadas:

  * CRUD completo para Fundações de Apoio.
  * Validação que impede o cadastro de CNPJs duplicados.
  * Exibição de mensagens de sucesso e erro ao usuário.
  * Busca de registros por CNPJ.

* **Arquitetura da Aplicação**:

  * A aplicação segue o padrão **MVC (Model-View-Controller)**.
  * **Repository Pattern**, isolando a lógica de acesso ao banco de dados.

  * Estrutura organizada em **Controllers, Models, Repositories, Services, Views**.
  * Responsabilidades bem definidas e código de fácil leitura.

* **Boas Práticas de Desenvolvimento**:

  * **Segurança**: uso de **prepared statements (PDO)** contra SQL Injection; variáveis sensíveis fora do versionamento (.env).
  * **Experiência do Usuário (UX)**: operações de CRUD via **AJAX**, sem recarregamento de página, com feedback em **modais (SweetAlert2)**.
  * **Interface Amigável**: construída com **Tailwind CSS**, responsiva, limpa e moderna.

### ⭐ Requisitos Bônus

* **Padrões Arquiteturais e de Projeto**:

  * **MVC, Repository Pattern, Singleton** (para conexão com o banco) e **Front Controller** (centralizando requisições no `index.php`).

* **Testes Automatizados**:

  * Suíte de testes com **PHPUnit**.
  * **Testes de Unidade** (Model Fundacao).
  * **Testes de Funcionalidade** (validações no FundacaoController).

* **Gerenciador de Pacotes**:

  * Uso do **Composer** para dependências (phpdotenv, phpunit).

* **Banco de Dados Relacional**:

  * Utiliza **PostgreSQL**, robusto e confiável.

---

## 🚀 Como Executar o Projeto com Docker

Certifique-se de ter o **Docker** e o **Docker Compose** instalados e rodando na sua máquina.

### 1. Clone o Repositório

```bash
git clone git@github.com:ytonykaku/desafio-conveniar.git
cd desafio-conveniar
```

### 2. Configure o Ambiente

```bash
cp .env.example .env
```

As credenciais padrão já estão configuradas para funcionar com o Docker.

### 3. Inicie os Contêineres

```bash
docker-compose up -d --build
```

Na primeira execução, o banco de dados e a tabela `fundacoes` serão criados automaticamente.

### 4. Instale as Dependências do Composer

```bash
docker-compose exec php composer install
```

### 5. Acesse a Aplicação

Abra no navegador:

```
http://localhost:8000
```

---

## 🧪 Como Executar os Testes Automatizados

Com os contêineres em execução, rode o comando:

```bash
docker-compose exec php ./vendor/bin/phpunit
```

---
