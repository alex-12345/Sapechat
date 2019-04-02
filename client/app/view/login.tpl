<div class="main">
  
  <div id="loginBlock">
    <h1>Вход</h1>
    <p>Чтобы войти в ваш аккаунт, вам необходимо ввести логин и пароль! </p>
    <form onsubmit="return false">
      <label>E-mail</label>
      <input type="email" placeholder="Ваш email" id="email_row"  />
      <label>Пароль</label>
      <input type="password" placeholder="Ваш пароль" id="pswd_row" autocomplete="off" />
      <a href="" id="remembePswd">Забыли пароль?</a>
      <button onclick="login.sendPswd()">Войти</button>
    </form>
  </div>
</div>
<div id="alert_error">
    <div id="error_background" onclick="error.closeError()">
    </div>
    <div id="error_block">
      <div id="error_title">Ошибка авторизации!<button id="error_close" onclick="error.closeError()"><img src="app/view/css/images/close.png">
      </button></div>
      <p id="error_text"></p>
      
       
    </div>
  </div>
</body>
</html>