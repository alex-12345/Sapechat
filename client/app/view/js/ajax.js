function ajaxPost(url, data, callback){
		const request = new XMLHttpRequest();
		request.addEventListener('load', function(){
			callback(request.responseText);
		})
		request.open('POST', url);
		request.send(data);
}

