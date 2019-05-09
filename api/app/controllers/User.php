<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\User as Model;
use app\controllers\service\Reporter;


class User{
	
	use service\Singleton;
	
	/*
	 * Вывод информации о пользователе
	 * @param int http get[id]
	 * @param str http get[param] //user_id,user_first_name,user_img,user_last_name,user_email,user_birthday
	 */
	public function getUserInfoByParametrs():bool{
		
		if(!Model::checkParametrs($_REQUEST, ["id","param"])){
			Reporter::error_report(1);
			return false;
		};
		if(!Model::setDBSession()){
			return false;
		}
		if(!Model::checkAndSetParametrs($_REQUEST["param"])){
			Reporter::error_report(3);
			return false;
		};
		
		$data = Model::getUserInfoByParametrs(intval($_REQUEST["id"]));
		if(empty($data)){
			Reporter::error_report(4);
			return false;
		};
		Reporter::output($data);
		return true;
	}
	/*
	 * вывод amount друзей пользователя id начиная с start
	 * @param int http get[id]
	 * @param int http get[amount]
	 * @param int http get[start]
	 * @param void http get[random_order] - если указан, то вывести в рандомном порядке
	 * @param void http get[amount_friends] - если указан, то вывести и количество друзей
	 * @return bool
	 */
	 public function getUserFriend():bool{
		if(!Model::checkParametrs($_REQUEST, ["id","amount", "start"])){
			Reporter::error_report(1);
			return false;
		};
		if(!Model::setDBSession()){
			return false;
		}
		$id = intval($_REQUEST['id']);
		$amount = intval($_REQUEST['amount']);
		$start = intval($_REQUEST['start']);
		(isset($_REQUEST['random_order'])) ? $flag = true : $flag = false;
		if((intval($amount) > 100)or (intval($amount) < 1)){
			Reporter::error_report(5);
			return false;
		}
		$output_arr = Model::getFriends($id, $amount, $start, $flag);
		if(isset($_REQUEST['amount_friends'])){ 
			$count = Model::getFriendsCount($id); 
			$output_arr = ["amount_friends" => $count, "friends_list" => $output_arr];
		}
		Reporter::output($output_arr);
		return true;
	}
	
	public function friendsAmount():bool{
		if(!Model::checkParametrs($_REQUEST, ["id"])){
			Reporter::error_report(1);
			return false;
		}
		if(!Model::setDBSession()){
			return false;
		}
		Reporter::output(["amount_friends" => Model::getFriendsCount(intval($_REQUEST['id']))]);
		return true;
	}
	
	
	/*
	 * вывод amount постов пользователя id начиная с start
	 * @param int http get[id]
	 * @param int http get[amount]
	 * @param int http get[start]
	 * @param void http get[owm_posts] - если указан, то вывести только посты пользователя
	 * @return bool
	 */
	 public function outputPosts():bool{
		if(!Model::checkParametrs($_REQUEST, ["id","amount", "start"])){
			Reporter::error_report(1);
			return false;
		};
		if(!Model::setDBSession()){
			return false;
		}
		$id = intval($_REQUEST['id']);
		$amount = intval($_REQUEST['amount']);
		$start = intval($_REQUEST['start']);
		(isset($_REQUEST['owm_posts'])) ? $flag = true : $flag = false;
		if((intval($amount) > 100)or (intval($amount) < 1)){
			Reporter::error_report(5);
			return false;
		}
		Reporter::output(Model::getPostsFromPage($id, $amount, $start, $flag));
		return true;
	}
	
	public function postsAmount():bool{
		if(!Model::checkParametrs($_REQUEST, ["id"])){
			Reporter::error_report(1);
			return false;
		}
		if(!Model::setDBSession()){
			return false;
		}
		(isset($_REQUEST['own_posts'])) ? $flag = true : $flag = false;
		Reporter::output(["amount_posts" => Model::getPostsCount(intval($_REQUEST['id']), $flag)]);
		return true;
	}
}

