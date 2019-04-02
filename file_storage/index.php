<?php
declare(strict_types=1);

header("Access-Control-Allow-Origin: http://localhost:9091");

//$start = microtime(true);
require_once("config.php");
require_once("lib.php");
require_once("uploadImg.php");
require_once("reporter.php");

$method = $_SERVER['REQUEST_METHOD'];

if($method === "POST"){
	if(!(UploadImg::setfile($_FILES['photo'], "token", 13))){
		echo Reporter::error_report(1);
		exit();
	}; 
	
	if(!(UploadImg::checkUpload())){
		echo Reporter::error_report(2);
		exit();
	}; 
	
	if(!(UploadImg::checkFormat())){
		echo Reporter::error_report(3);
		exit();
	};
	
	if(!(UploadImg::createTempImage())){
		echo Reporter::error_report(4);
		exit();
	};

	if(!(UploadImg::checkDimension())){
		echo Reporter::error_report(5);
		exit();
	};

	UploadImg::resizeImage();
	$main_url = UploadImg::saveImg();
	if($main_url === ""){
		echo Reporter::error_report(6);
		exit();
	}


	echo Reporter::upload_success(STORAGE_URL.$main_url);
	
	
	
}else{
	
}
//echo 'Время выполнения скрипта: '.(microtime(true) - $start).' сек.';
