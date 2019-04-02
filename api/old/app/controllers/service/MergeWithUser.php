<?php

namespace controllers\service;

trait MergeWithUser{
	
	/*
	 * слияние массива вывода с данными из микросервиса пользователи
	 * @param array arr 
	 * @param string row 
	 * @return array
	 */	
	 
	public function mergeWithUser(array $arr, string $row){
		$arr_ids = [];
		foreach($arr as $key =>$value){
			array_push($arr_ids, $value[$row]);
		}
		$arr_r_ids = array_unique($arr_ids);
		$ids_str = implode(",", $arr_r_ids);
		$url = USERS_URL."users-getArrayUserDescription?ids=".$ids_str."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$users_arr = json_decode($content, true);
		
		$result_arr_user = [];
		foreach($users_arr as $key => $value){
			$result_arr_user[$value['user_id']] = ['user_first_name' => $value['user_first_name'], 'user_last_name' => $value['user_last_name'], 'user_img' => $value['user_img']];
		}
		foreach($arr as $key => $value){
			if(isset($result_arr_user[$value['user_id']]))
			{
				$arr[$key]['user_first_name'] = @$result_arr_user[$value[$row]]['user_first_name'];
				$arr[$key]['user_last_name'] = @$result_arr_user[$value[$row]]['user_last_name'];
				$arr[$key]['user_img'] = @$result_arr_user[$value[$row]]['user_img'];
				if(empty($result_arr_user[@$value[$row]]['user_img'])){ $arr[$key]['user_img']=NO_IMG;}
			}else{
				$arr[$key]['user_first_name'] = "Удаленный";
				$arr[$key]['user_last_name'] = "Пользователь";
				$arr[$key]['user_img'] =  NO_IMG."?s";
			}
			
		}
		return $arr;
		
	}	
	
}