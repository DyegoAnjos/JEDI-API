<?php

function autoload($classe)
{
    $diretorioBase = rtrim(DIR_APP, DS) . DS;
    $caminhoFinal = $diretorioBase . 'Classes' . DS . str_replace('\\', DS, $classe) . '.php';


    if (file_exists($caminhoFinal) && !is_dir($caminhoFinal)) {
        include_once $caminhoFinal;
    }
}

spl_autoload_register('autoload');