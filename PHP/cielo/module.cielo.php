<?php

class CHECKOUT_CIELO extends ISC_CHECKOUT_PROVIDER
{

	var $_requiresSSL = false;
	public function __construct()
	{
		parent::__construct();
		$this->_name = "Modulo Cielo 3.5 - Visa - Electron - Mastercard - Elo - Diners - Discover - Amex";
		$this->_image = "cielo.gif";
		$this->_description = "Modulo Cielo 3.5 - Visa - Electron - Mastercard - Elo - Diners - Discover - Amex.";
		$this->_help = "Modulo Pagamento Cielo 3.5 - Visa - Electron - Mastercard - Elo - Diners - Discover - Amex. <a href='http://www.marcomapa.com' target='_blank'>www.marcomapa.com</a>.";
		$this->_enabled = $this->CheckEnabled();
		$this->_height = 0;
		$this->_paymenttype = PAYMENT_PROVIDER_OFFLINE;
		@$GLOBALS['ISC_CLASS_DB']->Query("CREATE TABLE IF NOT EXISTS `cielo` (
  `id` int(11) NOT NULL auto_increment,
  `pedido` int(11) NOT NULL,
  `valor` int(20) NOT NULL,
  `tid` varchar(30) NOT NULL,
  `auth` varchar(20) NOT NULL,
  `data` varchar(20) NOT NULL,
  `cc` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;");
	}

	public function SetCustomVars()

	{
		$this->_variables['serial'] = array("name" => 'Serial do Modulo',
		   "type" => "textbox",
		   "help" => 'Chave de Registro do Modulo',
		   "default" => "ILIMITADO",
		   "required" => true
		);
	
		$this->_variables['displayname'] = array("name" => "Nome do Modulo",
			   "type" => "textbox",
			   "help" => 'Nome do Modulo',
			   "default" => "Modulo Cielo 3.5 - Visa - Electron - Mastercard - Elo - Diners - Discover - Amex",
			   "required" => true
		);
		
		$this->_variables['availablecountries'] = array("name" => "Paises",
			   "type" => "dropdown",
			   "help" => GetLang('PagContinente'),
			   "default" => "all",
			   "required" => true,
			   "options" => GetCountryListAsNameValuePairs(),
				"multiselect" => true
		);
		
	   $this->_variables['modo'] = array("name" => "Modo",
			   "type" => "dropdown",
			   "help" => 'Selecione o Modo do Operacao e veja nos itens abaixo os helps.',
			   "default" => 'T',
			   "options" => array("TESTE"=>"T","PRODUCAO"=>"P"),
			   "required" => true,
			   "multiselect" => false
		);

		$this->_variables['afiliacao'] = array("name" => 'Afiliacao Cielo',
		   "type" => "textbox",
		   "help" => 'Ponha sua Afiliacao Cielo se for teste use 1001734898',
		   "default" => "",
		   "required" => true
		);
		
		$this->_variables['chave'] = array("name" => 'Chave Cielo',
		   "type" => "textbox",
		   "help" => 'Chave da afiliacao junto a Cielo se for teste use e84827130b9837473681c2787007da5914d6359947015a5cdb2b8843db0fa832.',
		   "default" => "",
		   "required" => true
		);

		$this->_variables['loja'] = array("name" => 'Nome da Loja',
		   "type" => "textbox",
		   "help" => 'Nome da sua loja a ser mostrado.',
		   "default" => "",
		   "required" => true
		);
		
	   $this->_variables['meios'] = array("name" => "Bandeiras Aceitas",
			   "type" => "dropdown",
			   "help" => 'Selecione os meios que ira aceitar na loja.',
			   "default" => '',
			   "options" => array("VISA"=>"V","MASTER"=>"M","VISA ELECTRON"=>"E","ELO"=>"EL","DINERS"=>"DIN","DISCOVER"=>"DIS","AMEX"=>"AM"),
			   "required" => true,
			   "multiselect" => true
		);	
		
       $this->_variables['parcelamin'] = array("name" => 'Parcela Minima',
		   "type" => "textbox",
		   "help" => 'Ponha o Valor Minimo de Uma Parcela No Parcelamento de Pedidos',
		   "default" => "15.00",
		   "required" => true
		);
		
		$this->_variables['juros'] = array("name" => 'Juros Credito',
		   "type" => "textbox",
		   "help" => 'Se parcelar sem juros, especificar a taxa de juros.',
		   "default" => "0.00",
		   "required" => true
		);
		
		$this->_variables['desconto'] = array("name" => 'Desconto Debito',
		   "type" => "textbox",
		   "help" => 'Desconto em % para pagamento por debito.',
		   "default" => "0.00",
		   "required" => true
		);

		$this->_variables['div'] = array("name" => "Dividir em ate:",
			   "type" => "dropdown",
			   "help" => 'Sera cobrado juros a partir da parcela.',
			   "default" => '12',
			   "options" => array("1x"=>"1","2x"=>"2","3x"=>"3","4x"=>"4","5x"=>"5","6x"=>"6","7x"=>"7","8x"=>"8","9x"=>"9","10x"=>"10","11x"=>"11","12x"=>"12"),
			   "required" => true
		);
			
		
		$this->_variables['jurosde'] = array("name" => "Sem Juros ate:",
			   "type" => "dropdown",
			   "help" => 'Sera cobrado juros a partir da parcela.',
			   "default" => '6',
			   "options" => array("Nenhuma"=>"99","1x"=>"1","2x"=>"2","3x"=>"3","4x"=>"4","5x"=>"5","6x"=>"6","7x"=>"7","8x"=>"8","9x"=>"9","10x"=>"10","11x"=>"11","12x"=>"12"),
			   "required" => true
		);
		
			

		$this->_variables['tipojuros'] = array("name" => "Tipo Parcelamento",
			   "type" => "dropdown",
			   "help" => '',
			   "default" => '2',
			   "options" => array("Parcelado Loja"=>"2","Parcelado Operadora"=>"3"),
			   "required" => true
		);	


			
		
	}

public function parcelar($valorTotal, $taxa, $nParcelas){
    $taxa = $taxa/100;
    $cadaParcela = ($valorTotal*$taxa)/(1-(1/pow(1+$taxa, $nParcelas)));
    return round($cadaParcela, 2);
}

public function getofflinepaymentmessage(){

$order = LoadPendingOrderByToken($_COOKIE['SHOP_ORDER_TOKEN']);
//exite;
if(isset($_COOKIE['SHOP_ORDER_TOKEN'])){

//variaveis
$meios =        $this->GetValue("meios");
$minima =  $this->GetValue("parcelamin");
$dividirem =      $this->GetValue("div");
$semjuros =   $this->GetValue("jurosde");
$valor =        $order['ordtotalamount'];
$pedido =              $order['orderid']; 
$juros =        $this->GetValue("juros");
$desconto =  $this->GetValue("desconto");

$tipojuros =  $this->GetValue("tipojuros");

if($valor>$minima) {
$splitss = (int) ($valor/$minima);
if($splitss<=$dividirem){
$div = $splitss;
}else{
$div = $dividirem;
}
}else{
$div = 1;
}

$help = "<script type='text/javascript'>
function getCheckedValue(radioObj) {
var objRadio = document.getElementsByName(radioObj).length;
for(i=0; i < objRadio; i++ ) {
if (document.getElementsByName(radioObj)[i].checked) {
return document.getElementsByName(radioObj)[i].value;
}
}
}
function credito() {
document.getElementById('credito').style.display = '';
document.getElementById('debito').style.display = 'none';
document.getElementById('master').style.display = 'none';
document.getElementById('elo').style.display = 'none';
document.getElementById('din').style.display = 'none';
document.getElementById('dis').style.display = 'none';
document.getElementById('ame').style.display = 'none';
return true;
}
function debito() {
document.getElementById('credito').style.display = 'none';
document.getElementById('debito').style.display = '';
document.getElementById('master').style.display = 'none';
document.getElementById('elo').style.display = 'none';
document.getElementById('din').style.display = 'none';
document.getElementById('dis').style.display = 'none';
document.getElementById('ame').style.display = 'none';
return true;
}
function master() {
document.getElementById('credito').style.display = 'none';
document.getElementById('debito').style.display = 'none';
document.getElementById('master').style.display = '';
document.getElementById('elo').style.display = 'none';
document.getElementById('din').style.display = 'none';
document.getElementById('dis').style.display = 'none';
document.getElementById('ame').style.display = 'none';
return true;
}
function elo() {
document.getElementById('credito').style.display = 'none';
document.getElementById('debito').style.display = 'none';
document.getElementById('master').style.display = 'none';
document.getElementById('elo').style.display = '';
document.getElementById('din').style.display = 'none';
document.getElementById('dis').style.display = 'none';
document.getElementById('ame').style.display = 'none';
return true;
}
function din() {
document.getElementById('credito').style.display = 'none';
document.getElementById('debito').style.display = 'none';
document.getElementById('master').style.display = 'none';
document.getElementById('elo').style.display = 'none';
document.getElementById('din').style.display = '';
document.getElementById('dis').style.display = 'none';
document.getElementById('ame').style.display = 'none';
return true;
}
function dis() {
document.getElementById('credito').style.display = 'none';
document.getElementById('debito').style.display = 'none';
document.getElementById('master').style.display = 'none';
document.getElementById('elo').style.display = 'none';
document.getElementById('din').style.display = 'none';
document.getElementById('dis').style.display = '';
document.getElementById('ame').style.display = 'none';
return true;
}

function ame() {
document.getElementById('credito').style.display = 'none';
document.getElementById('debito').style.display = 'none';
document.getElementById('master').style.display = 'none';
document.getElementById('elo').style.display = 'none';
document.getElementById('din').style.display = 'none';
document.getElementById('dis').style.display = 'nome';
document.getElementById('ame').style.display = '';
return true;
}

var retorno;
var valor;
var mpg_popup;
window.name='retorno';
function fabrewin(valor)
{
mpg_popup = window.open('".$GLOBALS['ShopPath']."/modules/checkout/cielo/pagar.php?token='+valor,'mpg_popup','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=1,resizable=0,screenX=0,screenY=0,left=150,top=150,width=460,height=660');
return true;
}

function pegavalor() {
var valor = getCheckedValue('forma');
if(valor) {
fabrewin(valor);
return true;
}else{
alert('".GetLang('SelecioneCielo')."');
}
}

</script>";	

$help .= "&nbsp;&nbsp;&nbsp;<h3>".GetLang('SelCC')."</h3><br>"; 

if(is_array($meios)){

if(in_array('V', $meios)){
$help .= "<a onclick=\"javascript:credito();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/credito.gif'></a>";
}

if(in_array('E', $meios)){
$help .= "<a onclick=\"javascript:debito();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/debito.gif'></a>";
}

if(in_array('M', $meios)){
$help .= "<a onclick=\"javascript:master();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/master.gif'></a>";
}

if(in_array('EL', $meios)){
$help .= "<a onclick=\"javascript:elo();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/elo.gif'></a>";
}

if(in_array('DIN', $meios)){
$help .= "<a onclick=\"javascript:din();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/dinners.gif'></a>";
}

if(in_array('DIS', $meios)){
$help .= "<a onclick=\"javascript:dis();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/discover.gif'></a>";
}
if(in_array('AM', $meios)){
$help .= "<a onclick=\"javascript:ame();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/amex.gif'></a>";
}

//inicio do visa
$par1 = "visa#".$pedido."#1#1#".md5($valor);
$help .= "<div id='credito' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('VisaCielo')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParVisa1xCielo'),CurrencyConvertFormatPrice($valor,1,0))."
 
<br>";

for($j=2; $j<=$div;$j++) {

if($semjuros>=$j) {

$parcelas = $valor/$j;
$parcelas = number_format($parcelas, 2, '.', '');

$sem = "visa#".$pedido."#2#".$j."#".md5($valor);
$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($sem)."'>

".sprintf(GetLang('ParVisaSemCielo'),$j,CurrencyConvertFormatPrice($parcelas,1,0))."

<br>
";

}else{

$parcelas = $this->parcelar($valor, $juros, $j);
$parcelas = number_format($parcelas, 2, '.', '');

$com = "visa#".$pedido."#".$tipojuros."#".$j."#".md5($valor);
$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($com)."'>

".sprintf(GetLang('ParVisaComCielo'),$j,CurrencyConvertFormatPrice($parcelas,1,0),CurrencyConvertFormatPrice($parcelas*$j,1,0))."

<br>
 
";
}

}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 
//fim do visa



//inicio do debito
$par1 =  "electron#".$pedido."#A#1#".md5($valor);

if($desconto>0){

$desc = ($valor/100)*$desconto;

$desconto = number_format($desconto, 0, '.', '')."%";
$help .= "<div id='debito' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('EleCielo')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParEleCieloDesc'),CurrencyConvertFormatPrice($valor-$desc,1,0),$desconto)."

<br>";
}else{
$help .= "<div id='debito' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('EleCielo')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParEleCielo'),CurrencyConvertFormatPrice($valor,1,0))."

<br>";
}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 
//fim do debito



//inicio do master
$par1 = "mastercard#".$pedido."#1#1#".md5($valor);
$help .= "<div id='master' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('MasterCielo')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParMaster1xCielo'),CurrencyConvertFormatPrice($valor,1,0))."

<br>";

for($j=2; $j<=$div;$j++) {


if($semjuros>=$j) {

$parcelas = $valor/$j;
$parcelas = number_format($parcelas, 2, '.', '');

$sem =  "mastercard#".$pedido."#2#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($sem)."'>

".sprintf(GetLang('ParMasterSemCielo'),$j,CurrencyConvertFormatPrice($parcelas,1,0))."

<br>
";

}else{

$parcelas = $this->parcelar($valor, $juros, $j);
$parcelas = number_format($parcelas, 2, '.', '');

$com =  "mastercard#".$pedido."#".$tipojuros."#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($com)."'>

".sprintf(GetLang('ParMasterComCielo'),$j,CurrencyConvertFormatPrice($parcelas,1,0),CurrencyConvertFormatPrice($parcelas*$j,1,0))."

<br>
";
}

}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 
//fim do mastercard


//inicio do elo
$par1 = "elo#".$pedido."#1#1#".md5($valor);
$help .= "<div id='elo' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('Elo')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParElo1x'),CurrencyConvertFormatPrice($valor,1,0))."

<br>";

for($j=2; $j<=$div;$j++) {


if($semjuros>=$j) {

$parcelas = $valor/$j;
$parcelas = number_format($parcelas, 2, '.', '');

$sem =  "elo#".$pedido."#2#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($sem)."'>

".sprintf(GetLang('ParEloSem'),$j,CurrencyConvertFormatPrice($parcelas,1,0))."

<br>
";

}else{

$parcelas = $this->parcelar($valor, $juros, $j);
$parcelas = number_format($parcelas, 2, '.', '');

$com =  "elo#".$pedido."#".$tipojuros."#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($com)."'>

".sprintf(GetLang('ParEloCom'),$j,CurrencyConvertFormatPrice($parcelas,1,0),CurrencyConvertFormatPrice($parcelas*$j,1,0))."

<br>
";
}

}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 
//fim do elo


//inicio do diners
$par1 = "diners#".$pedido."#1#1#".md5($valor);
$help .= "<div id='din' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('Din')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParDin1x'),CurrencyConvertFormatPrice($valor,1,0))."

<br>";

for($j=2; $j<=$div;$j++) {


if($semjuros>=$j) {

$parcelas = $valor/$j;
$parcelas = number_format($parcelas, 2, '.', '');

$sem =  "diners#".$pedido."#2#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($sem)."'>

".sprintf(GetLang('ParDinSem'),$j,CurrencyConvertFormatPrice($parcelas,1,0))."

<br>
";

}else{

$parcelas = $this->parcelar($valor, $juros, $j);
$parcelas = number_format($parcelas, 2, '.', '');

$com =  "diners#".$pedido."#".$tipojuros."#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($com)."'>

".sprintf(GetLang('ParDinCom'),$j,CurrencyConvertFormatPrice($parcelas,1,0),CurrencyConvertFormatPrice($parcelas*$j,1,0))."

<br>
";
}

}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 
//fim do diners


//inicio do discover
$par1 = "discover#".$pedido."#1#1#".md5($valor);
$help .= "<div id='dis' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('Dis')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParDis1x'),CurrencyConvertFormatPrice($valor,1,0))."

<br>";

for($j=2; $j<=$div;$j++) {


if($semjuros>=$j) {

$parcelas = $valor/$j;
$parcelas = number_format($parcelas, 2, '.', '');

$sem =  "discover#".$pedido."#2#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($sem)."'>

".sprintf(GetLang('ParDisSem'),$j,CurrencyConvertFormatPrice($parcelas,1,0))."

<br>
";

}else{

$parcelas = $this->parcelar($valor, $juros, $j);
$parcelas = number_format($parcelas, 2, '.', '');

$com =  "discover#".$pedido."#".$tipojuros."#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($com)."'>

".sprintf(GetLang('ParDisCom'),$j,CurrencyConvertFormatPrice($parcelas,1,0),CurrencyConvertFormatPrice($parcelas*$j,1,0))."

<br>
";
}

}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 
//fim do discover



//começo amex


$par1 = "amex#".$pedido."#1#1#".md5($valor);
$help .= "<div id='ame' style='display:none;'>
<br>&nbsp;&nbsp;&nbsp;<h3>".GetLang('Amex')."</h3>
&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($par1)."'>

".sprintf(GetLang('ParAmex1x'),CurrencyConvertFormatPrice($valor,1,0))."

<br>";

for($j=2; $j<=$div;$j++) {


if($semjuros>=$j) {

$parcelas = $valor/$j;
$parcelas = number_format($parcelas, 2, '.', '');

$sem =  "amex#".$pedido."#2#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($sem)."'>


".sprintf(GetLang('ParAmexSemCielo'),$j,CurrencyConvertFormatPrice($parcelas,1,0))."
<br>
";

}else{

$parcelas = $this->parcelar($valor, $juros, $j);
$parcelas = number_format($parcelas, 2, '.', '');

$com =  "amex#".$pedido."#".$tipojuros."#".$j."#".md5($valor);

$help .= "&nbsp;&nbsp;<input type='radio' id='forma' name='forma' value='".base64_encode($com)."'>


".sprintf(GetLang('ParAmexComCielo'),$j,CurrencyConvertFormatPrice($parcelas,1,0),CurrencyConvertFormatPrice($parcelas*$j,1,0))."
<br>
";
}

}

$help .= "
<br>
<a onclick=\"javascript:pegavalor();\"><img src='".$GLOBALS['ShopPath']."/modules/checkout/cielo/images/pagar.gif'>
</a>
</div>"; 


//fim amex
if($juros>0){
$jurosmsg= sprintf(GetLang('Juros'),$juros);
}else{
$jurosmsg= "";
}


//mostra as formas de pagamento e a frase de valor minimo
return $help."<br>".$jurosmsg."".sprintf(GetLang('MinCielo'),$minima);

}else{

return "<br>Nenhum meio de pagamento ativo para este modulo!";

}

}else{

return "";

}

}//fim da funcao

//fim da classe
}
?>
