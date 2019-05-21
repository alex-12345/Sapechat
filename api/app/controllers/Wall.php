<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\{Wall as Model, User};
use app\controllers\service\{RestrictedAccess, Reporter};


class Wall extends RestrictedAccess{
	use service\Singleton;
	private $user_id;
	private $text;
	private $wall_id;
	
	public function addPost():bool{
		
		if(!Model::checkParametrs($_REQUEST,["text","wall_id","token"]))
			return Reporter::error_report(1);
			
		$this->text = $_REQUEST["text"];
		$this->wall_id = intval($_REQUEST["wall_id"]);
		
		if(!parent::setUserId($_REQUEST["token"])) return Reporter::error_report(101);
		
		if(!User::userExistenceCheck($this->wall_id)) return Reporter::error_report(4);
		if(empty($this->text)) return Reporter::error_report(40);
		if(!Model::setDBSession()) return false;
		$post_id = Model::addPost(self::$current_user_id, $this->text, $this->wall_id);
		if($post_id === 0) return Reporter::error_report(100);
		return Reporter::output(["post_id" => $post_id]);
	}
	
	public function removePost():bool{
		if(!Model::checkParametrs($_REQUEST,["post_id","token"]))
			return Reporter::error_report(1);
		if(!parent::setUserId($_REQUEST["token"])) return Reporter::error_report(101);
		if(!Model::setDBSession()) return false;
		if(!Model::removePost(self::$current_user_id, intval($_REQUEST["post_id"]))) return Reporter::error_report(12);
		return Reporter::output_no_errors();
	}
	
	
	
}