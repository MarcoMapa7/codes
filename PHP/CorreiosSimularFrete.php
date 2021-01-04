<?php
 $data['nCdEmpresa'] = '15018342';
 $data['sDsSenha'] = 'tsz66f';
 $data['sCepOrigem'] = '18780000';
 $data['sCepDestino'] = '18035640';
 $data['nVlPeso'] = '1';
 $data['nCdFormato'] = '1';
 $data['nVlComprimento'] = '16';
 $data['nVlAltura'] = '5';
 $data['nVlLargura'] = '15';
 $data['nVlDiametro'] = '0';
 $data['sCdMaoPropria'] = 's';
 $data['nVlValorDeclarado'] = '200';
 $data['sCdAvisoRecebimento'] = 'n'; // ('n' / 's')
 $data['StrRetorno'] = 'xml'; // ('xml', 'url', 'popup')
 //$data['nCdServico'] = '40010';
 $data['nCdServico'] = '41106,40010,04596,04669';
 $data = http_build_query($data);

 $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

 $curl = curl_init($url . '?' . $data);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

 $result = curl_exec($curl);
 $result = simplexml_load_string($result);
 foreach($result -> cServico as $row) {
 //Os dados de cada serviço estará aqui
 if($row -> Erro == 0) {
    
     if ($row -> Codigo == 40010){
        echo "<img src='sedex.jpg' width='200'><br>";
     }else{
        echo "<img src='pac.png' width='200'><br>";
     }
     
     echo 'Codigo: '.$row -> Codigo . '<br>';
     echo 'Valor: '.$row -> Valor . '<br>';
     echo 'Prazo Entrega: '.$row -> PrazoEntrega . '<br>';
     echo 'Valor Mao Propria: '.$row -> ValorMaoPropria . '<br>';
     echo 'Valor Aviso Recebimento: '.$row -> ValorAvisoRecebimento . '<br>';
     echo 'Valor Declarado: '.$row -> ValorValorDeclarado . '<br>';
     echo 'Entrega Domiciliar: '.$row -> EntregaDomiciliar . '<br>';
     echo 'Entrega Sabado: '.$row -> EntregaSabado;
 } else {
     echo $row -> MsgErro;
 }
 echo '<hr>';
 }
 
 ?>