import qs from 'qs';
import axios from 'axios';

function getRequestObject(data, url, method, type = 'application/x-www-form-urlencoded'){
    return {
        method: method,
        headers: { 'content-type': type  },
        data: qs.stringify(data),
        url: 'http://api.sapechat.ru/' + url,
    };
}  
  const apiCall = (url, method, data) => new Promise((resolve, reject) => {
      try {
        const query = getRequestObject(data, url, method)
       
        axios(query).then(resp =>  {
            resolve(resp.data)
        })
      } catch (err) {
        reject(new Error(err))
      }
  })
  
  export default apiCall