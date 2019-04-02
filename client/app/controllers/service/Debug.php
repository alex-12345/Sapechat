<?php
declare(strict_types=1);
namespace controllers\service;

class Debug{

	public static output(array $arr):?string{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}