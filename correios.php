<?php
/**
 * User: Eliseu Borges
 * Date: 02/07/2017
 * Time: 13:21
 */

class Correios{
    public static function getEndereco($cep)
    {

        //Consulta
        $action = "http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm";
        $ch = curl_init($action);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "relaxation=" . $cep);

        $response = curl_exec($ch);
        curl_close($ch);


        //Tratamento
        $doc = new DOMDocument();
        $doc->loadHTML($response);

        $xpath = new \DOMXPath($doc);

        $emptyCEP = $xpath->query('//p[contains(.,"DADOS NAO ENCONTRADOS")]')->length === 1;

        if ($emptyCEP) {
            return false;
        }


        $columns = $xpath->query('//table[@class="tmptabela"]/tr/td/text()');

        return array(
            "logradouro" => $columns[0]->nodeValue,
            "bairro" => $columns[1]->nodeValue,
            "cidadeUf" => $columns[2]->nodeValue,
            "cep" => $columns[3]->nodeValue
        );
    }
}
