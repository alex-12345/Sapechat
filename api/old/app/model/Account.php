<?php 
namespace model;


class Account{
	
	
	/*
	 * Обновление токена
	 * @param str token
	 * @return boolean
	 */	
	 
	public function tokenExtension(string $token){
		global $db;
		$new_TTL = time() + (31 * 24 * 60 * 60);
		$collection = $db->sessions->tokens;
		
		$updateResult = $collection->updateOne(
			['token' => $token],
    		['$set' => ['expiration_time' => $new_TTL]]
		);
		return $updateResult->getModifiedCount();
	}
	
	
	/*
	 * удаление токена
	 * @param str token
	 * @return boolean
	 */	
	 
	public function tokenRemove(string $token){
		global $db;
		$collection = $db->sessions->tokens;
		
		$deleteResult = $collection->deleteOne(
			['token' => $token]
		);
		return $deleteResult->getDeletedCount();
	}
}