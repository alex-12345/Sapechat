<?php

namespace controllers;

use model\userFeed as u_feed;
use controllers\service\MainController;
use controllers\service\MergeWithUser as MWU;


class UserFeed extends MainController{
	use MWU;
	
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 * Вывод части последних постов ленты пользователя
	 * @param int amount (get)
	 * @param int start (get)
	 * http://localhost:8090/userFeed-getLastsFeeds?amount=20&start=0&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function getLastsFeeds(){
		if(!isset($_GET['amount']) or !isset($_GET['start']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$userFeed = new u_feed();
		$arr = $userFeed->getLastFeed($this->user_id, intval($_GET['amount']), intval($_GET['start']));
		if(count($arr) === 0){
			systemError(404, "Ошибка, ни одного поста не найдено!");
		}else{
			self::jsonOutput(["error" => 0, "posts" => self::mergeWithUser($arr, "user_id")]);
		}
	}
	
	/*
	 * Получение краткой информации о себе
	 * http://localhost:8090/userFeed-getBriefUserInfo?token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function getBriefUserInfo(){
		$userFeed = new u_feed();
		$arr = $userFeed->getBriefUserInfo($this->user_id);
		if(count($arr) === 0){
			systemError(404, "Ошибка, информации о таком пользователе не найдено!");
		}else{
			self::jsonOutput(["error" => 0, "user_info" => $arr]);
		}
	}
	
}

