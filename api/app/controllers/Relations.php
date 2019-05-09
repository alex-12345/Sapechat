<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\{Relations as Model, User};
use app\controllers\service\{RestrictedAccess, Reporter};


class Relations extends RestrictedAccess{
	
	use service\Singleton;
	
	private static $relation_status;
	private static $friend_id;
	
	private function checkInputAndSetRelationStatus():bool{
		if(!Model::checkParametrs($_REQUEST, ["friend_id","token"]))
			return Reporter::error_report(1);
		
		if(!parent::setUserId($_REQUEST["token"]))
			return Reporter::error_report(101);
		self::$friend_id =  intval($_REQUEST["friend_id"]);
		if(!Model::setDBSession()){
			return false;
		}
		self::$relation_status = Model::checkRelation(self::$current_user_id, self::$friend_id);
		return true;
	}
	
	/*
	 * Проверка отношения текущего пользователя с другим пользователем
	 * @param int http get[friend_id]
	 * @param str http get[token] 
	 
	 */
	public function checkRelation():bool{
		
		if(!self::checkInputAndSetRelationStatus()) return false;
		return Reporter::output(["relation_status" => self::$relation_status]);
	}
	
	/*
	 * Создание заявки добавления в друзья
	 * @param int http get[friend_id]
	 * @param str http get[token] 
	 
	 */
	 
	public function createFriendRequest():bool{
		if(!self::checkInputAndSetRelationStatus()) return false;
		if(self::$relation_status !== 0)
			return Reporter::error_report(20);
		
		if(!User::userExistenceCheck(self::$friend_id))
			 return Reporter::error_report(15);
			 
		 if(!Model::addFriendRequest(self::$current_user_id, self::$friend_id))
			 return Reporter::error_report(100);
		 
		 return Reporter::output_no_errors();
	}
	
	/*
	 * Прием входящей заявки в дурзья
	 * @param int http get[friend_id]
	 * @param str http get[token] 
	 
	 */
	 
	public function acceptFriendRequest():bool{
		if(!self::checkInputAndSetRelationStatus()) return false;
		if(!(self::$relation_status == 1 or self::$relation_status === 3))
			return Reporter::error_report(21);
			 
		 if(!Model::acceptOrRejectFriendRequest(self::$current_user_id, self::$friend_id, 2))
			 return Reporter::error_report(22);
		 
		 return Reporter::output_no_errors();
		
	}
	/*
	 * Перенос в подписчики входящей заявки в дурзья
	 * @param int http get[friend_id]
	 * @param str http get[token] 
	 
	 */
	public function rejectFriendRequest():bool{
		if(!self::checkInputAndSetRelationStatus()) return false;
		if(self::$relation_status !== 1)
			return Reporter::error_report(23);
			
		if(!Model::acceptOrRejectFriendRequest(self::$current_user_id, self::$friend_id, 3))
			 return Reporter::error_report(22);
		 
		 return Reporter::output_no_errors();
		
	}
	
	public function cancelFriendRequest():bool{
		if(!self::checkInputAndSetRelationStatus()) return false;
		if(self::$relation_status !== 1 and self::$relation_status !== 3)
			return Reporter::error_report(21);
			
		if(!Model::cancelFriendRequest(self::$current_user_id, self::$friend_id))
			 return Reporter::error_report(21);
		 
		 return Reporter::output_no_errors();
	}
	public function removeFriend():bool{
		if(!self::checkInputAndSetRelationStatus()) return false;
		if(self::$relation_status !== 2)
			return Reporter::error_report(24);
			
		if(!Model::removeFromFriends(self::$current_user_id, self::$friend_id))
			 return Reporter::error_report(24);
		 
		 return Reporter::output_no_errors();
		
		
	}
	
}

