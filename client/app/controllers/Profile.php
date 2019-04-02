<?php
declare(strict_types=1);
namespace controllers;

class Profile {

	public function init():?bool{
		//проверяем сессию
		//если ее нет переадресация
		if(!isset($_SESSION['user_id']) or !isset($_SESSION['user_token'])){
			header('Location: '.APP_URL.'/login');
			exit();
		}

		//получить данные по запросу на api либо перенаправление
		return true;
	}

	public function render():bool{
		return true;
	}

	}