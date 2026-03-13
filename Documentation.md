# JEDI-API

Descrição

## System User

### Autenticar

Recurso responsável por verificar se um usuário existe e está ativo.

[POST] https://memore-net.com/api/JEDI-API/system_user/autenticar

#### Body Entrada (vetor json)

```json
{
    "login": "userTeste",
    "password": "userTeste"
}
```

| Nome  | Descrição        | Tipo   |
|:-----:|:----------------:|:------:|
| login | Login do usuário | String |

#### Body Saída (vetor json)

```json
{
    "id": "0",
    "name": "userTeste",
    "login": "userTeste",
    "email": "userTeste@gmail.com",
    "frontpage_id": "41",
    "active": "Y"
}
```

| Nome         | Descrição                    | Tipo   |
|:------------:|:----------------------------:|:------:|
| id           | Identificador do usuário     | INT    |
| name         | Nome do usuário              | String |
| login        | Login do usuário             | String |
| email        | Email de cadastro do usuário | Strinh |
| frontpage_id |                              |        |
| active       | Status atual do login        | String |

## Pergunta2

### Sortear Perguntas

Recurso responsável por sortear de forma aleatória uma quantidade de perguntas definida, contando que tenha uma fala proposta.

<p style="color: yellow;">[POST]</p> https://memore-net.com/api/JEDI-API/pergunta2/sortearPerguntas

#### Body Entrada (json)

```json
{
    "quantidade": 3
}
```

| Nome       | Descrição                              | Tipo |
|:----------:|:--------------------------------------:|:----:|
| quantidade | Quantidade de perguntas a ser sorteada | INT  |

#### Body Saída (vetor json)

```json
[
    {
        "idtema": "17",
        "id": "1430",
        "pergunta": "Publicado em 15/10/2022. Musk volta atrás e diz que continuará financiando rede de internet Starlink na Ucrânia | Mundo | G1",
        "respcerta": "NÃO FAKE",
        "resp2": "FAKE",
        "resp3": null,
        "resp4": null,
        "caminhoimagem": "sem_imagem.png",
        "caract_proposta": null,
        "analise_proposta": "1. Ausência de Corroboração em Outras Fontes; porque a notícia foi publicada pelo G1, que é um veículo confiável e reconhecido, mostrando que a informação está confirmada por uma fonte séria;    2. Erros de Escrita e Formatação Amadora; a notícia tem texto bem escrito e organizado, sem erros bobos, indicando que passou por revisão editorial profissional;    3. Conteúdo Emocional, Parcial ou Extremado; a notícia apresenta os fatos de forma clara e objetiva, sem exageros ou opiniões fortes, o que ajuda a manter a informação confiável.",
        "analise_gpt": "1. Ausência de Corroboração em Outras Fontes; porque a notícia foi publicada pelo G1, que é um veículo confiável e reconhecido, mostrando que a informação está confirmada por uma fonte séria;  \r\n2. Erros de Escrita e Formatação Amadora; a notícia tem texto bem escrito e organizado, sem erros bobos, indicando que passou por revisão editorial profissional;  \r\n3. Conteúdo Emocional, Parcial ou Extremado; a notícia apresenta os fatos de forma clara e objetiva, sem exageros ou opiniões fortes, o que ajuda a manter a informação confiável.",
        "analise_gemini": null,
        "origem_analise": "1",
        "fala_gpt": "Olha só, essa notícia é daquelas que não exagera no título, vem de um site confiável, tem fontes claras e não tenta mexer com seu medo ou raiva, então dá pra confiar que não é fake.",
        "fala_gemini": null,
        "origem_fala": "1",
        "fala_proposta": "Olha só, essa notícia é daquelas que não exagera no título, vem de um site confiável, tem fontes claras e não tenta mexer com seu medo ou raiva, então dá pra confiar que não é fake.",
        "publica": "1"
    },
    {
        "idtema": "17",
        "id": "1432",
        "pergunta": "Portugal facilita vistos para nômades digitais | Turismo e Viagem | G1",
        "respcerta": "NÃO FAKE",
        "resp2": "FAKE",
        "resp3": null,
        "resp4": null,
        "caminhoimagem": "sem_imagem.png",
        "caract_proposta": null,
        "analise_proposta": null,
        "analise_gpt": "Título Sensacionalista ou Alarmista ou Chamativo; O título é direto e informativo, sem exageros ou promessas milagrosas, indicando que Portugal facilitou vistos para nômades digitais de forma clara e objetiva; Erros de Escrita e Formatação Amadora; A notícia publicada no G1 apresenta texto bem revisado, com boa gramática e formatação profissional, típica de veículos jornalísticos confiáveis; Ausência de Corroboração em Outras Fontes; A informação sobre Portugal facilitar vistos para nômades digitais é confirmada por vários veículos de imprensa reconhecidos, mostrando que não é uma notícia isolada ou sem respaldo.",
        "analise_gemini": null,
        "origem_analise": "1",
        "fala_gpt": "Olha só, essa notícia é de boa porque o título é direto, não tem erro bobo, cita fontes confiáveis, o site é conhecido, o texto é só informação sem drama, a notícia é atual, as imagens são reais, vários veículos publicaram, não te pedem pra sair compartilhando correndo e não tem aquelas teorias malucas de conspiração.",
        "fala_gemini": null,
        "origem_fala": "1",
        "fala_proposta": "Confia! Vai que é de boa!  É verdade porque o título é direto, não tem erro bobo, cita fontes confiáveis, o site é conhecido, o texto é só informação sem drama e vários veículos publicaram.",
        "publica": "1"
    },
    {
        "idtema": "17",
        "id": "1434",
        "pergunta": "Musk diz que SpaceX não pode financiar Starlink indefinidamente na Ucrânia | Ucrânia e Rússia | G1",
        "respcerta": "NÃO FAKE",
        "resp2": "FAKE",
        "resp3": null,
        "resp4": null,
        "caminhoimagem": "sem_imagem.png",
        "caract_proposta": null,
        "analise_proposta": "Ausência de Título Sensacionalista: o título é direto e informativo, sem exageros ou alarmismos; Erros de Escrita e Formatação Amadora ausentes: a notícia apresenta texto bem escrito e estruturado, típico de jornalismo profissional; Ausência de Teorias da Conspiração ou Promessas Exageradas: a notícia traz declaração real de Musk sem misturar especulações ou narrativas fantasiosas.",
        "analise_gpt": "Ausência de Título Sensacionalista: o título é direto e informativo, sem exageros ou alarmismos; Erros de Escrita e Formatação Amadora ausentes: a notícia apresenta texto bem escrito e estruturado, típico de jornalismo profissional; Ausência de Teorias da Conspiração ou Promessas Exageradas: a notícia traz declaração real de Musk sem misturar especulações ou narrativas fantasiosas.",
        "analise_gemini": null,
        "origem_analise": "1",
        "fala_gpt": "Olha só, essa notícia é confiável porque o título é direto e não exagera, o texto está bem escrito, cita fontes conhecidas como o G1 e não tenta te fazer sentir medo ou raiva só pra você compartilhar correndo.",
        "fala_gemini": null,
        "origem_fala": "1",
        "fala_proposta": "\"Papo reto\", essa notícia é confiável porque o título é direto e não exagera, o texto está bem escrito, cita fontes conhecidas como o G1 e não tenta te fazer sentir medo ou raiva só pra você compartilhar correndo.",
        "publica": "1"
    }
]
```

| Nome             | Descrição                                           | Tipo   |
|:----------------:|:---------------------------------------------------:|:------:|
| idTema           | Identificador do tema corespondente aquela pergunta | INT    |
| id               | Identificador da pergunta                           | INT    |
| pergunta         | Texto da pergunta                                   | String |
| respcerta        | Opção correta a se responder                        | String |
| resp2            | Segunda opção de resposta                           | String |
| resp3            | Terceira opção de resposta                          | String |
| resp4            | Quarta opção de resposta                            | String |
| caminhoimagem    | URL da imagem de apoio que acompanha a pergunta     | String |
| caract_proposta  |                                                     |        |
| analise_proposta | Análise escolhida para ser usada                    | String |
| analise_gpt      | Análise gerada pela IA chatGPT                      | String |
| analise_gamini   | Análise gerada pela IAgemini                        | String |
| origem_analise   |                                                     |        |
| fala_gpt         | Resposta sobre a pergunta gerada pela IA chatGPT    | String |
| fala_gemini      | Resposta sobre a pergunta gerada pela IA gemini     | String |
| origem_fala      |                                                     |        |
| fala_proposta    | Resposta escolhida para ser usada                   | String |
| publica          | Código que defini se está pública ou não            | INT    |

### Listar Pergunta

Recurso desponsável por listar todos os campos de uma pergunta específica, contanto que tenha uma fala proposta.

<p style="color: green">[GET]</p> https://memore-net.com/api/JEDI-API/pergunta2/listarPergunta/{idPergunta}

#### Body Saída (vetor json):

```json
[
    {
        "idtema": "17",
        "id": "1430",
        "pergunta": "Publicado em 15/10/2022. Musk volta atrás e diz que continuará financiando rede de internet Starlink na Ucrânia | Mundo | G1",
        "respcerta": "NÃO FAKE",
        "resp2": "FAKE",
        "resp3": null,
        "resp4": null,
        "caminhoimagem": "sem_imagem.png",
        "caract_proposta": null,
        "analise_proposta": "1. Ausência de Corroboração em Outras Fontes; porque a notícia foi publicada pelo G1, que é um veículo confiável e reconhecido, mostrando que a informação está confirmada por uma fonte séria;    2. Erros de Escrita e Formatação Amadora; a notícia tem texto bem escrito e organizado, sem erros bobos, indicando que passou por revisão editorial profissional;    3. Conteúdo Emocional, Parcial ou Extremado; a notícia apresenta os fatos de forma clara e objetiva, sem exageros ou opiniões fortes, o que ajuda a manter a informação confiável.",
        "analise_gpt": "1. Ausência de Corroboração em Outras Fontes; porque a notícia foi publicada pelo G1, que é um veículo confiável e reconhecido, mostrando que a informação está confirmada por uma fonte séria;  \r\n2. Erros de Escrita e Formatação Amadora; a notícia tem texto bem escrito e organizado, sem erros bobos, indicando que passou por revisão editorial profissional;  \r\n3. Conteúdo Emocional, Parcial ou Extremado; a notícia apresenta os fatos de forma clara e objetiva, sem exageros ou opiniões fortes, o que ajuda a manter a informação confiável.",
        "analise_gemini": null,
        "origem_analise": "1",
        "fala_gpt": "Olha só, essa notícia é daquelas que não exagera no título, vem de um site confiável, tem fontes claras e não tenta mexer com seu medo ou raiva, então dá pra confiar que não é fake.",
        "fala_gemini": null,
        "origem_fala": "1",
        "fala_proposta": "Olha só, essa notícia é daquelas que não exagera no título, vem de um site confiável, tem fontes claras e não tenta mexer com seu medo ou raiva, então dá pra confiar que não é fake.",
        "publica": "1"
    }
]
```

| Nome             | Descrição                                           | Tipo   |
| ---------------- | --------------------------------------------------- | ------ |
| idTema           | Identificador do tema corespondente aquela pergunta | INT    |
| id               | Identificador da pergunta                           | INT    |
| pergunta         | Texto da pergunta                                   | String |
| respcerta        | Opção correta a se responder                        | String |
| resp2            | Segunda opção de resposta                           | String |
| resp3            | Terceira opção de resposta                          | String |
| resp4            | Quarta opção de resposta                            | String |
| caminhoimagem    | URL da imagem de apoio que acompanha a pergunta     | String |
| caract_proposta  |                                                     |        |
| analise_proposta | Análise escolhida para ser usada                    | String |
| analise_gpt      | Análise gerada pela IA chatGPT                      | String |
| analise_gamini   | Análise gerada pela IAgemini                        | String |
| origem_analise   |                                                     |        |
| fala_gpt         | Resposta sobre a pergunta gerada pela IA chatGPT    | String |
| fala_gemini      | Resposta sobre a pergunta gerada pela IA gemini     | String |
| origem_fala      |                                                     |        |
| fala_proposta    | Resposta escolhida para ser usada                   | String |
| publica          | Código que defini se está pública ou não            | INT    |

### Listar Todas Perguntas

Recurso responsável por listar todas as perguntas, contanto que tenha uma fala proposta.  

[GET] https://memore-net.com/api/JEDI-API/pergunta2/listarTodasPerguntas

#### Body Saída (vetor json):

```json
[
    {
        "idtema": "17",
        "id": "1430",
        "pergunta": "Publicado em 15/10/2022. Musk volta atrás e diz que continuará financiando rede de internet Starlink na Ucrânia | Mundo | G1",
        "respcerta": "NÃO FAKE",
        "resp2": "FAKE",
        "resp3": null,
        "resp4": null,
        "caminhoimagem": "sem_imagem.png",
        "caract_proposta": null,
        "analise_proposta": "1. Ausência de Corroboração em Outras Fontes; porque a notícia foi publicada pelo G1, que é um veículo confiável e reconhecido, mostrando que a informação está confirmada por uma fonte séria;    2. Erros de Escrita e Formatação Amadora; a notícia tem texto bem escrito e organizado, sem erros bobos, indicando que passou por revisão editorial profissional;    3. Conteúdo Emocional, Parcial ou Extremado; a notícia apresenta os fatos de forma clara e objetiva, sem exageros ou opiniões fortes, o que ajuda a manter a informação confiável.",
        "analise_gpt": "1. Ausência de Corroboração em Outras Fontes; porque a notícia foi publicada pelo G1, que é um veículo confiável e reconhecido, mostrando que a informação está confirmada por uma fonte séria;  \r\n2. Erros de Escrita e Formatação Amadora; a notícia tem texto bem escrito e organizado, sem erros bobos, indicando que passou por revisão editorial profissional;  \r\n3. Conteúdo Emocional, Parcial ou Extremado; a notícia apresenta os fatos de forma clara e objetiva, sem exageros ou opiniões fortes, o que ajuda a manter a informação confiável.",
        "analise_gemini": null,
        "origem_analise": "1",
        "fala_gpt": "Olha só, essa notícia é daquelas que não exagera no título, vem de um site confiável, tem fontes claras e não tenta mexer com seu medo ou raiva, então dá pra confiar que não é fake.",
        "fala_gemini": null,
        "origem_fala": "1",
        "fala_proposta": "Olha só, essa notícia é daquelas que não exagera no título, vem de um site confiável, tem fontes claras e não tenta mexer com seu medo ou raiva, então dá pra confiar que não é fake.",
        "publica": "1"
    },
    ...
]
```

| Nome             | Descrição                                           | Tipo   |
| ---------------- | --------------------------------------------------- | ------ |
| idTema           | Identificador do tema corespondente aquela pergunta | INT    |
| id               | Identificador da pergunta                           | INT    |
| pergunta         | Texto da pergunta                                   | String |
| respcerta        | Opção correta a se responder                        | String |
| resp2            | Segunda opção de resposta                           | String |
| resp3            | Terceira opção de resposta                          | String |
| resp4            | Quarta opção de resposta                            | String |
| caminhoimagem    | URL da imagem de apoio que acompanha a pergunta     | String |
| caract_proposta  |                                                     |        |
| analise_proposta | Análise escolhida para ser usada                    | String |
| analise_gpt      | Análise gerada pela IA chatGPT                      | String |
| analise_gamini   | Análise gerada pela IAgemini                        | String |
| origem_analise   |                                                     |        |
| fala_gpt         | Resposta sobre a pergunta gerada pela IA chatGPT    | String |
| fala_gemini      | Resposta sobre a pergunta gerada pela IA gemini     | String |
| origem_fala      |                                                     |        |
| fala_proposta    | Resposta escolhida para ser usada                   | String |
| publica          | Código que defini se está pública ou não            | INT    |

## Partidas Perguntas

### Ranking

Recurso responsável por montar um ranking







## Log Perguntas

### Listar Log Perguntas

Recurso responsável por listar todos os logs de perguntas de um usuário específico.

[GET] https://memore-net.com/api/JEDI-API/logPerguntas/listarLogPergunta/{idPartida}

#### Body Saída (vetor json)

```json
[
    {
        "dtJogo": "2026-03-12",
        "idPartida": "24",
        "usuario": "userTeste@gmail.com",
        "idade": "15",
        "tema": "17",
        "jogador": "Thiago",
        "numJogada": "1",
        "pergunta": "63",
        "respCerta": "FAKE",
        "respDada": "FAKE",
        "tempoGasto": "25",
        "posicao": "0"
    },
    {
        "dtJogo": "2026-03-12",
        "idPartida": "24",
        "usuario": "userTeste@gmail.com",
        "idade": "15",
        "tema": "17",
        "jogador": "Thiago",
        "numJogada": "2",
        "pergunta": "1430",
        "respCerta": "NÃO FAKE",
        "respDada": "FAKE",
        "tempoGasto": "118",
        "posicao": "3"
    },
    {
        "dtJogo": "2026-03-12",
        "idPartida": "24",
        "usuario": "userTeste@gmail.com",
        "idade": "15",
        "tema": "17",
        "jogador": "Thiago",
        "numJogada": "3",
        "pergunta": "26",
        "respCerta": "FAKE",
        "respDada": "FAKE",
        "tempoGasto": "294",
        "posicao": "3"
    },
    {
        "dtJogo": "2026-03-12",
        "idPartida": "24",
        "usuario": "userTeste@gmail.com",
        "idade": "15",
        "tema": "17",
        "jogador": "Thiago",
        "numJogada": "4",
        "pergunta": "26",
        "respCerta": "FAKE",
        "respDada": "FAKE",
        "tempoGasto": "216",
        "posicao": "8"
    },
    {
        "dtJogo": "2026-03-12",
        "idPartida": "24",
        "usuario": "userTeste@gmail.com",
        "idade": "15",
        "tema": "17",
        "jogador": "Thiago",
        "numJogada": "5",
        "pergunta": "60",
        "respCerta": "FAKE",
        "respDada": "FAKE",
        "tempoGasto": "156",
        "posicao": "21"
    },
    {
        "dtJogo": "2026-03-12",
        "idPartida": "24",
        "usuario": "userTeste@gmail.com",
        "idade": "15",
        "tema": "17",
        "jogador": "Thiago",
        "numJogada": "6",
        "pergunta": "1428",
        "respCerta": "NÃO FAKE",
        "respDada": "NÃO FAKE",
        "tempoGasto": "38",
        "posicao": "27"
    }
]
```

| Nome       | Descrição                                      | Tipo   |
|:----------:|:----------------------------------------------:|:------:|
| dtJogo     | Data de quando a partida foi iniciada          | String |
| idPartida  | Identificação da partida que o log pertence    | INT    |
| usuario    | Email do usuário                               | String |
| idade      | Idade declarada pelo usuário                   | INT    |
| tema       | Identificação do tema do jogo escolhido        | INT    |
| jogador    | Nome do avatar escolhido                       | String |
| numJogada  | Número da jogada feita                         | INT    |
| pergunta   | Identificador da pergunta feita                | INT    |
| respCerta  | Resposta certa da pergunta feita               | String |
| respDada   | Respota dada pelo usuário                      | String |
| tempoGasto | Tempo gasto para responder a pergunta          | Float  |
| posicao    | Posição do jogador quando respondeu a pergunta | INT    |


