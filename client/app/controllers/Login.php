<?php
declare(strict_types=1);
namespace controllers;

use controllers\service\TamplateLoader;

class Login{

	public function init():bool{
		return true;
	}

	public function render():bool{
		TamplateLoader::load(["header", "unoauth_top","login"], ["errors","style"], ["cookie","ajax", "login"]);
		return true;
	}


} 