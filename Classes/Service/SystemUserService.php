<?php

namespace Service;

use InvalidArgumentException;
use Repository\SystemUserRepository;
use Util\ConstantesGenericasUtil;

class SystemUserService
{
    private array $dados;
    private object $SystemUserRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->SystemUserRepository = new SystemUserRepository();
    }

    /**
     * @return string
     */
    function validar()
    {
        /*Método para a validação do User
        Passa o Email e a senha pela URL, e verifica se o email e a senha passados,
        Caso o active seja Y ele é permitido.
        */

        //Pega o email e a senha do request se não define como null
        $email = $this->dados['email'] ?? null;
        $password = $this->dados['password'] ?? null;

        if($email && $password){
            $resultado = $this->SystemUserRepository->validarAcesso($email, $password);

            if ($resultado === 'Y') {
                return 'Acesso permitido'; // Isso será reconhecido como sucesso pelo novo if do jsonUtil
            }
            elseif ($resultado === 'N') {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_AUTORIZADO);
            }

            else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_REGISTRADO);
            }

        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_VAZIO);
    }
}