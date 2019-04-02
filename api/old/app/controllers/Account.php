<?php

namespace controllers;

use model\Account as u_account;
use controllers\service\MainController;


class Account extends MainController{
	
	public function __construct(){
		parent::__construct();
	}
	/*
	 * Обновить время действия токена на месяц после вызова метода
	 * http://localhost:8090/account-tokenExtension?token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function tokenExtension(){
		$account = new u_account();
		
		
		if($account->tokenExtension($_GET['token'])){
			self::jsonOutput(["error" => 0, "token" => $_GET['token'], "id" => $this->user_id]);
		}else{
			systemError(1, "Неизвестная ошибка!");
		}
	}
	
	
	/*
	 * удалить токен (выход из аккаунта)
	 * http://localhost:8090/account-logout?token=17_ecaa6f2629bb1c54cab1a85225bf97cfbae48283b1544219709
	 */
	public function logout(){
		$account = new u_account();
		if($account->tokenRemove($_GET['token'])){
			self::jsonOutput(["error" => 0]);
		}else{
			systemError(1, "Неизвестная ошибка!");
		}
	}
	
}

