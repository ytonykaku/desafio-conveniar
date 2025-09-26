<div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">
            Cadastro de Fundação
        </h1>

        <form action="/fundacoes/salvar" method="POST">
            <?php
            $fields = [
                ['type' => 'text', 'name' => 'nome', 'label' => 'Nome da Fundação', 'required' => true],
                ['type' => 'text', 'name' => 'cnpj', 'label' => 'CNPJ', 'required' => true, 'mask' => '00.000.000/\0\0\01-00'],
                ['type' => 'email', 'name' => 'email', 'label' => 'E-mail', 'required' => false],
                ['type' => 'tel', 'name' => 'telefone', 'label' => 'Telefone', 'required' => false, 'mask' => '(00) 00000-0000'],
                ['type' => 'text', 'name' => 'instituicao_apoiada', 'label' => 'Instituição Apoiada', 'required' => true],
            ];

            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $label = $field['label'];
                $required = $field['required'];
                $mask = $field['mask'] ?? null;
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch('/fundacoes/salvar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Sucesso!',
                        html: `
                            Fundação de Apoio cadastrada com sucesso.<br><br>
                            <strong>Nome:</strong> ${data.fundacao.nome}<br>
                            <strong>CNPJ:</strong> ${data.fundacao.cnpj}<br>
                            <strong>Instituição apoiada:</strong> ${data.fundacao.instituicao_apoiada}
                        `,
                        icon: 'success',
                        confirmButtonText: 'Ótimo!'
                    });
                    form.reset();
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao enviar o formulário:', error);
                Swal.fire({
                    title: 'Ops!',
                    text: 'Ocorreu um erro. Tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script>