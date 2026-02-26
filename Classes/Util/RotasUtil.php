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

    /**
     * @return false|string[]
     */
    public static function getUrls(){
        //pera a URI e separa para a URL
        $uri = str_replace('/' . DIR_PROJETO . '/', '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }
}