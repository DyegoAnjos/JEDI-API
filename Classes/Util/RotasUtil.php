<?php

namespace Util;

class RotasUtil
{
    public static function getRotas(){
        $urls   = self::getUrls();

        $request['metodo'] = $_SERVER['REQUEST_METHOD']; // metodo http
        $request['rota'] = strtoupper($urls[0]); // tabela
        $request['recurso'] = $urls[1] ?? null; // ação

        if($request['recurso'] === 'validar'){
            $request['login'] = $urls[2] ?? null;
            $request['senha'] = $urls[3] ?? null;
        }

        else{
            $request['id'] = $urls[2] ?? null;
        }

        return $request;
    }

    public static function getUrls(){
        $uri = str_replace('/' . DIR_PROJETO . '/', '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }
}