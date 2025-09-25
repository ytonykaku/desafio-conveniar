<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulário de Fundação</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen py-12">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-wl-lg">
            <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">
                Cadastro de Fundação
            </h1>
            <form action="fundacoes/salvar" method="POST">
                <?php
                $type = 'text';
                $name = 'nome';
                $label = 'Nome da Fundação';
                $required = true;
                require ROOT . 'src/Views/components/input_field.php';
                
                $type = 'text';
                $name = 'cnpj';
                $label = 'CNPJ';
                $required = true;
                require ROOT . 'src/Views/components/input_field.php';

                $type = 'email';
                $name = 'email';
                $label = 'E-mail';
                $required = true;
                require ROOT . 'src/Views/components/input_field.php';

                $type = 'tel';
                $name = 'telefone';
                $label = 'Telefone';
                $required = false;
                require ROOT . 'src/Views/components/input_field.php';

                $type = 'text';
                $name = 'instituicao_apoiada';
                $label = 'Instituição Apoiada';
                $required = false;
                require ROOT . 'src/Views/components/input_field.php';
                ?>

                <div class="text-center mt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>