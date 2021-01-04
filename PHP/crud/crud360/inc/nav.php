<!--<nav class="navbar navbar-light bg-faded">
<div class="container">
  <a class="navbar-brand" href="index.php">Crud360</a>
  <ul class="nav navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="crud360_example1.php">Example 1</a>
    </li>
    <li class="nayv-item">
      <a class="nav-link" href="crud360_example2.php">Example 2</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="crud360_example3.php">Example 3</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="crud360_example4.php">Example 4</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="crud360_example5.php" target="_blank">Example 5 (No Layout)</a>
    </li>

  </ul>
</div>
</nav>
<div style="padding:15px;"></div>-->
<nav class="navbar navbar-light bg-faded">
<div class="container">
  <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
  <div class="collapse navbar-toggleable-md" id="navbarResponsive">
    <a class="navbar-brand" href="index.php"><strong style="color:#0068C9">Crud360</strong></a>
    <ul class="nav navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="responsiveNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Examples</a>
        <div class="dropdown-menu" aria-labelledby="responsiveNavbarDropdown" id="responsiveNavbarDropdown1">
          <a class="dropdown-item" href="crud360_example1.php">Example 1</a>
          <a class="dropdown-item" href="crud360_example2.php">Example 2</a>
          <a class="dropdown-item" href="crud360_example3.php">Example 3</a>
          <a class="dropdown-item" href="crud360_example4.php">Example 4</a>          
          <a class="dropdown-item" href="crud360_example5.php">Example 5</a>          
          <a class="dropdown-item" href="crud360_example6.php">Example 6</a>          
          <a class="dropdown-item" href="crud360_example7.php">Example 7</a>          
          <a class="dropdown-item" href="crud360_example8.php">Example 8</a>          
          <a class="dropdown-item" href="crud360_example9.php">Example 9</a>          


        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?lic=true">License Agreement</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://orbit360.net/crud360">Project Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://orbit360.net/crud360/forum/">Forum</a>
      </li>

    </ul>
  </div>
</div>
</nav>
<style>
	.examples {
		text-align:center;
		background:#fbfbfb;
	}
	.examples .example-item {
    display: inline-block;
		padding:10px 20px;
		margin:10px;
	}
	.selected-example {
		color:#bbb !important;
	}
	.selected-example:hover {
		text-decoration:none
	}
</style>

<?php 
$page = explode("/",($_SERVER['PHP_SELF']));
$page = $page[count($page)-1];
if((strpos($page,"crud360_example")!==false))
{?>
	<div class="container-fluid examples">
        <div class="container">
             <a class="example-item <?php if($page=='crud360_example1.php') echo 'selected-example';?>" href="crud360_example1.php">Example 1</a>
              <a class="example-item <?php if($page=='crud360_example2.php') echo 'selected-example';?>" href="crud360_example2.php">Example 2</a>
              <a class="example-item <?php if($page=='crud360_example3.php') echo 'selected-example';?>" href="crud360_example3.php">Example 3</a>
              <a class="example-item <?php if($page=='crud360_example4.php') echo 'selected-example';?>" href="crud360_example4.php">Example 4</a>          
              <a class="example-item <?php if($page=='crud360_example5.php') echo 'selected-example';?>" href="crud360_example5.php">Example 5</a>          
              <a class="example-item <?php if($page=='crud360_example6.php') echo 'selected-example';?>" href="crud360_example6.php">Example 6</a>          
              <a class="example-item <?php if($page=='crud360_example7.php') echo 'selected-example';?>" href="crud360_example7.php">Example 7</a>          
              <a class="example-item <?php if($page=='crud360_example8.php') echo 'selected-example';?>" href="crud360_example8.php">Example 8</a>          
              <a class="example-item <?php if($page=='crud360_example9.php') echo 'selected-example';?>" href="crud360_example9.php">Example 9</a>          
    
        </div>
    </div>
<?php }
?>