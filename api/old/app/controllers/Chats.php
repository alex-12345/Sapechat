<?php

namespace controllers;

use model\chats as m_chat;
use controllers\service\MainController;
use controllers\service\MergeWithUser as MWU;


class Chats extends MainController{
	use MWU;
	
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 * Вывод части последних чатов пользователя
	 * @param int amount (get)
	 * @param int start (get)
	 * http://localhost:8090/chats-getLastsChats?amount=20&start=0&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function getLastsChats(){
		if(!isset($_GET['amount']) or !isset($_GET['start']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$chat = new m_chat();
		$arr = $chat->getLastChats($this->user_id, intval($_GET['amount']), intval($_GET['start']));
		if(count($arr) === 0){
			systemError(404, "Ошибка, ни одного чата не найдено!");
		}else{
			self::jsonOutput(["error" => 0, "chats" => self::mergeWithUser($arr, "user_id")]);
		}
	}
	/*
	 * Создать чат с добавлением двух пользователей 
	 * @param int creator_id (get)
	 * @param string chat_name (get)
	 * @param int add_id (get)
	 * http://localhost:8090/chats-createChat?craetor_id=1&add_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function createChat(){
		//сначала создается чат потом в него добавляются два пользователя
		
	}
	
	/*
	 * Добавить ids в чат 
	 * @param str ids (get)
	 * @param int chat_id (get)
	 * http://localhost:8090/chats-addUsersInChat?ids=1,2,3&chat_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function addUsersInChat(){
		/*
	     *  проверить id текущего пользователя на нахождение в чате 
		 *  посчитать количетво idsкоторые уже в чате
		 *  если count == 0 то добавить их всех
		 */
		if(!isset($_GET['ids']) or !isset($_GET['chat_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$chat = new m_chat();
		if($chat->checkUserInChat($this->user_id, $_GET['chat_id'])){
			if($chat->checkUsersInChat($_GET['ids'], $_GET['chat_id'])){
				if($chat->addUsersInChat($_GET['ids'], $_GET['chat_id'], $this->user_id)){
					// важно также в будущем написать проверку существования самих добавляемых пользователей
					self::jsonOutput(["error" => 0]);
				}
				else{
					systemError(3, "Пользователи не были добавленны в чат, так как их идентификаторы были повреждены!");
				}
			}
			else{
				systemError(2, "Какие-то из перечисленных пользователей уже есть в чате!");
			}
		}
		else{
			systemError(1, "Ошибка, вы не являетсь участником данного чата!");
		}
		
	}
	
	/*
	 * удалить пользователя из чата 
	 * @param int user_id (get)
	 * @param int chat_id (get)
	 * http://localhost:8090/chats-removeUserFromChat?user_id=6&chat_id=3&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function removeUserFromChat(){
		
		/* 
		 * проверить является ли текущая сессия хозяином чата или хозяином инвайта или самим удаляемым
		 * проверить наличие пользователя в чате
		 * если все верно - то удалить
		 */
		 
		if(!isset($_GET['user_id']) or !isset($_GET['chat_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$chat = new m_chat();
		if($this->user_id == intval($_GET['user_id']) or $chat->verificationChatOwnerships($this->user_id, $_GET['chat_id']) or $chat->checkInvite(intval($_GET['user_id']), $this->user_id, $_GET['chat_id'])){
			if($chat->deleteUserFromChat(intval($_GET['user_id']), intval($_GET['chat_id']))){
				self::jsonOutput(["error" => 0]);
			}else{
				systemError(2, "Ошибка, возможно данный пользователь уже был удален!");
			}
		}
		else{
			systemError(1, "Ошибка, у вас нет прав на данную операцию!");
		}
		
	}
	
	/*
	 * переименовать чат
	 * @param string new_title (get)
	 * @param int chat_id (get)
	 * http://localhost:8090/chats-chatRename?craetor_id=1&add_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function chatRename(){
		// проверить права текущей сессии на чат
		// если все ок, то переименовать 
		
	}
	
	/*
	 * сменить аватарку чата
	 * @param string new_img (get)
	 * @param int chat_id (get)
	 * http://localhost:8090/chats-chatRename?craetor_id=1&add_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function changeImg(){
		// проверить права текущей сессии на чат
		// если все ок, то сменить
		
	}
	
	/*
	 * вывод части последних сообщений из чата
	 * @param int chat_id (get)
	 * @param int start (get)
	 * @param int amount (get)
	 * http://localhost:8090/chats-outputLastMassages?craetor_id=1&chat_id=1&start=2&amount=10&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function outputLastMassages(){
		/*
		 * проверить наличие пользователя в чате
		 * если все ок, то вывести
		 */
		if(!isset($_GET['start']) or !isset($_GET['amount']) or !isset($_GET['chat_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$chat = new m_chat();
		if($chat->checkUserInChat($this->user_id, $_GET['chat_id'])){
			$massages_arr = $chat->chatOutput(intval($_GET['chat_id']), intval($_GET['start']), intval($_GET['amount']));
			
			if(count($massages_arr) > 0){
				self::jsonOutput(["error" => 0, "massages" => self::mergeWithUser($massages_arr, "user_id")]);
			} else{
				systemError(2, "По указанным параметрам сообщений не найдено!");
			}
		}else{
			systemError(1, "Ошибка. Ваш профиль отсутствует в чате!");
		}
	}
	/*
	 * добавить сообщение в чат
	 * @param int chat_id (get)
	 * @param string text (get)
	 * http://localhost:8090/chats-addMsgInChat?chat_id=1&text=dfsf&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function addMsgInChat(){
		/*
		 * проверить наличие пользователя в чате
		 * если все ок, то добавить сообщение
		 */
		if(!isset($_GET['chat_id']) or !isset($_GET['text']) or empty($_GET['text'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$chat = new m_chat();
		if($chat->checkUserInChat($this->user_id, $_GET['chat_id'])){
			$msg_id = $chat->addMassageInChat($this->user_id, intval($_GET['chat_id']), $_GET['text']);
			if($msg_id){
				self::jsonOutput(["error" => 0, "massage_id" => $msg_id]);
			} else{
				systemError(2, "Неизвестная ошибка");
			}
		}else{
			systemError(1, "Ошибка. Ваш профиль отсутствует в чате!");
		}
	}	
	
	
	/*
	 * удалить сообщение из чата
	 * @param int msg_id (get)
	 * http://localhost:8090/chats-removeMsg?msg_id=13&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function removeMsg(){
		/*
		 * проверить принадлежность сообщения пользователю
		 * если все ок, то удалить
		 */
		if(!isset($_GET['msg_id'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$chat = new m_chat();
		if($chat->CheckMsgUser($this->user_id, intval($_GET['msg_id']))){
			if($chat->removeMsg(intval($_GET['msg_id']))){
				self::jsonOutput(["error" => 0]);
			} else{
				systemError(2, "Неизвестная ошибка");
			}
		}else{
			systemError(1, "Ошибка. У вас нет прав на удаление данного сообщения!");
		}
	}	
	
	
}

