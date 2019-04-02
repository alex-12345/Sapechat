<?php

namespace controllers\service;


class MainController{
	protected $user_id;
	
	protected function __construct(){
		if(!isset($_GET['token'])){
			systemError(19, "Ошибка токен не был передан!");
		}
		$this->user_id = self::checkToken($_GET['token']);
		if($this->user_id == 0){
			systemError(15, "Отказ доступа! Токен либо устарел либо он неверный.");
		}
	}
	protected function checkToken(string $token){
		global $db;
		$nowTime = time();
		$collection = $db->sessions->tokens;
		$coll = $collection->findOne(["token" => $token]);
		if($coll){
			$arr = iterator_to_array($coll);
			
			if(!isset($arr["expiration_time"]) or intval($arr["expiration_time"]) < $nowTime){
				//время вышло
				$collection->remove(["_id" => $arr['_id']]);
				return 0;
			}else
				return $arr['id'];
		}else{
			return 0;
		}
	}
	
	protected function jsonOutput($arr){		
	header('Access-Control-Allow-Origin: *');
		echo json_encode($arr);
	}
	
}