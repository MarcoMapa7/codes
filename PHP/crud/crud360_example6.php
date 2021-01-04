<?php 
// EASY SETUP
// Set your database name, database user, database password and database name in crud360/includes/class.config.php
include_once("crud360/includes/class.crud360.php"); 
$obj_table = new Crud360("users");
//Call process method to process all get/post request (live/ajax),
//!!!!!!!!You must call it before any html is rendered!!!!!!!!!!!
//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
Crud360::process([$obj_table]);
//Begin including html (css, js, head section)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crud360 - Painless Admin Panel Setup!</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="crud360/css/bootstrap/bootstrap.css">
<link rel="stylesheet" href="crud360/css/crud360.css">
<link rel="stylesheet" href="crud360/css/datetimepicker/jquery.datetimepicker.css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!--
/*---------------------------------------------------------------------*\
| Removal of the following attribution text will be considered a 		|
| violation of Crud360's AAL license. Do not remove it. 				|
\*---------------------------------------------------------------------*/
/*------------------------------ NOTICE -------------------------------*\
| 			Product Name	:	Crud360			    					|
|   		Organization	: 	Orbit360 (R)							|
| 			Type			:	Create, Read, Update & Delete CodeGen	|
| 			Author			:	Usman Mughal							|
| 			Created			:	24-11-2016								|
| 			Updated			:	25-11-2016								|
| 			Doctype			:	PHP										|
| 			Version			:	1.0b									|
| 			Copyright		:	Orbit360(R) - http://orbit360.net		|
| 			License			:	Attribution Assurance License			|
|							    https://opensource.org/licenses/AAL		|
|								read LICENSE.md for more info			|
| 			Dependencies	:	bootstrap 4.0, jquery 1.11.2,       	|
|							    tinymce 4.4.3, maskedinput 1.4.1    	|
|			Platform		:	LAMP/WAMP 								|
\-----------------------------------------------------------------------/
-->
</head>
<body>
<?php include_once("crud360/inc/nav.php");?>
<div class="container-fluid">
<h3 align="center"> <strong>Example 6:</strong> Minimal Easy Setup (One complete page without header/footer php includes).</h3>
<p align="center"> 

If your pages are inside another directory (not on the root of crud360), you will need to use this file
and adjust paths of all included php/js/css files manually<br>
Note: Do not remove crud360.css file, you can make modifications in the file if you know what you're doing.</p>
<?php 
//Use defaultDivs method to place informatory message divs, wherever you will place this call, it will load messages there.
Crud360::defaultDivs(); 
$obj_table->magic();	
?>
<p align="center"><strong><a class="btn btn-primary" href="index.php">Go Back!</a></strong></p>
</div>
<div class="container-fluid" align="center">
<footer>
<!--
/*---------------------------------------------------------------------*\
| Removal of the following attribution text & links will be considered	|
| a violation of our AAL license. Do not remove it. 					|
\*---------------------------------------------------------------------*/
-->
<hr>
<p style="font-size:13px">Powered by <strong><a target="_blank" href='http://orbit360.net/crud360'>Crud360</a></strong> | Developed & Maintained by <a target="_blank" href="http://orbit360.net"><strong>Orbit360 &reg;</strong></a><br>
    Distributed Under <a target="_blank" href="https://opensource.org/licenses/AAL">Attribution Assurance License</a>
</p>
</footer>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="crud360/js/jquery/jquery-1.11.2.min.js"></script> 
<script src="crud360/js/datetimepicker/jquery.datetimepicker.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="crud360/js/tether/tether.min.js"></script>
<script src="crud360/js/bootstrap/bootstrap.min.js"></script>
<script src="crud360/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="crud360/js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
<script src="crud360/js/commonjs.js" type="text/javascript"></script>
</body>
</html>
<?php Crud360::javascript([$obj_table]); ?>