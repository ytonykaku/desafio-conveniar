<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Desafio Conveniar' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="/" class="text-white font-bold text-lg">Conveniar</a>
                        </div>
                    </div>
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                        <div class="hidden md:flex md:items-baseline md:space-x-4">
                            <?php
                                $activeClass = 'bg-gray-900 text-white';
                                $inactiveClass = 'text-gray-300 hover:bg-gray-700 hover:text-white';
                            ?>
                            <a href="/" 
                            class="<?= ($currentUri === '/') ? $activeClass : $inactiveClass ?> rounded-md px-3 py-2 text-sm font-medium">
                            Home
                            </a>
                            <a href="/fundacoes/cadastrar"
                            class="<?= ($currentUri === '/fundacoes/cadastrar') ? $activeClass : $inactiveClass ?> rounded-md px-3 py-2 text-sm font-medium">
                            Cadastrar Fundação
                            </a>
                            <a href="/fundacoes/listar"
                            class="<?= ($currentUri === '/fundacoes/listar') ? $activeClass : $inactiveClass ?> rounded-md px-3 py-2 text-sm font-medium">
                            Visualizar Apoiadores
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            </div>
                    </div>
                </div>
            </div>
        </nav>        
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">