<?php
// arquivo para constantes genéricas do sistema (alterar conforme a necessidade)
namespace Util;

abstract class ConstantesGenericasUtil
{
    /* REQUESTS */
    public const TIPO_REQUEST = ['GET', 'POST', 'DELETE', 'PUT'];
    public const TIPO_GET = ['system_user']; //Aqui eu adiciono as tabelas que aceitam requisições do tipo GET
    public const TIPO_POST = ['USUARIOS'];
    public const TIPO_DELETE = ['USUARIOS'];
    public const TIPO_PUT = ['USUARIOS'];

    /* ERROS */
    public const MSG_ERRO_TIPO_ROTA = 'Rota não permitida!';
    public const MSG_ERRO_RECURSO_INEXISTENTE = 'Recurso inexistente!';
    public const MSG_ERRO_GENERICO = 'Algum erro ocorreu na requisição!';
    public const MSG_ERRO_SEM_RETORNO = 'Nenhum registro encontrado!';
    public const MSG_ERRO_NAO_AFETADO = 'Nenhum registro afetado!';
    public const MSG_ERRO_USER_VAZIO = 'É necessário informar um Token!';
    public const MSG_ERRO_USER_NAO_AUTORIZADO = 'USER não autorizado!';
    public const MSG_ERR0_JSON_VAZIO = 'O Corpo da requisição não pode ser vazio!';

    /* SUCESSO */
    public const MSG_DELETADO_SUCESSO = 'Registro deletado com Sucesso!';
    public const MSG_ATUALIZADO_SUCESSO = 'Registro atualizado com Sucesso!';

    /* RECURSO USUARIOS */
    public const MSG_ERRO_ID_OBRIGATORIO = 'ID é obrigatório!';
    public const MSG_ERRO_LOGIN_EXISTENTE = 'Login já existente!';
    public const MSG_ERRO_LOGIN_SENHA_OBRIGATORIO = 'Login e Senha são obrigatórios!';

    /* RETORNO JSON */
    const TIPO_SUCESSO = 'sucesso';
    const TIPO_ERRO = 'erro';

    /* OUTRAS */
    public const SIM = 'S';
    public const TIPO = 'tipo';
    public const RESPOSTA = 'resposta';
}