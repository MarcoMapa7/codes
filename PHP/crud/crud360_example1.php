<?php 
// EXAMPLE 1
include_once("crud360/includes/class.crud360.php"); 
//Create objects here
$users = new Crud360("users");
$users->paginate(2);
//$users->columns(["avatar","username","email","dob","favorite_color"]);
// best to link tables if your database has foriegn keys, otherwise it will be a problem
$users->setLookupFields("status_id","statuses","id","title");
$users->setLookupFields("department_id","departments","id","title");
$users->formatField("avatar","img");
$users->formatField("dob","date","m/d/Y");

$users->addFormTpl("users");
$users->formatField("favorite_color","htmlColor");
$users->setInputType("favcolor","select");

//$users->where("where id>:id",["id"=>24]);


//This call processes all form requests for all the objects 
//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
Crud360::process([$users]);
//Include bootstrap, datepicker, and essential crud360
include_once("crud360/inc/header.php");
?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container-fluid">
<?php Crud360::defaultDivs(); ?>
<h3 align="center"> <strong>Example 1:</strong> Set up a single table on a single page! with all fields displayed (full width)</h3>
<?php 		
       // this method must be called within a renderable region of an html page, it displays records, creates neccessary forms etc...
		$users->magic();	
    ?>
<?php  Crud360::renderSource(__FILE__) ; // display source of this current file ?>
   
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php Crud360::javascript([$users]); ?>