<?php 
	$x = 0;
	if($x>0){
		echo '<BR>Xis é maior que zero';
	}elseif($x==0){
		echo '<BR>Xis é zero';
	}else{
		echo '<BR>Xis é menor que zero';
	}

	iif($x>0, '<BR>Xis é maior que zero', 'Xis NÃO é maior que zero');
?>