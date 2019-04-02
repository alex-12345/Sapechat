<?php
declare(strict_types=1);

function debug_arr(array $arr):?int{
	echo "<pre>";
	print_r($arr); 
	echo "</pre>";	
	return null;
}

function debug(string $str):?string{
	echo "<p>";
	echo $str; 
	echo "</p>";	
	return null;
}