<?php   

    $config = array(
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
            'compression' => SOAP_COMPRESSION_ACCEPT
    );

    $address = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl';   

    $client = new SoapClient($address, $config);

    $cep  = $client->consultaCEP(['cep' =>'57055130']);
	
	
	var_dump($cep);