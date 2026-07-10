<?php

namespace Util;

// Garanta que a importação está correta
use Util\ConstantesGenericasUtil;

class JsonUtil
{

    /**
     * @return array
     * @throws \Exception
     */
    public function tratarCorpoRequestJson()
    {
        try {
            $postJson = json_decode(file_get_contents('php://input'), true);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao tratar o corpo da requisição: " . $e->getMessage());
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }

        return [];
    }

    public static function processarConteudoSaida($dados)
    {
        // Adiciona os Headers necessários para o CORS
        $origem = $_SERVER['HTTP_ORIGIN'] ?? '*';
        header("Access-Control-Allow-Origin: $origem");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        echo json_encode($dados);
        exit;
    }

    /**
     * @param $retorno
     * @return void
     */
    public function processarArrayParaRetornar($retorno)
    {
        $dados = [];
        $dados = $retorno;

        $this->retornarJson($dados);
    }

    /**
     * @param $json
     * @return void
     */
    private function retornarJson($json)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        echo json_encode($json);
        exit;
    }

    /**
     * Mapeia e estrutura o retorno para o endpoint "Sortear Perguntas"
     * * @param array $dadosBanco Array ou matriz vinda do Repository/Banco de dados
     * @return array Formato JSON estruturado para o sorteio de perguntas
     */
    public static function formatarSortearPerguntas(array $dadosBanco): array
    {
        // Se for um registro único isolado, transforma em matriz para padronizar o loop
        $lista = isset($dadosBanco['id']) || isset($dadosBanco['idtema']) ? [$dadosBanco] : $dadosBanco;
        $resultado = [];

        foreach ($lista as $linha) {
            $resultado[] = [
                "idtema"           => isset($linha['idtema']) ? (int)$linha['idtema'] : null,
                "id"               => isset($linha['id']) ? (int)$linha['id'] : null,
                "pergunta"         => $linha['pergunta'] ?? "",
                "respcerta"        => $linha['respcerta'] ?? "",
                "resp2"            => $linha['resp2'] ?? "",
                "resp3"            => $linha['resp3'] ?? "",
                "resp4"            => $linha['resp4'] ?? "",
                "caminhoimagem"    => $linha['caminhoimagem'] ?? "",
                "caract_proposta"  => $linha['caract_proposta'] ?? "",
                "analise_proposta" => $linha['analise_proposta'] ?? "",
                "analise_gpt"      => $linha['analise_gpt'] ?? "",
                "analise_gemini"   => $linha['analise_gemini'] ?? "",
                "origem_analise"   => $linha['origem_analise'] ?? "",
                "fala_gpt"         => $linha['fala_gpt'] ?? "",
                "fala_gemini"      => $linha['fala_gemini'] ?? "",
                "origem_fala"      => $linha['origem_fala'] ?? "",
                "fala_proposta"    => $linha['fala_proposta'] ?? "",
                "publica"          => $linha['publica'] ?? ""
            ];
        }

        return $resultado;
    }

    /**
     * Mapeia e estrutura o retorno para o endpoint "Ranking"
     * * @param array $dadosBanco Lista de registros de classificação do banco
     * @return array Lista de jogadores formatada para o Ranking
     */
    public static function formatarRanking(array $dadosBanco): array
    {
        $lista = isset($dadosBanco['idPartida']) || isset($dadosBanco['jogador']) ? [$dadosBanco] : $dadosBanco;
        $resultado = [];

        foreach ($lista as $linha) {
            $resultado[] = [
                "idPartida"         => isset($linha['idPartida']) ? (int)$linha['idPartida'] : null,
                "jogador"           => $linha['jogador'] ?? "",
                "pontuacao"         => $linha['pontuacao'] ?? "0",
                "percentualAcertos" => $linha['percentualAcertos'] ?? "0%",
                "tempoGasto"        => $linha['tempoGasto'] ?? "00:00",
                "totalPartidas"     => $linha['totalPartidas'] ?? "0",
                "posicao"           => isset($linha['posicao']) ? (int)$linha['posicao'] : null
            ];
        }

        return $resultado;
    }

    /**
     * Mapeia e estrutura o retorno para o objeto do usuário "Autenticar"
     * * @param array $usuario Dados do usuário autenticado vindos do banco
     * @return array Dados higienizados do perfil do usuário
     */
    public static function formatarAutenticar(array $usuario): array
    {
        // Como a autenticação retorna um único objeto, mapeamos diretamente
        return [
            "id"           => isset($usuario['id']) ? (int)$usuario['id'] : null,
            "name"         => $usuario['name'] ?? "",
            "login"        => $usuario['login'] ?? "",
            "email"        => $usuario['email'] ?? "",
            "frontpage_id" => isset($usuario['frontpage_id']) ? (int)$usuario['frontpage_id'] : null,
            "active"       => isset($usuario['active']) ? (int)$usuario['active'] : 0
        ];
    }

    /**
     * Mapeia e estrutura o payload completo para "Salvar Partida", incluindo o array interno de jogadas
     * * @param array $partida Dados mestre da partida
     * @param array $jogadas Lista de sub-registros/jogadas vinculadas a esta partida
     * @return array Estrutura unificada completa da partida com itens filhos
     */
    public static function formatarSalvarPartida(array $partida, array $jogadas = []): array
    {
        $jogadasFormatadas = [];

        foreach ($jogadas as $jogada) {
            $jogadasFormatadas[] = [
                "jogadaId"         => isset($jogada['jogadaId']) ? (int)$jogada['jogadaId'] : null,
                "noticiaId"        => isset($jogada['noticiaId']) ? (int)$jogada['noticiaId'] : null,
                "avaliacaoCorreta" => isset($jogada['avaliacaoCorreta']) ? (int)$jogada['avaliacaoCorreta'] : null,
                "tempoResposta"    => isset($jogada['tempoResposta']) ? (int)$jogada['tempoResposta'] : null,
                "posicaoAvatar"    => $jogada['posicaoAvatar'] ?? ""
            ];
        }

        return [
            "id"             => isset($partida['id']) ? (int)$partida['id'] : null,
            "jogadorEmail"   => $partida['jogadorEmail'] ?? "",
            "dataHoraInicio" => $partida['dataHoraInicio'] ?? date('Y-m-d H:i:s'),
            "nome"           => $partida['nome'] ?? "",
            "idade"          => isset($partida['idade']) ? (int)$partida['idade'] : null,
            "autoAvaliacao"  => $partida['autoAvaliacao'] ?? "",
            "avatar"         => $partida['avatar'] ?? "",
            "tempoGasto"     => isset($partida['tempoGasto']) ? (int)$partida['tempoGasto'] : null,
            "jogadas"        => $jogadasFormatadas
        ];
    }
}