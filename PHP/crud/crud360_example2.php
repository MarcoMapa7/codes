<?php 
// EXAMPLE 2
include_once("crud360/includes/class.crud360.php"); 
//create all table objects here
$tables = Crud360::allObjects();
//process all table objects here
for($i=0;$i<count($tables);$i++)
{
	$tables[$i]->paginate(1);
	$tables[$i]->clipLongText(true);
	if($tables[$i]->getTableName()=='users')
	{
		$tables[$i]->setInputType("password","password");
		$tables[$i]->maskPasswords(false);
	}
	// since crud360 table schema includes an id column for all tables, this call will work! and hide id from record/forms	
	$tables[$i]->supress("id");	
	// force sql order by asc, default is desc
	$tables[$i]->order("asc");	
	// force sql order by asc, default is desc	
	//$tables[$i]->paginate(3);	
	$tables[$i]->showSerial(true);

}
//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
Crud360::process($tables);
//if this approach is used, to call function
// you will always need to use index of object
// not a good practice.
//Include bootstrap, datepicker, and essential crud360
include_once("crud360/inc/header.php");
?>
<?php include_once("crud360/inc/nav.php"); ?>
<div class="container">
<h3 align="center"> <strong>Example 2:</strong> All database tables with records on a single page</h3>
<?php  
	Crud360::defaultDivs(); 
	// this method must be called within a renderable region of an html page, it displays records, creates neccessary forms etc...
	Crud360::allMagic($tables);
  	Crud360::renderSource(__FILE__) ; // display source of this current file 
?>
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php Crud360::javascript($tables); ?>;