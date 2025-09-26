<div class="bg-white p-8 rounded-lg shadow-md w-full">
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Buscar por CNPJ</h2>
        <form id="search-form" class="flex items-center space-x-4">
            <div class="flex-grow">
                <label for="cnpj-busca" class="sr-only">CNPJ</label>
                <input type="text" id="cnpj-busca" name="cnpj" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       placeholder="Digite o CNPJ"
                       data-mask="00.000.000/0000-00">
            </div>
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-700">
                Buscar
            </button>
        </form>
    </div>
    <?php if (empty($fundacoes)): ?>
        <div class="text-center text-gray-500">
            <p>Nenhuma fundação cadastrada ainda.</p>
            <a href="/fundacoes/cadastrar" class="mt-4 inline-block text-blue-500 hover:underline">Cadastrar a primeira</a>
        </div>
    <?php else: ?>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($fundacoes as $fundacao): ?>
                    <tr id="fundacao-row-<?= $fundacao->id ?>">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($fundacao->nome) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($fundacao->cnpj) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($fundacao->email) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button 
                                data-id="<?= $fundacao->id ?>"
                                data-nome="<?= htmlspecialchars($fundacao->nome) ?>"
                                data-cnpj="<?= htmlspecialchars($fundacao->cnpj) ?>"
                                data-email="<?= htmlspecialchars($fundacao->email) ?>"
                                data-telefone="<?= htmlspecialchars($fundacao->telefone ?? '') ?>"
                                data-instituicao_apoiada="<?= htmlspecialchars($fundacao->instituicao_apoiada ?? '') ?>"
                                class="text-indigo-600 hover:text-indigo-900 btn-edit">
                                Editar
                            </button>
                            <button data-id="<?= $fundacao->id ?>" data-nome="<?= htmlspecialchars($fundacao->nome) ?>" class="text-red-600 hover:text-red-900 ml-4 btn-delete">Deletar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
document.addEventListener('click', function(event) {
    
    if (event.target.matches('.btn-delete')) {
        const fundacaoId = event.target.dataset.id;
        const fundacaoNome = event.target.dataset.nome;

        Swal.fire({
            title: 'Você tem certeza?',
            text: `Você está prestes a deletar a fundação "${fundacaoNome}". Esta ação não pode ser desfeita!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', fundacaoId);

                fetch('/fundacoes/deletar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deletado!',
                            'A fundação foi deletada com sucesso.',
                            'success'
                        );
                        
                        const tableRow = document.getElementById('fundacao-row-' + fundacaoId);
                        if (tableRow) {
                            tableRow.remove();
                        }
                    } else {
                        Swal.fire(
                            'Erro!',
                            data.message,
                            'error'
                        );
                    }
                });
            }
        });
    }

    if (event.target.matches('.btn-edit')) {
        const button = event.target;
        const data = button.dataset;

        Swal.fire({
            title: 'Editar Fundação',
            html: `
                <form id="edit-form" class="text-left">
                    <input type="hidden" name="id" value="${data.id}">
                    <div class="mb-4">
                        <label for="swal-nome" class="block font-semibold">Nome</label>
                        <input id="swal-nome" name="nome" class="swal2-input" value="${data.nome}" required>
                    </div>
                    <div class="mb-4">
                        <label for="swal-cnpj" class="block font-semibold">CNPJ</label>
                        <input id="swal-cnpj" name="cnpj" class="swal2-input" value="${data.cnpj}" required>
                    </div>
                    <div class="mb-4">
                        <label for="swal-email" class="block font-semibold">E-mail</label>
                        <input id="swal-email" name="email" class="swal2-input" value="${data.email}" required>
                    </div>
                    <div class="mb-4">
                        <label for="swal-telefone" class="block font-semibold">Telefone</label>
                        <input id="swal-telefone" name="telefone" class="swal2-input" value="${data.telefone}">
                    </div>
                    <div>
                        <label for="swal-instituicao" class="block font-semibold">Instituição Apoiada</label>
                        <input id="swal-instituicao" name="instituicao_apoiada" class="swal2-input" value="${data.instituicao_apoiada}">
                    </div>
                </form>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Salvar Alterações',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const form = document.getElementById('edit-form');
                return new FormData(form);
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = result.value;
                
                fetch('/fundacoes/atualizar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Atualizado!', 'Os dados foram atualizados com sucesso.', 'success');
                        
                        const row = document.getElementById('fundacao-row-' + data.fundacao.id);
                        if (row) {
                            row.cells[0].textContent = data.fundacao.nome;
                            row.cells[1].textContent = data.fundacao.cnpj;
                            row.cells[2].textContent = data.fundacao.email;
                            
                            const editButton = row.querySelector('.btn-edit');
                            editButton.dataset.nome = data.fundacao.nome;
                            editButton.dataset.cnpj = data.fundacao.cnpj;
                            editButton.dataset.email = data.fundacao.email;
                            editButton.dataset.telefone = data.fundacao.telefone;
                            editButton.dataset.instituicao_apoiada = data.fundacao.instituicao_apoiada;
                        }
                    } else {
                        Swal.fire('Erro!', data.message, 'error');
                    }
                });
            }
        });
    }
});

const searchForm = document.getElementById('search-form');
if (searchForm) {
    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const cnpjInput = document.getElementById('cnpj-busca');
        const cnpj = cnpjInput.value;

        if (!cnpj) {
            Swal.fire('Atenção!', 'Por favor, digite um CNPJ para buscar.', 'warning');
            return;
        }

        fetch(`/fundacoes/buscar?cnpj=${encodeURIComponent(cnpj)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const fundacao = data.fundacao;
                    Swal.fire({
                        title: 'Fundação Encontrada!',
                        icon: 'success',
                        html: `
                            <div class="text-left p-4">
                                <p><strong>ID:</strong> ${fundacao.id}</p>
                                <p><strong>Nome:</strong> ${fundacao.nome}</p>
                                <p><strong>CNPJ:</strong> ${fundacao.cnpj}</p>
                                <p><strong>E-mail:</strong> ${fundacao.email}</p>
                                <p><strong>Telefone:</strong> ${fundacao.telefone || 'Não informado'}</p>
                                <p><strong>Instituição Apoiada:</strong> ${fundacao.instituicao_apoiada || 'Não informado'}</p>
                            </div>
                        `
                    });
                } else {
                    Swal.fire({
                        title: 'Não encontrado',
                        text: data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Erro na busca:', error);
                Swal.fire('Ops!', 'Ocorreu um erro na busca. Tente novamente.', 'error');
            });
    });
}
</script>