;(function(){


	const login = {
		"version": 1.0,
		"error": {
			1: "Неверный логин или пароль"
		},
		"email_id" : "email_row",
		"pswd_id": "pswd_row",
		"action" : "http://api.srv101017.hoster-test.ru/access-signIn"
	}

	login.sendPswd = function(){

		const eml = document.getElementById(login["email_id"]);
		const pswd = document.getElementById(login["pswd_id"]);

		if(eml.value.trim() == "") 
			eml.focus();
		else if(pswd.value.trim() == "") 
			pswd.focus();
		else{
			const formData = new FormData();
			formData.append('email', eml.value);
			formData.append('pswd', pswd.value);
			ajaxPost(login["action"], formData, login.answerHandler);
		}
		return false;
	}
	login.answerHandler = function(answer){
		const answerObj = JSON.parse(answer);
    	if(answerObj["error_code"] == 0){
    		console.log(answerObj);
    	}else{
    		error.outputError(answerObj["error_description"]);
    	}
    	

	}

	const error = {
		"version": 1.0,
		"IdOfErrorBlock" : "alert_error",
		"IdOfErrorText" : "error_text"
	}

	error.closeError = function(){
		document.getElementById(error.IdOfErrorBlock).style.display = "none";
	}
	error.outputError = function(str){
		const error_aria = document.getElementById(error.IdOfErrorBlock);
		error_aria.style.display = "block";
		document.getElementById(error.IdOfErrorText).innerHTML = str;
	}


	window.login = login;
	window.error = error;
})()