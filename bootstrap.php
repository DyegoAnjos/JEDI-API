<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

define('HOST', 'localhost'); //Onde o banco de dados está hospedado
define('BANCO', 'jedieduca'); //Nome do banco de dados
define('USER', 'root'); //Usuário do banco de dados
define('SENHA', ''); //Senha do banco de dados

define('DS', DIRECTORY_SEPARATOR); // Dando um novo nome para o DIRECTORY_SEPARATOR (barra que separa pastas)
define('DIR_APP', __DIR__ . DS); // Diretório raiz do projeto
define('DIR_PROJETO', 'JEDI-API'); // Nome da pasta do projeto

if (file_exists('autoload.php')) {
    include 'autoload.php';
} else {
    die('Arquivo de autoload nao encontrado');
}