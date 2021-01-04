<?php 
// EXAMPLE 1
include_once("crud360/includes/class.crud360.php"); 
//Create objects here
$users = new Crud360("users");
$users->columns(["name","username","email","dob"]);


$users->setLookupFields("status_id","statuses","id","title");
$users->setLookupFields("department_id","departments","id","title");

$users->formatField("name","img","title='Hello'",["images/"]);
$users->width("username","50%");
$users->formatField("username","video","mp4");

$users->formatField("email","link","http://google.com");


$users->formatField("dob","date","m/d/Y");

//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
//This call processes all form requests for all the objects
Crud360::process([$users]);
//Include bootstrap, datepicker, and essential crud360
include_once("crud360/inc/header.php");
?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container">
<?php Crud360::defaultDivs(); ?>
<h3 align="center"> <strong>Example 1:</strong> Format fields to suit your needs</h3>
<p align="center"> There are 5 types of formats currently supported, Image, Video, Link , Date & HexColor, please review code carefully to understand how it works!</p>
<?php 		
       // this method must be called within a renderable region of an html page, it displays records, creates neccessary forms etc...
		$users->magic();	
    ?>
<?php  Crud360::renderSource(__FILE__) ; // display source of this current file ?>
   
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php Crud360::javascript([$users]); ?>