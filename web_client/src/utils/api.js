import qs from 'qs';
import axios from 'axios';

function getRequestObject( url, method,data = null, type = 'application/x-www-form-urlencoded'){
    let obj = {
        method: method,
        url: 'http://api.sapechat.ru/' + url
    };
    if(method === "POST"){
      obj.headers = { 'content-type': type  }
      obj.data = data
    }
    return obj;
}  
  const apiCall = (url, method, data = null) => new Promise((resolve, reject) => {
      try {
        if(method === 'POST') data = qs.stringify(data)
        const query = getRequestObject(url, method, data)
       
        axios(query).then(resp =>  {
            resolve(resp.data)
        })
      } catch (err) {
        reject(new Error(err))
      }
  })

  const syncApiCall = (url, method, data = null) => {
    let xhr = new XMLHttpRequest();
    xhr.open(method, 'http://api.sapechat.ru/' + url, false); 
    if(method === 'POST') data = qs.stringify(data)
    const query = getRequestObject(url, method, data)
    xhr.send(query);
    if (xhr.status != 200) {
      console.log("Ошибка при обращании к серверу")
    } else 
      return JSON.parse(xhr.responseText) 
  
}
  
  export  {apiCall, syncApiCall}