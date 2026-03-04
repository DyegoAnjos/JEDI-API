<?php

namespace Util;

class RotasUtil
{
    /**
     * @return array
     */
    public static function getRotas(){
        $urls = self::getUrls();

        $request['metodo'] = $_SERVER['REQUEST_METHOD'];
        $request['rota'] = strtoupper($urls[0]);
        $request['recurso'] = $urls[1] ?? null;

        return $request;
    }

    public static function getRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'POST' || $metodo === 'PUT') {
            // Tenta ler o JSON vindo do Frontend
            $jsonObtido = file_get_contents('php://input');
            $dadosJson = json_decode($jsonObtido, true);

            // Se o JSON for válido, retorna-o. Caso contrário, usa o $_POST tradicional
            return (is_array($dadosJson)) ? $dadosJson : $_POST;
        }

        return $_GET;
    }

    /**
     * @return false|string[]
     */
    public static function getUrls(){
        //pera a URI e separa para a URL
        $uri = str_replace('/' . DIR_PROJETO . '/', '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }
}