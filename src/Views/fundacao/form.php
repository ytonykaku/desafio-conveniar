<div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">
            Cadastro de Fundação
        </h1>

        <form action="/fundacoes/salvar" method="POST">
            <?php
            $fields = [
                ['type' => 'text', 'name' => 'nome', 'label' => 'Nome da Fundação', 'required' => true],
                ['type' => 'text', 'name' => 'cnpj', 'label' => 'CNPJ', 'required' => true],
                ['type' => 'email', 'name' => 'email', 'label' => 'E-mail', 'required' => true],
                ['type' => 'tel', 'name' => 'telefone', 'label' => 'Telefone', 'required' => false],
                ['type' => 'text', 'name' => 'instituicao_apoiada', 'label' => 'Instituição Apoiada', 'required' => false],
            ];

            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $label = $field['label'];
                $required = $field['required'];
                require ROOT . '/src/Views/components/input_field.php';
            }
            ?>

            <div class="text-center mt-6">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    documento.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const message = urlParams.get('message');

        if (status === 'error') {
            let errorMessage = 'Ocorreu um erro ao cadastrar a fundação.';
            if (message === 'cnpj_duplicado') {
                errorMessage = 'Erro: O CNPJ informado já está cadastrado.';
            }
            const errorDiv = document.createElement('div');
            errorDiv.style.backgroundColor = '#f8d7da';
            errorDiv.style.color = '#721c24';
            errorDiv.style.padding = '1rem';
            errorDiv.style.border = '1px solid #f5c6cb';
            errorDiv.style.borderRadius = '.25rem';
            errorDiv.style.marginBottom = '1rem';
            errorDiv.textContent = errorMessage;

            const formContainer = document.querySelector('.bg-white');
            formContainer.insertBefore(errorDiv, formContainer.firstChild);
        }
    });
</script>