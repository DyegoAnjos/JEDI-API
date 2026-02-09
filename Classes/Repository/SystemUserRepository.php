<?php

namespace Repository;

use DB\MySQL;

class SystemUserRepository
{
    //Classe responsável por executar as requisições ao banco de dados
    private object $MySQL;
    public const TABELA = 'system_user';

    public function __construct(){
        $this->MySQL = new MySQL();
    }

    /**
     * @return MySQL|object
     */
    public function getMySQL()
    {
        return $this->MySQL;
    }

    /**
     * @param $email
     * @param $password
     * @return mixed|null
     */
    public function validarAcesso($email, $password)
    {
        //Função que executa a validação do user
        $consulta = 'SELECT active FROM ' . self::TABELA . ' WHERE email = :email AND password = :password';

        // Corrigido para usar a instância correta do banco de dados
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $resultado = $stmt->fetch();

        // Retorna o valor da coluna 'active' ou null se não houver registro
        return $resultado ? $resultado['active'] : null;
    }
}