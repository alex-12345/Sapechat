<?php

namespace controllers;

use model\FeedDataWithoutAccess;
use controllers\service\MainControllerWithoutAccess;


class MainFeed extends MainControllerWithoutAccess{
	/*
	 * Вывод информации о пользователе
	 * @param int user_id (get)
	 * http://localhost:8090/mainFeed-getUserInfo?user_id=1
	 */
	public function getUserInfo(){
		if(!isset($_GET['user_id']) or (intval($_GET['user_id']) < 1)){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$FeedData = new FeedDataWithoutAccess();
		$arr = $FeedData->getUserInfo(intval($_GET['user_id']));
		if(count($arr) === 0){
			systemError(404, "Ошибка! Такого пользователя не существует");
		}else{
			self::jsonOutput(["error" => 0, "user_info" => $arr]);
		}
	}
	
	/*
	 * Вывод постов на стене пользователя
	 * @param int wall_id (get)
	 * @param int amount (get)
	 * @param int start (get)
	 * http://localhost:8090/mainFeed-getWallPosts?wall_id=1&amount=10&start=0
	 */
	public function getWallPosts(){
		if(!isset($_GET['wall_id']) or !isset($_GET['amount']) or !isset($_GET['start'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		if(intval($_GET['wall_id']) < 1 or intval($_GET['amount']) < 1 or intval($_GET['start']) < 0){
			systemError(6, "Ошибка, какой-то параметр задан некорректно!");
		}
		$FeedData = new FeedDataWithoutAccess();
		$arr = $FeedData->getWallPosts(intval($_GET['wall_id']), intval($_GET['amount']), intval($_GET['start']));
		if(count($arr) === 0){
			systemError(404, "Ошибка! Такой стены не существует, либо на ней нет еще ни 1 записи.");
		}else{
			$result_arr = $FeedData->mergeWithUser($arr, 'user_id'); 
			self::jsonOutput(["error" => 0, "wall_posts" => $result_arr]);
		}
	}
	
	/*
	 * Вывод собственных постов на стене пользователя
	 * @param int user_id (get)
	 * @param int amount (get)
	 * @param int start (get)
	 * http://localhost:8090/mainFeed-getWallUserPosts?user_id=1&amount=10&start=0
	 */
	public function getWallUserPosts(){
		if(!isset($_GET['user_id']) or !isset($_GET['amount']) or !isset($_GET['start'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		if(intval($_GET['user_id']) < 1 or intval($_GET['amount']) < 1 or intval($_GET['start']) < 0){
			systemError(6, "Ошибка, какой-то параметр задан некорректно!");
		}
		$FeedData = new FeedDataWithoutAccess();
		$arr = $FeedData->getWallUserPosts(intval($_GET['user_id']), intval($_GET['amount']), intval($_GET['start']));
		if(count($arr) === 0){
			systemError(404, "Ошибка! Такой стены не существует, либо на ней нет еще ни 1 записи.");
		}else{
			$result_arr = $FeedData->mergeWithUser($arr, 'user_id');
			self::jsonOutput(["error" => 0, "wall_posts" => $result_arr]);
		}
	}
	
	
	/*
	 * Вывод определенного кол-ва друзей пользователя
	 * @param int user_id (get)
	 * @param int amount (get)
	 * @param int start (get)
	 * http://localhost:8090/mainFeed-getUserFriends?user_id=1&amount=10&start=0
	 */
	public function getUserFriends(){
		if(!isset($_GET['user_id']) or !isset($_GET['amount']) or !isset($_GET['start'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		if(intval($_GET['user_id']) < 1 or intval($_GET['amount']) < 1 or intval($_GET['start']) < 0){
			systemError(6, "Ошибка, какой-то параметр задан некорректно!");
		}
		$FeedData = new FeedDataWithoutAccess();
		$arr = $FeedData->getUserFriends(intval($_GET['user_id']), intval($_GET['amount']), intval($_GET['start']));
		if(count($arr['relation_data']) === 0){
			systemError(404, "Ошибка! Такого пользователя не существует либо у него нет ни 1 друга.");
		}else{
			foreach($arr['relation_data'] as $id => $value){
					if(empty($value['user_img'])){
						$arr['relation_data'][$id]['user_img'] = NO_IMG;
					}
			}
			self::jsonOutput(["error" => 0, "user_friends" => $arr]);
		}
	}
	
	/*
	 * Вывод стран
	 * http://localhost:8090/mainFeed-getCountries
	 */
	public function getCountries(){
		$FeedData = new FeedDataWithoutAccess();
		self::jsonOutput(["error" => 0, "countries" => $FeedData->getCountries()]);
	}
	
	/*
	 * Вывод городов определнной страны
	 * @param int country_id
	 * http://localhost:8090/mainFeed-getCities?city_id=1
	 */
	public function getCities(){
		if(!isset($_GET['city_id'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$FeedData = new FeedDataWithoutAccess();
		self::jsonOutput(["error" => 0, "cities" => $FeedData->getCities(intval($_GET['city_id']))]);
	}
}

