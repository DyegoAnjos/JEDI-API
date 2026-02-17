<?php
// arquivo para constantes genéricas do sistema (alterar conforme a necessidade)
namespace Util;

abstract class ConstantesGenericasUtil
{
    /* REQUESTS */
    public const TIPO_REQUEST = ['GET', 'POST', 'DELETE', 'PUT'];
    public const TIPO_GET = ['PARTIDASPERGUNTAS']; //Aqui eu adiciono as tabelas que aceitam requisições do tipo GET
    public const TIPO_POST = ['SYSTEM_USER', 'PARTIDASPERGUNTAS'];
    public const TIPO_DELETE = [''];
    public const TIPO_PUT = [''];

    /* ERROS */
    public const MSG_ERRO_TIPO_ROTA = 'Rota não permitida!';
    public const MSG_ERRO_RECURSO_INEXISTENTE = 'Recurso inexistente!';
    public const MSG_ERRO_GENERICO = 'Algum erro ocorreu na requisição!';
    public const MSG_ERRO_SEM_RETORNO = 'Nenhum registro encontrado!';
    public const MSG_ERRO_NAO_AFETADO = 'Nenhum registro afetado!';
    public const MSG_ERRO_USER_VAZIO = 'É necessário informar um Usuário!';
    public const MSG_ERRO_USER_NAO_AUTORIZADO = 'Usuário não autorizado!';
    public const MSG_ERRO_USER_NAO_REGISTRADO = 'Usuário não registrado!';
    public const MSG_ERRO_JSON_VAZIO = 'O Corpo da requisição não pode ser vazio!';

    /* SUCESSO */
    public const MSG_DELETADO_SUCESSO = 'Registro deletado com Sucesso!';
    public const MSG_ATUALIZADO_SUCESSO = 'Registro atualizado com Sucesso!';

    /* RECURSO USUARIOS */
    public const MSG_ERRO_ID_OBRIGATORIO = 'ID é obrigatório!';
    public const MSG_ERRO_LOGIN_EXISTENTE = 'Login já existente!';
    public const MSG_ERRO_LOGIN_SENHA_OBRIGATORIO = 'Login e Senha são obrigatórios!';

    /* RECURSOS RANKING */
    public const MSG_ERRO_RANKING_SEM_REGISTRO = 'Tema sem registo!';

    public const MSG_ERRO_ID_TEMA_OBRIGATORIO = 'O ID do tema é obrigatório!';

    /* RETORNO JSON */
    const TIPO_SUCESSO = 'sucesso';
    const TIPO_ERRO = 'erro';

    /* OUTRAS */
    public const SIM = 'S';
    public const TIPO = 'tipo';
    public const RESPOSTA = 'resposta';
}