<?php
ini_set('error_reporting', E_ALL);
    ini_set("display_errors", 1);
header('Content-Type: text/html; charset=iso-8859-1');

 $urlws_wsdl = "http://www.jadlog.com.br:8080/JadlogEdiWs/services/ValorFreteBean?wsdl";
        $client = new \SoapClient($urlws_wsdl, array(
            'stream_context' => stream_context_create(
                    array('http' =>
                        array(
                            'protocol_version' => '1.0',
					     )
                    )
            ),
            "style" => SOAP_DOCUMENT,
            "encoding" => 'UTF-8',
            "cache_wsdl" => WSDL_CACHE_BOTH,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'exceptions' => false,
            'trace' => 1,
            'soap_version' => SOAP_1_2,
            'compression' => SOAP_COMPRESSION_ACCEPT
        ));

        $campos = array(		
		'vModalidade' => 3,
		'Password' => 'MZvayvz',
		'vSeguro' => 'N',
		'vVlDec' => 10,    
                'vVlColeta' => 1,5,         	
                'vCepOrig' => '30170120',	
                'vCepDest' => '18780000',        	
                'vPeso' => '5',            	
                'vFrap' => 'N',           	
                'vEntrega' => 'D',        	
                'vCnpj' => '28590236000144'       
);        
        
  $funcao = 'valorar';       
  $calculo = $client->$funcao($campos);
    	 
//print_r($calculo);
//echo '<hr>';

$xml = simplexml_load_string($calculo->valorarReturn);
//print_r($xml);
//echo "<hr>";

echo 'Versão: ';
echo $xml->Jadlog_Valor_Frete->versao;
echo "<hr>";

echo 'Valor R$: ';
echo $xml->Jadlog_Valor_Frete->Retorno;
echo "<hr>";

     ?>