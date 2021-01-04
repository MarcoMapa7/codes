<?php

require_once __DIR__ . '/simplexlsx.class.php';

if ( $xlsx = SimpleXLSX::parse('teste.xlsx')) {
	echo '<h1>$arquivo->linhas()</h1>';
	echo '<pre>';
	print_r( $xlsx->rows() );
	echo '</pre>';

	echo '<h1>$xlsx->rowsEx()</h1>';
	echo '<pre>';
	print_r( $xlsx->rowsEx() );
	echo '</pre>';
} else {
	echo SimpleXLSX::parse_error();
}
?>