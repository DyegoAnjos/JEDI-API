<?php

namespace Repository;

use DB\MySQL;

class SystemUserRepository
{
    private object $MySQL;
    public const TABELA = 'system_user';

    public function __construct(){
        $this->MySQL = new MySQL();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }

    public function validarAcesso($login, $senha)
    {
        // Adicionado espaços na query
        $consulta = 'SELECT active FROM ' . self::TABELA . ' WHERE email = :email AND password = :password';

        // Corrigido para usar a instância correta do banco de dados
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':email', $login);
        $stmt->bindParam(':password', $senha);
        $stmt->execute();

        $resultado = $stmt->fetch();

        // Retorna o valor da coluna 'active' ou null se não houver registro
        return $resultado ? $resultado['active'] : null;
    }
}