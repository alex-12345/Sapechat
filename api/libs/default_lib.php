<?php
declare(strict_types=1);

function debug(array $arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function creactePDO():Memcache{
	$memcache_obj = new Memcache;
$memcache_obj->connect('localhost', 11211);
	return $memcache_obj;
}