<?php 
// EXAMPLE 3
include_once("crud360/includes/class.crud360.php"); 
//Create objects here
$users = new Crud360("users");
$users->addFormTpl("users");
//link status_id with table statuses, use value of 'id' from statuses as option value, and 'title' as option text
$users->setLookupFields("status_id","statuses","id","title");
// link (just as above)
$users->setLookupFields("department_id","departments","id","title");
//Override default title that shows in column heads in records table or on form labels for field department_id
// System automatically guesses best title, but you can always override any of them
$users->title("department_id","Department");
$users->title("status_id","Status");
$users->paginate(1);
$users->formatField("name","img","",["images/"]);

// set which columns to display in database
$users->columns(["name","department_id","email","status_id"]);
//This call processes all form requests for all the table objects
//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
Crud360::process([$users]);
//Include bootstrap, datepicker, and essential crud360
include_once("crud360/inc/header.php");
?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container"><?php Crud360::defaultDivs(); ?>
    <h3 align="center"> <strong>Example 3:</strong> Set up a single table on a single page with a custom template!</h3>
    <p align="center">If there's a linked table field, there will be a small arrow preceeding that field's values indicating they're connected to another table and that this current table depends on another one, hover over a linked value to see more info!</p>
	<?php	
           // this method must be called within a renderable region of an html page, it displays records, creates neccessary forms etc...
            $users->magic();	
    ?>
    <?php  Crud360::renderSource(__FILE__) ; // display source of this current file ?>
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php Crud360::javascript([$users]); ?>
