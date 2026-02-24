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
        $request['id'] = $urls[2] ?? null; // Opcional, para outras rotas
        return $request;
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