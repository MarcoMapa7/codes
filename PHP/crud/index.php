<?php include_once("crud360/includes/class.crud360.php"); ?>
<?php include_once("crud360/inc/header.php");?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container">
<h1 align="center"><strong>Crud360</strong>, Effortlessly Deploy Your Admin Panel!</h1>
<p align="center">For questions, mail at <strong>usman@orbit360.net</strong></p>
<h4>Feature List</h4>
<p>Including but not limited to:</p>
<ul>

<li>PDO based (SQL injection free)</li>
<li>Use 'where' clause (hide certain rows if you know SQL)</li>
<li>Hide/Show columns &amp; change order of columns/form fields</li>
<li>Link values to other tables (value/title pair must be specified)</li>
<li>Displays dropdowns against linked values (with 'where' clause filter (named placeholders :name) paired with associative key->val array to be used ) see examples</li>
<li>Override linked value dropdowns with radios (checks experimental)</li>
<li>Display custom dropdown values (by supplying an associative key/value pair array)</li>
<li>Show Compound values (from more than one columns using SQL CONCAT) in linked values</li>
<li>Show Compound values (from more than one columns using SQL CONCAT) in reports values</li>
<li>Auto Column Names</li>
<li>Auto Table Name Headings</li>
<li>Override Column Heading</li>
<li>Format column value(s) (as image, video, link, date, hexcolor )</li>
<li>Force input types (override defaults)</li>
<li>Set Rich text fields (using tinymce)</li>
<li>Set a field as password</li>
<li>Auto date/datetime/timestamp picker</li>
<li>Override form templates using simple tpl files</li>
<li>Clip column values (all, certain fields)</li>
<li>Auto hide excess columns on mobile view</li>
<li>Adjust to mobile view</li>
<li>Load as many tables as you want on a single page</li>
<li>Style as per your needs (your own layout)</li>
<li>No javascript to write</li>
<li>Enforces a primary key with auto_increment (if your table lacks a Primary key and an auto_increment field Crud360 will not work)	</li>
<li>Set inputs autorequired (based on database null/not null values	</li>
<li>Set inputs required explicitly</li>
<li>Set inputs readonly	</li>
<li>Auto readonly for timestamps</li>
<li>Prevention of primarykey editing </li>
<li>And Much More!!! Explore source comments / Examples for more info.</li>
</ul>

<h4>Enhancements planned, any contribution is welcomed!</h4>
<ul>
<li>Handling of file type fields</li>
<li>Adding "checkbox" functionality</li>
<li>Add Custom Themes</li>
</ul>


<h4>What's included</h4>
<div class="source" style="height:450px; overflow:scroll; border-radius:0">
<?php 
function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ol>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li style="font-size:12px">'.$ff;
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</li>';
        }
    }
    echo '</ol>';
}
listFolderFiles('./');
?>

</div>

<?php include_once("crud360/inc/examples.php");?>
  
</div>
<?php include_once("crud360/inc/footer.php"); ?>