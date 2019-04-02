<?php 
namespace model;

use controllers\service\CheckRelation as CU;

class Post{
	use CU;
	
	
	/*
	 * Добавить новый пост
	 * @param int id
	 * @param int wall_id 
	 * @param str text
	 * @return int
	 */	
	 
	public function createNewPost(int $id, int $wall_id, string $text){
		
		$url = POSTS_URL."post-addPost?user_id=".$id."&wall_id=".$wall_id."&text=".urlencode($text)."&secret_key=".POSTS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['post_id']) and $arr['post_id'] !== 0){
				return $arr['post_id'];
		}
		else{
			return 0;
		}
	}
	
	/*
	 * удалить пост
	 * @param int user_id 
	 * @param int post_id 
	 * @return boolean
	 */	
	 
	public function removePost(int $id, int $post_id){
		$url = POSTS_URL."post-removePost?post_id=".$post_id."&user_id=".$id."&secret_key=".POSTS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and $arr['error'] === 0){
				return true;
		}
		else{
			return false;
		}
	}
}