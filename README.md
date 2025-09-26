Desafio Técnico Conveniar
Este projeto é uma solução completa para o desafio técnico do processo seletivo da Conveniar. A aplicação consiste em um sistema de CRUD (Cadastro, Consulta, Alteração e Exclusão) para gerenciar Fundações de Apoio, construído em PHP puro, seguindo as melhores práticas de desenvolvimento e arquitetura de software.

Análise do Projeto vs. Requisitos
A seguir, uma análise detalhada de como o projeto atende e supera os critérios de avaliação definidos no desafio.

Requisitos Obrigatórios
✅ Funcionamento Correto: A aplicação implementa todas as funcionalidades solicitadas:

CRUD completo para Fundações de Apoio.

Validação que impede o cadastro de CNPJs duplicados.

Exibição de mensagens de sucesso e erro ao usuário.

Busca de registros por CNPJ.

✅ Arquitetura da Aplicação: A arquitetura foi um ponto central do desenvolvimento. A aplicação segue o padrão MVC (Model-View-Controller) e foi aprimorada com a adoção do Repository Pattern, que isola completamente a lógica de acesso ao banco de dados, resultando em um código mais limpo e de fácil manutenção.

✅ Qualidade, Clareza e Organização do Código: O código foi estruturado de forma lógica e clara, com responsabilidades bem definidas em suas respectivas pastas (Controllers, Models, Repositories, Services, Views), facilitando a leitura e o entendimento.

✅ Boas Práticas de Desenvolvimento:

Segurança: Foram utilizados prepared statements (via PDO) para prevenir ataques de SQL Injection. As credenciais sensíveis são gerenciadas fora do controle de versão, em um arquivo .env.

Experiência do Usuário (UX): A interface utiliza AJAX para todas as operações de CRUD, evitando recarregamentos de página e proporcionando uma experiência de usuário moderna e fluida, com feedback através de modais (SweetAlert2).

Interface Amigável: A interface foi construída com Tailwind CSS, resultando em um visual limpo, agradável e responsivo.

Requisitos Bônus
✅ Padrões Arquiteturais e de Projeto: Foram aplicados diversos padrões, como MVC, Repository Pattern, Singleton (para a conexão com o banco de dados) e Front Controller (centralizando todas as requisições no index.php).

✅ Testes Automatizados: O projeto inclui uma suíte de testes robusta com PHPUnit, cobrindo tanto Testes de Unidade (para o Model Fundacao) quanto Testes de Funcionalidade (para as validações do FundacaoController), garantindo a confiabilidade do código.

✅ Gerenciador de Pacotes: Foi utilizado o Composer, o gerenciador de pacotes padrão do PHP, para gerenciar as dependências do projeto (phpdotenv e phpunit).

✅ Banco de Dados Relacional: A aplicação utiliza o PostgreSQL, um sistema de banco de dados relacional robusto e confiável.

🚀 Como Executar o Projeto com Docker
Certifique-se de ter o Docker e o Docker Compose instalados e rodando na sua máquina.

1. Clone o Repositório

git clone <url-do-seu-repositorio>
cd desafio-conveniar

2. Configure o Ambiente
Copie o arquivo de exemplo .env.example para .env. As credenciais padrão já estão configuradas para funcionar com o Docker.

cp .env.example .env

3. Inicie os Contêineres
Este comando irá construir e iniciar os serviços de Nginx, PHP e PostgreSQL. Na primeira execução, o banco de dados e a tabela fundacoes serão criados e configurados automaticamente.

docker-compose up -d --build

4. Instale as Dependências do Composer
Execute o composer install dentro do contêiner PHP para instalar as bibliotecas necessárias.

docker-compose exec php composer install

5. Acesse a Aplicação
Abra seu navegador e acesse: http://localhost:8000

🧪 Como Executar os Testes Automatizados
Com os contêineres em execução, rode o seguinte comando no terminal, na raiz do projeto:

docker-compose exec php ./vendor/bin/phpunit
