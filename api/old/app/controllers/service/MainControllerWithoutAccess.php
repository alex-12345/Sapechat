<?php

namespace controllers\service;


class MainControllerWithoutAccess{
	
	protected function jsonOutput($arr){
		echo json_encode($arr);
	}
	
}