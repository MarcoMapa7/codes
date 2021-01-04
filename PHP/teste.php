<?php
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);

echo php_info();
exit();

$codigoRastreio = 'PP781262618BR';


$urlws_wsdl = "http://webservice.correios.com.br/service/rastro/Rastro.wsdl";
 
   $cliente = new \SoapClient($urlws_wsdl, array(
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
            'soap_version' => SOAP_1_1,
            'compression' => SOAP_COMPRESSION_ACCEPT
        ));
 
  $metodo = 'buscaEventos';  
 
   $campos = array(
                'usuario' => 'ECT', 
                'senha' => 'SRO',
                'tipo' => 'L',
                'resultado' => 'T',
                'lingua' => '101',
                'objeto' => $codigoRastreio
            );   

$calculo = $cliente->$metodo($campos);
var_dump($calculo);

echo '<hr>';