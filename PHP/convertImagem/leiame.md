<pre>
//EX
$load= new SaveAndConvertImg();

$load->patch = './img';

$load->url = 'https://www.google.es/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png';

$load->name = 'logo_google';

$load->convert = 'jpg';
echo $load->ReturnImage();
</pre>
