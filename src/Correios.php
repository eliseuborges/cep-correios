<?php
namespace Eliseuborges;

use Eliseuborges\Exceptions\InvalidCepException;
use Eliseuborges\Exceptions\NotFoundException;

/**
 * Class Correios
 *
 * @author Eliseu Borges
 *
 * Date: 02/07/2017
 * Time: 13:21
 */
class Correios
{
    /**
     * Recupera um endereço através de seu CEP
     *
     * @param $cep
     *
     * @return array|bool
     */
    public static function getEndereco($cep)
    {
        if (!$cep) {
            throw new InvalidCepException('Informe um CEP válido');
        }

        //Consulta
        $action = "http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm";
        $ch = curl_init($action);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "relaxation=" . $cep);

        $response = curl_exec($ch);
        curl_close($ch);

        //Tratamento
        $doc = new \DOMDocument();
        $doc->loadHTML($response);
        $xpath = new \DOMXPath($doc);

        $emptyCEP = $xpath->query('//p[contains(.,"DADOS NAO ENCONTRADOS")]')->length === 1;

        if ($emptyCEP) {
            throw new NotFoundException('CEP não encontrado');
        }

        $columns = $xpath->query('//table[@class="tmptabela"]/tr/td/text()');

        $cidadeUf = explode('/', $columns[2]->nodeValue);

        return array(
            "logradouro" => $columns[0]->nodeValue,
            "bairro" => $columns[1]->nodeValue,
            "cidade" => $cidadeUf[0],
            "uf" => $cidadeUf[1],
            "cep" => $columns[3]->nodeValue
        );
    }
}
