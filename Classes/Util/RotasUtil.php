<?php

namespace Util;

class RotasUtil
{
    /**
     * @return array
     */
    public static function getRotas(){
        //Função responsável por pegar a URL e separar no array do request
        $urls = self::getUrls();

        $request['metodo'] = $_SERVER['REQUEST_METHOD']; // Método HTTP não precisa passar na URL pois ele pega automático
        $request['rota'] = strtoupper($urls[0]); // Tabela que será executada o request
        $request['recurso'] = $urls[1] ?? null; // Ação a ser feita


        if($request['recurso'] === 'validar'){
            //Formatação especial da URL para quando a ação é validar
            $request['email'] = $urls[2] ?? null;
            $request['senha'] = $urls[3] ?? null;
        }

        else{
            $request['id'] = $urls[2] ?? null;
        }

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