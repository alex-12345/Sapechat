<?php

namespace controllers;

use model\Post as u_post;
use controllers\service\MainController;


class Post extends MainController{
	
	public function __construct(){
		parent::__construct();
	}
	/*
	 * Пригласить в друзья
	 * @param int text (get)
	 * @param int wall_id (get)
	 * http://localhost:8090/post-createNewPost?wall_id=7&text=dsfdsfsd&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function createNewPost(){
		if(!isset($_GET['wall_id']) or !isset($_GET['text']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$post = new u_post();
		if(intval($this->user_id) != intval($_GET['wall_id'])){
			$arr = $post->checkFriendRelation($this->user_id, intval($_GET['wall_id']));
			
			if(count($arr) == 0 or !isset($arr['relation info']['relation_status']) or $arr['relation info']['relation_status'] !== 2){
				systemError(1, "Данный пользователь не находить у вас в друзьях!");
			}
			unset($arr);
		}
		$post_id = $post->createNewPost($this->user_id, intval($_GET['wall_id']), $_GET['text']);
		
		if($post_id > 0){
			self::jsonOutput(["error" => 0, "post_id" => $post_id]);
			
		}else{
			systemError(2, "Неизвестная ошибка, вожможно перено соедиение с базой данных!");
		}
	}
	
	/*
	 * Удалить пост
	 * @param int post_id (get)
	 * http://localhost:8090/post-removePost?post_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function removePost(){
		if(!isset($_GET['post_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$post = new u_post();
		
		if($post->removePost($this->user_id, intval($_GET['post_id']))){
			self::jsonOutput(["error" => 0]);
			
		}else{
			systemError(1, "Этот пост либо не существует, либо вам не принадлежит!");
		}
	}
	
}

