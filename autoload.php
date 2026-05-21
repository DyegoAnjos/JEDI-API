<?php

spl_autoload_register(function ($classe) {
    // 1. Remove barras invertidas iniciais
    $classe = ltrim($classe, '\\');

    // 2. Tenta o caminho direto (caso venha completo: Classes\DB\MySQL)
    $caminhoDireto = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classe) . '.php';

    // 3. Tenta o caminho relativo (caso venha curto: DB\MySQL ou Util\RotasUtil)
    $caminhoRelativo = __DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classe) . '.php';

    // Executa a inclusão baseada no ficheiro real encontrado no disco
    if (file_exists($caminhoDireto)) {
        require_once $caminhoDireto;
    } elseif (file_exists($caminhoRelativo)) {
        require_once $caminhoRelativo;
    }
});