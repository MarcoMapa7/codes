<?php
function getGooglePageSpeedScreenshot($site, $img_tag_attributes = "border='1'") {
    #initialize
    $use_cache = false;
    

    if(!$use_cache) {
        $image = file_get_contents("https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=$site&screenshot=true");
        $image = json_decode($image, true);
        $image = $image['screenshot']['data'];

    }

    $image = str_replace(array('_', '-'), array('/', '+'), $image);
    return "<img src=\"data:image/jpeg;base64,".$image."\" $img_tag_attributes />";
}

echo getGooglePageSpeedScreenshot('https://loja.produtosasos.com.br/produtosasos', '');
echo getGooglePageSpeedScreenshot('https://loja.produtosasos.com.br/pesquisa/teste', '');
echo getGooglePageSpeedScreenshot('https://escritorio.produtosasos.com.br/rede_adicionar.asp?upgrade=1&loja=1', '');
?>
